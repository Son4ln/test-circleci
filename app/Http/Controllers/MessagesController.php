<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\CreativeroomMessageRepositoryInterface;
use App\Repositories\Interfaces\CreativeRoomRepositoryInterface;
use Mail;
use App\Mail\HasCrluoMessage;
use App\Mail\RoomHasMessage;
use App\CreativeroomUser;
use App\Events\EmailShouldBeSent;
use App\Events\MessageReceived;
use App\Events\CrluoMessageReceived;
use Auth;
use App\Notifications\AlertRoomMessage;

class MessagesController extends Controller
{
    const MESSAGES_PER_PAGE   = 10;
    const NORMAL_MESSAGE_TYPE = 1;

    /**
     * @var CreativeroomMessageRepositoryInterface
     */
    protected $messageRepository;

    /**
     * @var CreativeRoomRepositoryInterface
     */
    protected $roomRepository;

    /**
     * Create a new controller instance.
     *
     * @param CreativeRoomRepositoryInterface $repository
     */
     public function __construct(CreativeroomMessageRepositoryInterface $messageRepository,
        CreativeRoomRepositoryInterface $roomRepository)
     {
         $this->messageRepository = $messageRepository;
         $this->roomRepository    = $roomRepository;
         $this->middleware('auth');
     }

    /**
     * メッセージボックス
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        dd(__METHOD__);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $room = $this->roomRepository->findOrFail($request->input('creativeroom_id'));
        $this->authorize('show', $room);
        $this->validate($request, [
            'message' => 'required_if:files,[]|max:4000',
            'files'   => 'required_if:message,'
        ],[
            'message.required_if' => 'メッセージを入力してください'
        ]);

        $input = $request->only('creativeroom_id', 'kind', 'message');
        $input['files'] = $request->input('files');
        $input['user_id'] = $request->user()->id;
        if ($request->has('recipient_id')) {
            $input['recipient_id'] = $request->input('recipient_id');
            if ($input['recipient_id'] == 0) $input['is_public'] = 1;
        }
        $files = $room->files()->createMany($this->filesToArray($request->input('files')));
        $message = $this->messageRepository->create($input);

        // Get return messages
        if($request->input('kind') == self::NORMAL_MESSAGE_TYPE) {
            $users = CreativeroomUser::with(['user' => function($query) {
                $query->select('id', 'email');
            }])->where('creativeroom_id', $room->id)->get();

            broadcast(new MessageReceived($message))->toOthers();
            foreach ($users as $roomUser) {
                $user = $roomUser->user;
                if ($user->email == $request->user()->email) {
                    continue;
                }

                Mail::to($user->email)->queue(new RoomHasMessage($room, $roomUser->role,$request->user(),$message));
                $user->notify(new AlertRoomMessage($room, $message->kind));
            }
        } else {
            if (!$request->user()->hasRole('admin')) {
                event(new EmailShouldBeSent(new HasCrluoMessage($room->title)));
            }
            if ($message->recipient_id != 0) {
                $user = \App\User::findOrFail($message->recipient_id);
                $user->notify(new AlertRoomMessage($room, $message->kind));
            }
            $this->broadcastCrluo($message);
        }

        if (strpos(request()->headers->get('referer'), 'admin')) {
            return view('admin.rooms.partials.single_message', compact('message'));
        }


        //by dk Mor
        $info_user = $message->user;
        $message->user_photo =  $info_user->photo;
        $message->user_name = $info_user->name;


        return view('creative-rooms.partials.message_template', compact('message'));
    }

    /**
     * Broadcast crluo message
     */
    protected function broadcastCrluo($message)
    {
        if ($message->recipient_id) {
            broadcast(new CrluoMessageReceived($message, $message->recipient_id))->toOthers();
        } elseif ($message->is_public) {
            $users = CreativeroomUser::where('creativeroom_id', $message->creativeroom_id)
                ->pluck('user_id')->all();
            foreach ($users as $user) {
                broadcast(new CrluoMessageReceived($message, $user))->toOthers();
            }
        } else {
            broadcast(new CrluoMessageReceived($message, Auth::id()))->toOthers();
        }
    }

    /**
     * Reload all messages.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    // public function reloadMessage(Request $request)
    // {
    //     $room     = $this->roomRepository->findOrFail($request->input('creativeroom_id'));
    //     $messages = $room->creativeroomMessages()
    //         ->paginate(self::MESSAGES_PER_PAGE)
    //         ->setPath('/messages/reload');
    //
    //     return view('widget.messages.messages', compact('messages'));
    // }
    //
    // public function reloadCrluoMessage(Request $request)
    // {
    //     $room     = $this->roomRepository->findOrFail($request->input('creativeroom_id'));
    //     $infos    = $room->crluoMessages()->paginate(self::MESSAGES_PER_PAGE)
    //         ->setPath('/messages/creload');
    //     return view('widget.messages.crluo_messages', compact('infos'));
    // }

    /**
     * Convert json which contain files to saveable array
     */
    public function filesToArray($files)
    {
        $files = json_decode($files, true);
        if (!$files) return [];
        $fileStore = [];

        foreach ($files as $file) {
            $fileStore[] = [
                'title'   => $file['name'],
                'mime'    => isset($file['thumb']) ? 'image' : 'other',
                'path'    => $file['path'],
                'user_id' => Auth::id(),
                'thumb_path' => isset($file['thumb']) ? $file['thumb'] : '',
            ];
        }
        return $fileStore;
    }
}
