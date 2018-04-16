<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Repositories\MessageBoxRepository;
use App\CreativeRoom;

class AdminController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Admin Controller
    |--------------------------------------------------------------------------
    |
    | This controller renders your application's "dashboard" for users that
    | are authenticated. Of course, you are free to change or remove the
    | controller as you wish. It is just here to get your app started!
    |
    */

    /**
     * @var int
     */
    protected $pages = 10;

    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * @var MessageBoxRepository
     */
    protected $messagesRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $userRepository,
        MessageBoxRepository $messageRepository)
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
        $this->userRepository    = $userRepository;
        $this->messageRepository = $messageRepository;
    }

    /**
     * Show admin panel
     */
    public function index(Request $request)
    {
        $users = $this->userRepository->getAllUsers($request->except('_token'))->orderBy("id")
            ->paginate($this->pages)->setPath(route('admin'));
        // $data['creatorMessages'] = $this->messageRepository->getCreatorMessages();
        // $data['clientMessages']  = $this->messageRepository->getClientMessages();
        if ($request->ajax()) {
            return view('admin.partials.users_list', compact('users'));
        }
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show admin messages
     */
    public function messages()
    {
        $allUsers    = $this->userRepository->getActivatedUsers();
        $messages    = $this->messageRepository
            ->latest()->paginate($this->pages)
            ->setPath('/messages/filter');

        return view('admin.messages', compact('allUsers', 'messages'));
    }

    /**
     *
     */
    public function roomList()
    {
        $rooms = CreativeRoom::select('creative_rooms.id', 'title')
            ->with(['roomUsers' => function($query) {
                $query->select('users.id', 'name');
            }])->orderBy('id', 'DESC')->paginate(10);

        return view('admin.rooms.index', compact('rooms'));
    }

    /**
     * Show specfic room
     */
    public function showRoom($id)
    {
        $room = CreativeRoom::with(['roomUsers' => function($query) {
            $query->select('users.id', 'name');
        }])->findOrFail($id);

        list($messages, $infos) = $this->getRoomMessage($room);

        // get review files
        $previewFiles = $room->previewFiles()
            ->orderByDesc('created_at')
            ->paginate($this->pages);

        // get deliver files
        $deliverFiles = $room->deliverFiles()
            ->orderByDesc('created_at')
            ->paginate($this->pages);

        // get deliver files
        $files = $room->projectFiles()
            ->orderByDesc('created_at')
            ->paginate($this->pages);

        return view('admin.rooms.show', compact('room', 'files', 'messages', 'infos', 'previewFiles', 'deliverFiles'));
    }

    /**
     * Get messages
     */
    protected function getRoomMessage($room)
    {
        $pages = 20;
        $messages = $room->messages()
            ->with('user')
            ->where('kind', CreativeRoom::NORMAL_MESSAGE_TYPE)
            ->latest()->take($pages)->get()->reverse();

        $infos = $room->messages()
            ->where([
                'kind' => CreativeRoom::CRLUO_MESSAGE_TYPE,
                'recipient_id' => 0
            ])
            ->latest()->take($pages)->get()->reverse();

        return [$messages, $infos];
    }

}
