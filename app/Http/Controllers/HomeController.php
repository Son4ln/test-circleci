<?php

namespace App\Http\Controllers;

use App\Project;
use App\Proposal;
use App\User;
use App\Repositories\UserRepository;
use App\Repositories\MessageBoxRepository;
use App\Repositories\NotificationRepository;
use Auth;
use Illuminate\Http\Request;

class HomeController extends Controller {

    /*
    |--------------------------------------------------------------------------
    | Home Controller
    |--------------------------------------------------------------------------
    |
    | This controller renders your application's "dashboard" for users that
    | are authenticated. Of course, you are free to change or remove the
    | controller as you wish. It is just here to get your app started!
    |
    */

    /* const*/
    public $pages = 10;

    /**
     * @var FileRepository
     */
    protected $userRepository;

    /**
     * @var CreativeroomMessageRepository
     */
    protected $messagesRepository;

    /**
     * @var NotificationRepository
     */
    protected $notificationRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $userRepository,
        MessageBoxRepository $messageRepository,
        NotificationRepository $notificationRepository)
    {
        $this->middleware('auth');
        $this->userRepository         = $userRepository;
        $this->messageRepository      = $messageRepository;
        $this->notificationRepository = $notificationRepository;
    }

    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */
    public function index()
    {

        $data = [];
        $data['notifications'] = $this->notificationRepository
            ->getUserNotifications(['created_at','title','message']);

        if (Auth::user()->isCreator()) {
            $data['making'] =  Project::join(\DB::raw('(select count(*) as proposals_count,project_id from proposals where offer is not null AND user_id = '.Auth::id().' GROUP BY project_id) as p1'),function($join){
                        $join->on('p1.project_id','=','projects.id');
                })
                ->join('proposals as p2','p2.project_id','=','projects.id')
                ->where('p1.proposals_count','>',0)
                ->where('projects.status', Project::STARTED_STATUS)
                ->where('p2.offer',1)
                ->select(\DB::raw("projects.title,p2.room_id,projects.duedate_at,projects.price_min,projects.price_max,projects.image"))
                ->take(1)->first();

            $data['proposals'] = Proposal::join('projects','projects.id','=','proposals.project_id')
                ->where('proposals.user_id', Auth::user()->id)
                ->whereNull('proposals.offer')
                ->select('proposals.project_id','projects.title as project_title','proposals.created_at')
                ->take(5)->get();
        }

        if (Auth::user()->isClient()) {
            // Latest compose project
            $data['projects'] = Project::latestPropose()->get();
        }

        return view('dashboards.index', $data);
    }

    /**
     * Get user list
     */
    public function userList()
    {
        $users = $this->userRepository->paginate($this->pages);
    }

    /**
     * Switch client and creator mode
     *
     * @return Illuminate\Http\Response
     */
    public function switchMode(Request $request)
    {
        if (auth()->user()->isClient() && auth()->user()->isCreator()) {
            $mode = $request->cookie('mode')
                ? $request->cookie('mode') : 'client';
            $mode = ($mode == 'client') ? 'creator' : 'client';
            return redirect()->back()->withCookie('mode', $mode, 2147483647);
        }

        abort(403);
    }
}
