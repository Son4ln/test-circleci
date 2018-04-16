<?php

namespace App\Http\Controllers;

use App\CreativeRoom;
use App\ProjectFile;
use App\Repositories\Interfaces\FileRepositoryInterface;
use App\Repositories\Interfaces\CreativeRoomRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Mail;
use App\Mail\PreviewFile;
use App\Mail\DeliveryFile;
use App\Events\EmailShouldBeSent;
use App\CreativeroomPreview;

class FileController extends Controller
{
    const FILES_PER_PAGE = 20;

    /**
     * @var FileRepository
     */
    protected $repository;

    /**
     * @var CreativeRoomRepository
     */
    protected $creativeRoomRepository;

    /**
     * @var array
     */
    protected $kinds = [
        'deliver' => ProjectFile::DELIVER_FILE,
        'file'    => ProjectFile::PROJECT_FILE,
        'preview' => ProjectFile::PREVIEW_FILE,
    ];

    /**
     * Create a new controller instance.
     *
     * @param FileRepositoryInterface $repository
     * @param CreativeRoomRepositoryInterface $creativeRoomRepository
     */
    public function __construct(
        FileRepositoryInterface $repository,
        CreativeRoomRepositoryInterface $creativeRoomRepository
    ) {
        $this->repository = $repository;
        $this->creativeRoomRepository = $creativeRoomRepository;
        $this->middleware('auth');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  string                   $type
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $type)
    {
        $this->validate($request, ['path' => 'required']);
        $id = $request->creativeroom_id;

        /** @var CreativeRoom $project */
        $room = $this->creativeRoomRepository
            ->findOrFail($id);

        // check permission
        $this->authorize('upload', $room);

        $input = $request->except('_method', '_token', 'MAX_FILE_SIZE', 'thumb_path');
        $input['user_id']    = $request->user()->id;
        if ($type != 'file') {
            $input['thumb_path'] = explode('?', $request->input('thumb_path'))[0];
        }
        $input['path']       = explode('?', $input['path'])[0];
        $input['mime']       = $input['mime'] ? $input['mime']: 'text';
        $this->repository->create($input);

        // Response preview files list
        switch ($input['kind']) {
            case ProjectFile::PREVIEW_FILE:
                /** @var LengthAwarePaginator $files */
                $files = $room->previewFiles()
                    ->orderByDesc('created_at')
                    ->paginate(self::FILES_PER_PAGE);
                //previewFiles->setPath('/ajax/work/file');
                event(new EmailShouldBeSent(new PreviewFile($room->title)));
                $view = 'widget.messages.preview_list';
                break;
            case ProjectFile::PROJECT_FILE:
                $files = $room->projectFiles()
                    ->orderByDesc('created_at')
                    ->paginate(self::FILES_PER_PAGE);
                $view = 'widget.work_file';
                break;
            default:
                /** @var LengthAwarePaginator $files */
                $files = $room->deliverFiles()
                    ->orderByDesc('created_at')
                    ->paginate(self::FILES_PER_PAGE);
                event(new EmailShouldBeSent(new DeliveryFile($room->title)));
                //previewFiles->setPath('/ajax/work/file');
                $view = 'creative-rooms.partials.delivery_files';
                break;
        }

        return empty($view) ? '' : view($view, compact('files', 'room'));
    }

    /**
     * @param Request $request
     * @param string  $id
     * @return mixed
     */
    public function destroy(Request $request, $id)
    {
        $file = $this->repository->findOrFail($id);

        $this->authorize('delete', $file);
        $arrayPath = explode("amazonaws.com/", $file->path);
        $filePath = end($arrayPath);
        Storage::disk('s3')->delete($filePath);
        $file->delete();

        return;
    }

    /**
     * Download file
     */
    public function download($id)
    {
        $file = ProjectFile::findOrFail($id);

        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=" . $file->title);
        header("Content-Type: " . $file->mime);

        return readfile($file->path);
    }


    /**
     * Stream video
     */
    // public function stream($id) {
    //     $video  = $this->repository->findOrFail($id);
    //     $path   = Storage::disk('s3')->url($video->path);
    //     $stream = new VideoStream($path);
    //     $stream->start();
    // }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getCaptions(Request $request)
    {
        $file = ProjectFile::with(['captions' => function($query) {
            $query->with('user:id,name,photo')->latest();
        }])->findOrFail($request->input('file_id'));
        $captions = $file->captions;
        $results = [];

        //TODO: transform data previews
        foreach ($captions as $caption) {
            $item = [];
            $item['short_text'] = mb_strimwidth($caption->title['text'], 0, 40, "...");
            $item['text'] = $caption->title['text'];
            $item['start'] = $caption->start;
            $item['start_format'] = gmdate('H:i:s', $caption->start);
            $item['name'] = $caption->user->name;
            $item['photo'] = $caption->user->photo_url;
            $item['id'] = $caption->id;
            $item['title'] = $caption->title;
            $item['status'] = $caption->state;
            $item['kind'] = $caption->kind;
            $results[] = $item;
        }

        return response()->json($results);
    }

    /**
     * Change caption state
     */
    public function updateState(Request $request)
    {
        CreativeroomPreview::where('id', $request->input('id'))
            ->update(['state' => $request->input('state')]);

        return response(200);
    }

    /**
     * Get preview files lists
     *
     * @param int $id
     * @return Illuminate\Http\Response
     */
    public function previewFiles($id)
    {
        $room = $this->creativeRoomRepository->findOrFail($id);
        $files = $room->previewFiles()
            ->orderByDesc('created_at')
            ->paginate(self::FILES_PER_PAGE);

        return view('widget.messages.list_no_upload', compact('files'));
    }

    public function workFiles($id)
    {
        $room = $this->creativeRoomRepository->findOrFail($id);
        $files = $room->projectFiles()
            ->orderByDesc('created_at')
            ->paginate(self::FILES_PER_PAGE);

        return view('creative-rooms.partials.message_files', compact('files', 'id'));
    }
}
