<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Proposal;
use App\Events\ProposalWasCreated;
use App\Project;
use Flash;
use Auth;

class ProposalsController extends Controller
{
    const RECORD_PER_PAGE = 10;

    /**
     * ProposalsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
//        $this->middleware('role:client')->only('show');
        $this->middleware('role:creator')->except('show', 'clientOperationAcceptance');
    }

    /**
     * 提案一覧
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $proposals = Proposal::join('projects', 'projects.id', 'proposals.project_id')
                    ->where('proposals.user_id', Auth::user()->id)
                    ->select('proposals.price', 'proposals.id', 'proposals.attachments', 'projects.id as project_id', 'projects.title as project_title', 'projects.status as project_status')
                    ->paginate(self::RECORD_PER_PAGE);

        return view('proposals.index', compact('proposals'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('widget.proposals.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $project = Project::findOrFail($request->input('project_id'));

        list($rules, $messages) = $this->getValidationRules();
        $input = $request->except('_token', 'attachments');
        if ($project->isPrime()) {
            unset($rules['price']);
            $input['price'] = $project->operationFees;
        }
        $this->validate($request, $rules, $messages);

        $input['attachments'] = $this->uploadAttachments($request->file('attachments'));

        $project->proposals()->create($input);
        event(new ProposalWasCreated($input));

        Flash::success(__('flash_messages.proposals.store_success'))->important();
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $proposals = Proposal::own()->orderBy('id', 'DESC')
            ->paginate(self::RECORD_PER_PAGE);

        return view('widget.proposals.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ownerList($id)
    {
        $project = Project::findOrFail($id);
        $proposalMessageCount = $project->proposals()->where('kind', 1)
            ->count();

        return view('widget.proposals.table', compact('project', 'proposalMessageCount'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $proposal = Proposal::findOrFail($id);

        return view('widget.proposals.edit', compact('proposal'));
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
        $proposal = Proposal::findOrFail($id);
        $this->authorize('update', $proposal);

        $input    = $request->except('_token', '_method');

        if ($request->hasFile('attachments')) {
            $input['attachments'] = $this->uploadAttachments($request->file('attachments'));
        }

        $proposal->update($input);

        return;
    }

    /**
     * Show the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $proposal = Proposal::findOrFail($id);

        $authCheck = auth()->user()->isAdmin();
        if(!$authCheck)
          $this->authorize('view', $proposal);
           
        $creator  = $proposal->user;
        $portfolios = $creator->portfolios;

        return view('proposals.show', compact('proposal', 'creator', 'portfolios'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $proposal = Proposal::findOrFail($id)->delete();
        $this->authorize('delete', $proposal);

        $proposal->delete();

        return;
    }

    /**
     * Update proposal price
     */
    public function creatorAcceptance(Request $request)
    {
        $this->validate($request, ['price2' => 'required|numeric']);

        $project = Project::findOrFail($request->input('project_id'));
        $this->authorize('creatorAcceptance', $project);

        $proposal = $project->offeredProposal();
        $proposal->update(['price2' => $request->input('price2')]);
        $project->update(['status' => $project->statuses['pending']]);

        Flash::success(__('flash_messages.proposals.accept_success'))->important();
        return redirect()->back();
    }

    /**
     * Show c-operation proposals list
     */
    public function operationIndex()
    {
        return view('proposals.prime_proposals');
    }

    /**
     * Operation creator acceptance
     */
    public function operationAcceptance($id)
    {
        $proposal = Proposal::findOrFail($id);
        $this->authorize('acceptance', $proposal);

        $proposal->update(['state' => $proposal->states['pending']]);
        Flash::success(__('flash_messages.projects.creator_acceptance_success'));

        return redirect()->back();
    }

    /**
     * Operation creator acceptance
     */
    public function adminOperationAcceptance($id)
    {
        $proposal = Proposal::findOrFail($id);
        $this->authorize('adminAcceptance', $proposal);

        $proposal->update(['state' => $proposal->states['checking']]);
        Flash::success(__('flash_messages.projects.admin_acceptance_success'));

        return redirect()->back();
    }

    /**
     * Operation creator acceptance
     */
    public function clientOperationAcceptance($id)
    {
        $proposal = Proposal::with('project:id,user_id,status,is_prime')->findOrFail($id);
        $this->authorize('clientAcceptance', $proposal);
        $project = $proposal->project;

        if (!$project->isOwn()) {
            abort(403);
        }

        $proposal->update(['state' => $proposal->states['delivered']]);

        $proposals = $project->selectedProposals->filter(function($value, $key) use ($proposal) {
            return $value->id == $proposal->id || $value->state == $value->states['delivered'];
        });

        if ($proposals->count() != 0) {
            $project->setStatus('delivered');
        }

        Flash::success(__('flash_messages.projects.client_acceptance_success'));

        return redirect()->back();
    }


    /**
     * Get validation rules
     *
     * @return array
     */
    protected function getValidationRules()
    {
        $rules = [
            'price' => 'required|numeric|min:1000|max:1000000000',
            'text'  => 'max:4000|nullable'
        ];

        $messages = [

        ];

        return [$rules, $messages];
    }

    /**
     * Upload proposal attachments
     *
     * @param Collection $filter
     * @return array
     */
    protected function uploadAttachments($files)
    {
        $attachments = [];
        if ($files) {
            foreach ($files as $file) {
                $attachment['name'] = $file->getClientOriginalName();
                $attachment['url']  = $file->storePubliclyAs('proposals/'.Auth::id(), $attachment['name'], 's3');
                $attachments[]      = $attachment;
            }
        }

        return $attachments;
    }
}
