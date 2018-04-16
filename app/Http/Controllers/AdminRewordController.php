<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reword;
use App\Project;
use Flash;
use Illuminate\Support\Facades\DB;

class AdminRewordController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $rewords = Reword::whereRewordUserId($id)
            ->select('rewords.reword_date', 'rewords.created_at', 'rewords.project_id', 'rewords.id', 'rewords.reword', 'projects.title as project_title')
            ->join('projects', 'projects.id', '=', 'rewords.project_id')
            ->orderBy('rewords.id', 'DESC')
            ->paginate(20);
        return view('admin.rewords.index', compact('rewords'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $projects = Project::whereHas('proposals', function($query) use ($id) {
            $query->whereNotNull('offer')
                ->whereUserId($id);
        })->pluck('title', 'id');

        return view('admin.rewords.create', compact('projects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $this->validate($request, [
            'reword' => 'required|numeric',
            'project_id' => 'required',
            'reword_date' => 'date|required'
        ]);

        $project = Project::select('id', 'user_id', 'status')
            ->findOrFail($request->input('project_id'));

        Reword::create([
            'project_id'     => $project->id,
            'kind'           => 1,
            'bill_user_id'   => $project->user_id,
            'reword_user_id' => $id,
            'status'         => 0,
            'bill'           => $request->input('reword'),
            'reword'         => $request->input('reword'),
            'reword_date'    => date('Y-m-d', strtotime($request->input('reword_date')))
        ]);

        Flash::success(__('flash_messages.rewords.store_success'))->important();

        return redirect()->route('admin.rewords.index', ['id' => $id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $userId
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $reword = Reword::findOrFail($id);

        return view('admin.rewords.edit', compact('reword'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $userId
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'reword' => 'required|numeric',
            'reword_date' => 'date|required'
        ]);

        $reword = Reword::findOrFail($id);
        $reword->fill([
            'bill'        => $request->input('reword'),
            'reword'      => $request->input('reword'),
            'reword_date' => date('Y-m-d', strtotime($request->input('reword_date')))
        ]);
        $reword->save();

        Flash::success(__('flash_messages.rewords.update_success'))->important();
        return redirect()->back();
    }
}
