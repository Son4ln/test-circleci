<?php

namespace App\Http\Controllers;

use App\CreativeRoom;
use App\CreativeroomUser;
use App\Proposal;
use App\Project;
use App\ProjectFile;
use App\User;
use App\Repositories\ActivationTokenRepository;
use App\Repositories\Interfaces\CreativeRoomRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Laravel\FlashMessage\Facades\Flash;
use App\Events\EmailShouldBeSent;
use App\Mail\ProjectStarted;
use App\Mail\ProjectApproval;
use DB;


class CreativeRoomsController extends Controller
{
    const ROOM_PER_PAGE     = 20;
    const FILES_PER_PAGE    = 20;
    const MESSAGES_PER_PAGE = 10;
    const REVIEW_FILE_TYPE  = 2;
    const DELIVER_FILE_TYPE = 3;

    /**
     * @var CreativeRoomRepositoryInterface
     */
    protected $repository;

    /**
     * ActivationTokenRepository
     */
    protected $activationToken;

    /**
     * Create a new controller instance.
     *
     * @param CreativeRoomRepositoryInterface $repository
     */
    public function __construct(CreativeRoomRepositoryInterface $repository,
                                ActivationTokenRepository $activationToken)
    {
        $this->repository = $repository;
        $this->activationToken = $activationToken;
        $this->middleware('auth');
    }

    /**
     * 一覧
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rooms = $this->repository->joinedRooms(['title', 'id', 'updated_at', 'thumbnail', 'user_id', 'deleted_at', 'label'])->latest()
        ->paginate(self::ROOM_PER_PAGE);

        return view('creative-rooms.list', compact('rooms'));
    }

    /**
     * 新規作成
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('creative-rooms.partials.create');
    }

    /**
     * 新規作成
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function createAjax(Request $request)
    {
        $input = $request->except('_token');

        return view('widget.creative-rooms.create', compact('input'));
    }

    /**
     * 新規作成
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', CreativeRoom::class);
        //TODO: validate request
        list($rules, $messages) = $this->getValidation();
        $this->validate($request, $rules, $messages);

        $input = [
            'title' => $request->input('title'),
            'desc' => $request->input('desc'),
            'user_id' => Auth::user()->id,
            'invitation_token' => Str::random(10)
        ];

        if ($request->hasFile('thumbnail')) {
            $input['thumbnail'] = $request->thumbnail->storePublicly('creative_rooms/'.Auth::id(), 's3');
        } else {
            $input['thumbnail'] = config('const.creative_room_thumbnails.' . rand(0, 9));
        }

        //TODO: save creative room
        $creativeRoom = $this->repository->create($input);

        $creativeRoom->creativeroomUsers()->create([
            'user_id' => Auth::user()->id,
            'role' => CreativeroomUser::MASTER_ROLE,
            'state' => 1,
        ]);

        return redirect()->to('/creative-rooms')
            ->with('success', __('flash_messages.rooms.store_success'));
    }

    /**
     * 新規作成
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function ajaxStore(Request $request)
    {
        $project = Project::findOrFail($request->input('project_id'));
        $user = User::findOrFail($request->input('user_id'));

        $this->authorize('acceptProposal', $project);

        $creativeRoom = $this->createRoom($request, $project);
        $project->started();

        //$request->input('user_id')

 //       $project_type = $project->is_certcreator == 1 ? '認定クリエイター': 'セルフコンペ';
 //       Mail::to($user->email)->queue(new ProjectApproval( $project_type, $project->title));

        $proposal = Proposal::findOrFail($request->input('proposal_id'));
        $proposal->fill(['offer' => 1, 'room_id' => $creativeRoom->id]);
        $proposal->save();

        $project->fill(['estimate' => $proposal->price]);
        $project->save();

        Flash::success(__('flash_messages.rooms.alt_store_success'))->important();

        return redirect()->back();
    }

    /**
     * Create room
     */
    protected function createRoom($request, $project)
    {
        $thumbnail = $project->image ? $project->image : '';

        //TODO: save creative room
        $creativeRoom = $this->repository->create([
            'title'      => $project->title,
            'user_id'    => $request->input('owner_id'),
            'project_id' => $request->input('project_id'),
            'invitation_token' => Str::random(10),
            'thumbnail' => $thumbnail
        ]);

        $creativeRoom->creativeroomUsers()->createMany([
            [
                'user_id' => $request->input('owner_id'),
                'role' => CreativeroomUser::MASTER_ROLE,
                'state' => 1,
            ],
            [
                'user_id' => $request->input('user_id'),
                'role' => CreativeroomUser::MEMBER_ROLE,
                'state' => 1,
            ]
        ]);

        return $creativeRoom;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $room = Creativeroom::with('project:id,estimate,describe,title')
        ->with(['roomUsers' => function($q) {
            $q->select('name', 'photo', 'photo_thumbnail')
                ->where('state', 1);
        }])->findOrFail($id);

        $this->authorize('show', $room);

        list($messages, $infos) = $this->getRoomMessage($room);

        // get review files
        $previewFiles = $room->previewFiles()
            ->orderByDesc('created_at')
            ->paginate(self::FILES_PER_PAGE);
        // get deliver files
        $deliverFiles = $room->deliverFiles()
            ->orderByDesc('created_at')
            ->paginate(self::FILES_PER_PAGE);

        // get deliver files
        $files = $room->projectFiles()
            ->orderByDesc('created_at') ->paginate(self::FILES_PER_PAGE)->setPath(route('files.project',['id' => $id]));
           // ->paginate();

        return view('creative-rooms.alt_show',
            compact(
                'room',
                'messages',
                'previewFiles',
                'deliverFiles',
                'infos',
                'files',
                'id'
            )
        );
    }

