<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\User;
use App\Portfolio;
use Mail;
use App\Mail\ActivateCreator;
use DB;
class CreatorsController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $repository;

    /**
    * Create a new controller instance.
    *
    * @param CreativeRoomRepositoryInterface $repository
    */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
        $this->middleware('auth');
    }

    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index(Request $request)
    {
        $creators = $this->repository->getCreators()->select('id','name','background_thumbnail','photo_thumbnail')->paginate(24);
        $this->authorize('list', User::class);

        return view('creators.index', compact('creators'));
    }

    /**
    * Display a listing of the resource (only list).
    *
    * @return \Illuminate\Http\Response
    */
    public function list(Request $request)
    {
        $filter = $request->except('_method');
        
        $creators = $this->repository
            ->getCreators(['*'], $filter)->paginate(24);
        
        return view('widget.creators.list', compact('creators'));
    }

    /**
    * Active creator
    *
    * @return \Illuminate\Http\Response
    */
    public function active(Request $request)
    {
        $this->authorize('activeCreator', User::class);

        $user = $this->repository->activeCreator($request->input('id'));

        Mail::to($user->email)
            ->queue(new ActivateCreator($user->name));
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        //
    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $index = ($page-1)*10;
        $userId = $id;

        $creator = $this->repository->findOrFail($id);
        $this->authorize('view', $creator);
        $portfolios = Portfolio::where("user_id", $creator["id"])->select('id','title','thumb_path','mime')
        //->orderBy('sort', 'ASC')
        ->orderBy('id','DESC')->paginate(20);

        return view('creators.show', compact('creator','portfolios','index', 'userId'));
    }
}
