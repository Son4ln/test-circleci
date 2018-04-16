<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\User;
use Mail;
use App\Mail\ProjectActivated;
use App\Mail\ProjectActivatedCreator;
use Flash;

class ProjectStateController extends Controller
{
    /**
     * ProjectsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    /**
     * 仕事を探す
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->status) {
            $projects = Project::where('status', $request->status)
                ->orderBy('id', 'DESC')->paginate(20);
        } else {
            $projects = Project::orderBy('id', 'DESC')->paginate(20);
        }

        return view('projects.managements.index', compact('projects'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = Project::select('id', 'price_min', 'price_max', 'status', 'title', 'is_prime')
            ->findOrFail($id);

        if ($project->isPrime()) {
            $proposals = $project->proposals()
                ->with('user:id,name')
                ->where('state', '<>', 0)
                ->get();
        }

        return view('projects.managements.edit', compact('project', 'proposals'));
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
        $input = $request->except('_token', '_method', 'public');
        $project = Project::findOrFail($id);
        if ($request->exists('public')) {
            $this->authorize('public', $project);
            $input['status'] = $project->statuses['public'];

             Mail::to($project->user->email)
                 ->queue(new ProjectActivated($project->title));
            //
            // event(new EmailShouldBeSent(new ProjectStarted($project->title)));

            $users = User::creator()->get();
            $project_type = $project->is_certcreator == 1 ? '認定クリエイター向けコンペ': 'セルフコンペ';

            foreach ($users as $user) {
                    Mail::to($user->email)
                    ->queue(new ProjectActivatedCreator($project_type, $project->title)); 
            }
        }

        $project->update($input);

        if ($input['status'] == $project->statuses['delivered']) {
            $project->update(['finished_at' => \Carbon\Carbon::now()]);
        }

        Flash::success(__('flash_messages.project_states.update_success'))->important();

        return redirect()->back();
    }

    /**
     * Show project and creator detail
     */
    public function show($id)
    {
        $project = Project::select('id', 'title', 'user_id')->findOrFail($id);
        $this->authorize('changeState', $project);

        $creator = $project->offeredProposal()->user;

        return view('projects.managements.show', compact('project', 'creator'));
    }

    /**
     * Filtering project by status
     */
    public function filtering(Request $request)
    {
        $query = Project::select('id', 'title', 'price_min', 'price_max', 'status');
        if (is_numeric($request->status)) {
            $query = $query->where('status', $request->status);
        }

        $projects = $query->paginate(20);

        return view('projects.managements.projects_list', compact('projects'));
    }

    /**
     * Change project status to クライアント検収中
     *
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Http\Response
     */
    public function acceptance(Request $request)
    {
        $project = Project::findOrFail($request->input('project_id'));
        $this->authorize('adminAcceptance', $project);

        $project->setStatus('checking');
        Flash::success(__('flash_messages.project_states.accept_success'))->important();

        return redirect()->back();
    }
}