    /**
     * Get member list
     */
    public function getMember($id)
    {
        $room = CreativeRoom::with(['creativeroomUsers' => function($query) {
            $query->with('user:id,name');
        }])->withCount(['roomUsers' => function($query) {
            $query->where('state', 1);
        }])->findOrFail($id);

        return view('widget.messages.member', compact('room'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $room = $this->repository->findOrFail($id);

        return view('creative-rooms.partials.edit', compact('room'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        list($rules, $messages) = $this->getValidation();
        $this->validate($request, $rules, $messages);
        $room = $this->repository->findOrFail($id);
        $this->authorize('update', $room);

        $input = $request->only(array_keys($rules));
        //Save thumbnail
        if ($request->hasFile('thumbnail')) {
            $input['thumbnail'] = $request->thumbnail->storePublicly('creative_rooms/'.Auth::id(), 's3');
        } elseif (!$room->thumbnail) {
            $input['thumbnail'] = config('const.creative_room_thumbnails.' . rand(0, 9));
        }

        $room->fill($input);
        $room->save();
        if( isset( $room->title ) )
            Flash::success(__('flash_messages.rooms.update_success', ['project_name' => $room->title]))->important();
        else
            Flash::success(__('flash_messages.rooms.update_success', ['project_name' => '']))->important();
       

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $room = CreativeRoom::findOrFail($id);
        $this->authorize('delete', $room);
        $room->delete();

        if( isset( $room->title ) )
            $message = __('flash_messages.rooms.destroy_success_update', ['project_name' => $room->title]);
        else
            $message = __('flash_messages.rooms.destroy_success_update', ['project_name' => '']);
            
        Flash::success($message)->important();

        return redirect()->to('/creative-rooms');
    }

    /**
     * Get invitation link
     */
    public function getLink(Request $request)
    {
        $token = Str::random(10);

        $id = $request->input('id');

        CreativeRoom::where('id', $id)->update(['invitation_token' => $token]);

        return route('rooms.accept', compact('id', 'token'));
    }

    /**
     * Accept invitation
     */
    public function accept($id, $token)
    {
        $room = CreativeRoom::findOrFail($id);

        if ($token == $room->invitation_token) {
            if (CreativeroomUser::where(['creativeroom_id' => $id, 'user_id' => Auth::id()])->exists()) {
                Flash::warning(__('flash_messages.rooms.accept_warning'));
                return view('layouts.ample');
            }
            CreativeroomUser::create([
                'creativeroom_id' => $id,
                'user_id'         => Auth::id()
            ]);

            Flash::success(__('flash_messages.rooms.accept_success', ['name' => $room->title]));
            return view('layouts.ample');
        }

        abort(403);
    }

    /**
     * Master accept
     */
    public function masterAccept(Request $request)
    {
        $user = CreativeroomUser::findOrFail($request->input('id'));

        $room = $user->creativeRoom;

        $this->authorize('addUser', $room);

        if ($user) {
            $user->update(['state' => 1]);
            $usersCount = \App\CreativeroomUser::where('creativeroom_id', $room->id)
                ->where('state', 1)->count();
            return response()->json(['count' => config('const.c_base_user_limit') - $usersCount]);
        }

        abort(401);
    }

    /**
     * Change c-base label
     */
    public function updateLabel(Request $request)
    {
        $room = CreativeRoom::findOrFail($request->input('id'));
        $this->authorize('update', $room);

        $room->fill(['label' => $request->input('label')]);
        $room->save();

        return response(200);
    }

    /**
     * Validate creative room data
     *
     * @return array
     */
    protected function getValidation()
    {
        $rules = [
            'title' => 'required|max:255',
            'desc' => 'required|max:4000',
        ];
        $messages = [
            // 'title.required' => 'Title is required!'
        ];

        return [$rules, $messages];
    }

    /**
     * Verify token and add user to room
     *
     * @param  string|int $creativeRoomId
     * @param  string|int $userId
     * @return \Illuminate\Http\Response
     */
    public function removeUser($id)
    {
        $user = CreativeroomUser::findOrFail($id);

        $room = $user->creativeRoom;
        $this->authorize('removeUser', $room);

        if ($user) {
            $user->delete();
            $usersCount = \App\CreativeroomUser::where('creativeroom_id', $room->id)
                ->where('state', 1)->count();
            return response()->json(['count' => config('const.c_base_user_limit') - $usersCount]);
        }

        abort(401);
    }

    /**
     *Download file in Preview Room / 納品ファイル一覧
     */
    public function downloadFile(){

                set_time_limit(0);



                if( !empty($_POST) ){
                    try {
                        $tempDownloadPrivew = 'temp_download/'.date('Y/m/d');
                        $name = 'Preview_Room_'.date('YmdHis');
                        $fReturn  = '/temp_download/'.date('Y/m/d/').$name;
                        $folderDownload = public_path().$fReturn;
                        $s = '/public/temp_download/'.date('Y/m/d/').$name;
                        $arrayFolder = explode('/', $tempDownloadPrivew);

                        $folderName = '';
                        foreach ($arrayFolder as $folder){
                            $folderName .= '/'.$folder;
                            $path = public_path().$folderName;

                            if(!file_exists($path)){
                                mkdir($path,0777);
                            }

                        }
                        mkdir($folderDownload,0777);
                        foreach ($_POST as $key=>$fileUrl){
                            $key++;
                            $fName = explode('/', $fileUrl);
                            file_put_contents($folderDownload.'/'.$key.'_'.urldecode(end($fName)), fopen($fileUrl, 'r'));
                        }

                        $zipFile = $folderDownload.".zip";
                        zipData($folderDownload, $folderDownload.".zip");
                        delete_directory($folderDownload);

                        $returnArr = array(
                            'file_name' => $fReturn,
                            'status' => 1,

                        );

                        echo json_encode($returnArr);
                        exit;

                    } catch (\Exception $e) {

                        $returnArr = array(
                            'file_name' => $name,
                            'status' => 0,
                            'message' =>  $e->getMessage()
                        );

                        echo json_encode($returnArr);
                        exit;
                    }
                }
            }

            public function getfile(){
                if(isset( $_GET['name'] ) && !empty( $_GET['name'] )){

                    $filepath = public_path().urldecode($_REQUEST["name"]).'.zip';

                    // Process download
                    if(file_exists($filepath)) {
                        header('Content-Description: File Transfer');
                        header('Content-Type: application/octet-stream');
                        header('Content-Disposition: attachment; filename="'.basename($filepath).'"');
                        header('Expires: 0');
                        header('Cache-Control: must-revalidate');
                        header('Pragma: public');
                        header('Content-Length: ' . filesize($filepath));
                        flush(); // Flush system output buffer
                        readfile($filepath);
                        if (file_exists($filepath)) {
                            unlink( $filepath );
                        }
                        exit;
                    }else{
                        abort(404);
                    }
                }else{
                    abort(404);
                }
            }

    /**
     * Get all rooms messages
     */
    protected function getRoomMessage($room)
    {
        $pages = 20;
        $messages = \App\CreativeroomMessage::join('users','users.id','creativeroom_messages.user_id')
            ->select(DB::raw('creativeroom_messages.id, creativeroom_messages.files, creativeroom_messages.message, creativeroom_messages.created_at, creativeroom_messages.user_id, users.name as user_name, users.photo as user_photo')) 
            ->where([
                ['creativeroom_messages.kind', CreativeRoom::NORMAL_MESSAGE_TYPE],
                ['creativeroom_messages.creativeroom_id', $room->id ]
            ])
            ->whereNotNull('creativeroom_messages.creativeroom_id')
            ->latest('creativeroom_messages.created_at')->take($pages)->get()->reverse(); 

        $infos = \App\CreativeroomMessage::join('users','users.id','creativeroom_messages.user_id')
            ->select(DB::raw('creativeroom_messages.id, creativeroom_messages.files, creativeroom_messages.message, creativeroom_messages.created_at, creativeroom_messages.user_id, users.name as user_name, users.photo as user_photo'))
            ->where([
                ['creativeroom_messages.kind', CreativeRoom::CRLUO_MESSAGE_TYPE],
                ['creativeroom_messages.creativeroom_id', $room->id ]
            ])
            ->whereNotNull('creativeroom_messages.creativeroom_id')
            ->where(function($query) {
                $query->where('creativeroom_messages.user_id', Auth::id())
                    ->orWhere('creativeroom_messages.is_public', 1)
                    ->orWhere('creativeroom_messages.recipient_id', Auth::id());
            })->latest('creativeroom_messages.created_at')->take($pages)->get()->reverse();

        return [$messages, $infos];
    }

    public function testUploadFile(){
        return view('creative-rooms.upload');
    }

}

