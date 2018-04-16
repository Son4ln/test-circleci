<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\MessageBoxRepository;
use App\Repositories\UserRepository;
use Auth;

class MessageBoxController extends Controller
{
    const MESSAGE_PER_PAGE = 10;

    /**
     * @var MessageBoxRepository
     */
     protected $messageRepository;

     /**
      * @var UserRepository
      */
     protected $userRepository;

    /**
     * Create a new controller instance.
     *
     * @param MessageBoxRepository $repository
     */
     public function __construct(MessageBoxRepository $messageRepository,
        UserRepository $userRepository)
     {
         $this->messageRepository = $messageRepository;
         $this->userRepository    = $userRepository;

         $this->middleware('auth');
     }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $members = $this->userRepository->getPartnerByUserId(Auth::user()->id);
        if ($request->user_id) {
            $this->messageRepository->markReadedMessage($request->input('user_id'));
            $messages = $this->messageRepository
                ->getMessagesByUserId($request->input('user_id'))
                ->latest()
                ->paginate(self::MESSAGE_PER_PAGE);
            $id = $request->input('user_id');
        }
        return view('chat', compact('members', 'messages', 'id'));
    }

    /**
     * Show form for create messages
     *
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Http\Response
     */
    public function getChatDialog(Request $request)
    {
        $input = $request->except('_method', '_token');

        $this->messageRepository->markReadedMessage($request->input('user_id'));
        $messages = $this->messageRepository
            ->getMessagesByUserId($request->input('user_id'))
            ->paginate(self::MESSAGE_PER_PAGE);
        $id = $request->input('user_id');
        return  view('widget.chat', compact('messages', 'id'));
    }

    /**
     * Show messages list
     *
     * @param Illuminate\Http\Request $request
     * @param Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        $filters = $request->except('_token');

        $messages = $this->messageRepository->getMessagesByFilter($filters)
            ->paginate(self::MESSAGE_PER_PAGE)
            ->setPath('/messages/filter');

        return view('dashboards.partials.messages', compact('messages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->except('_method', '_token');
        $this->messageRepository->create($input);
        return;
    }
}
