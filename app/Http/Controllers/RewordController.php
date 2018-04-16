<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\Reword;
use Auth;
use DB;
use Flash;

class RewordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:creator')->only('index');
    }

    /**
     * @var int
     */
    protected $pages = 10;

    /**
     * 報酬履歴
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id = Auth::id();
        if ($request->has('pj')) {
            $rewords = Reword::with('project')
                ->where('reword_user_id', $id)
                ->where('project_id', $request->input('pj'))->paginate(10);
        } else {
            $rewords = Reword::with('project')
                ->where('reword_user_id', $id)->paginate(10);
        }

        return view('rewords.index', compact('rewords'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        dd(__METHOD__);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ['amount' => 'required|numeric']);

        $project = Project::findOrFail($request->input('project_id'));
        $this->authorize('creatorAcceptance', $project);

        Reword::create([
            'project_id'     => $project->id,
            'kind'           => 1,
            'bill_user_id'   => $project->user_id,
            'reword_user_id' => $project->offeredProposal()->user_id,
            'status'         => 0,
            'bill'           => $request->input('amount'),
            'reword'         => $request->input('amount')
        ]);

        $project->update(['status' => $project->statuses['pending']]);

        Flash::success(__('flash_messages.rewords.store_success'))->important();

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $reword = Reword::findOrFail($id);

        return view('rewords.edit', compact('reword'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $reword = Reword::findOrFail($id);
        $this->authorize('update', $reword);

        $reword->fill([
            'bill' => $request->input('reword'),
            'reword' => $request->input('reword')
        ]);

        $reword->save();

        Flash::success(__('flash_messages.rewords.update_success'))->important();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
