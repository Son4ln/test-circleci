<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use Auth;
use Flash;

class ProjectApprovalController extends Controller
{
    /**
     * Create Controller instance
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show project list
     *
     * @return Illuminate\Http\Response
     */
    public function index()
    {
        $project = new Project;
        $this->authorize('approval', Project::class);

        $projects = Project::select('id', 'title', 'invoice_to', 'status')
            ->whereIn('status', [$project->statuses['pending'], $project->statuses['delivered']])
            ->latest()
            ->paginate(20);

        return view('admin.approvals.index', compact('projects'));
    }

    /**
     * Show form for edit project
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $project = Project::select('projects.id', 'title', 'invoice_to', 'price3', 'status')
            ->join('proposals', 'proposals.project_id', '=', 'projects.id')
            ->where([
                'projects.id' => $id,
                'offer'       => 1
            ])->first();

        $this->authorize('approval', $project);

        return view('admin.approvals.edit', compact('project'));
    }

    /**
     * Update project
     *
     * @param Illuminate\Http\Request
     * @param int $id
     * @return Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);
        $this->authorize('approval', $project);

        $project->update([
            'invoice_to' => $request->input('invoice_to')
//            'status'     => $project->statuses['delivered']
        ]);

        if ($proposal = $project->offeredProposal()) {
            $proposal->update(['price3' => $request->input('price3')]);
        }

        Flash::success('更新しました')->important();

        return redirect()->back();
    }
}
