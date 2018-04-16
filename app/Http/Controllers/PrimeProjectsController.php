<?php

namespace App\Http\Controllers;

use App\Project;
use App\Services\FacebookAds;
use App\TrackingJob;
use Carbon\Carbon;
use Illuminate\Support\Str;
use FacebookAds\Exception\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Rabiloo\Facebook\Facade\Facebook;

class PrimeProjectsController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->middleware(['auth', 'role:c-operation-client']);
    }

    /**
     * プライムを始める
     *
     * @return \Illuminate\Http\Response
     */
    public function desc()
    {
        dd(__METHOD__);
    }

    /**
     * 仕事依頼一覧
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('index', Project::class);

        $projects = Project::owner()->prime()->paginate(20);

        return view('prime-projects.index', compact('projects'));
    }

    /**
     * 仕事を依頼
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Project::class);

        $project = new Project();

        return view('prime-projects.create', compact('project'));
    }

    /**
     * 仕事を依頼
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Project::class);

        $rules = $this->getValidateRules();
        $this->validate($request, $rules);

        //dd($request->all());
        $input = $request->only(array_keys($rules));
        unset($input['expired_at']);

        $project = new Project($input);
        $project->user_id = $request->user()->id;
        $project->is_prime = 1;
        $project->status = 20;

        //TODO Save attach files
        if ($request->has('info_files')) {
            $project->info_files = json_decode($request->input('info_files'), true);
        }

        if ($request->has('standard_files')) {
            $project->standard_files = json_decode($request->input('standard_files'), true);
        }

        if ($request->has('attachments')) {
            $project->attachments = json_decode($request->input('attachments'), true);
        }

        if ($request->has('is_expiration_undecided')) {
            $now = Carbon::now(); $now->addDays(30);
            $project->expired_at = $now->toDateTimeString();
        } else {
            $project->expired_at = Carbon::parse($request->input('expired_at'))->toDateTimeString();
        };

        if ($project->saveOrFail()) {
            Session::flash('flash_message', __('flash_messages.prime_projects.store_success'));

            return redirect()->route('projects.show', ['id' => $project->id]);
        }

        return redirect()->back()->withInput();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = Project::findOrFail($id);

        $this->authorize('update', $project);

        return view('prime-projects.edit', compact('project'));
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
        $project = Project::findOrFail($id);
        $this->authorize('update', $project);

        $rules = $this->getValidateRules();
        $this->validate($request, $rules);

        $input = $request->only(array_keys($rules));
        unset($input['expired_at']);
        $project->fill($input);

        //TODO Save attach files
        if ($request->has('info_files')) {
            $project->info_files = json_decode($request->input('info_files'), true);
        }

        if ($request->has('standard_files')) {
            $project->standard_files = json_decode($request->input('standard_files'), true);
        }

        if ($request->has('attachments')) {
            $project->attachments = json_decode($request->input('attachments'), true);
        }

        if ($request->has('is_expiration_undecided')) {
            $now = Carbon::now(); $now->addDays(30);
            $project->expired_at = $now->toDateTimeString();
        } else {
            $project->expired_at = Carbon::parse($request->input('expired_at'))->toDateTimeString();
        };

        if ($project->saveOrFail()) {
            Session::flash('flash_message', __('flash_messages.prime_projects.store_success'));

            return redirect()->route('projects.show', ['id' => $project->id]);
        }

        return redirect()->back()->withInput();
    }

    /**
     * Show project's proposals
     */
    public function showProposals($id)
    {
        $project = Project::select('id', 'user_id', 'is_prime')->findOrFail($id);
        $this->authorize('showPrimeProposals', $project);

        $proposals = $project->proposals;

        return view('proposals.prime_proposals', compact('proposals'));
    }

    /**
     * Facebook連携
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function facebookCert(Request $request)
    {
        $user = $request->user();

        if ($user->facebook_id) {
            $fbResponse = Facebook::get(
                '/me?fields=id,name,picture{url},link,cover,accounts{id,name,fan_count,picture{url},link}',
                $user->facebook_token
            );
            if (!$fbResponse->isError()) {
                $fbUser = $fbResponse->getGraphUser()->asArray();
            }
        }

        return view('prime-projects.authorize', compact('user', 'fbUser'));
    }

    /**
     * Facebookレポート
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @throws Exception
     */
    public function facebookReport(Request $request)
    {
        $campaigns = [];
        $adAccounts = [];

        try {
            $accessToken = $request->user()->facebook_token;

            $service = new FacebookAds($accessToken);
            $adAccounts = $service->getAdAccounts();
            if ($request->has('ad_account_id')) {
                $campaigns = $service->getCampaigns($request->input('ad_account_id'));
            }
        } catch (Exception $exception) {
            logger()->error(sprintf(
                "[%s] %s\n%s",
                $exception->getCode(),
                $exception->getMessage(),
                $exception->getTraceAsString()
            ));

            throw $exception;
        }

        return view('prime-projects.report', compact('adAccounts', 'campaigns'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param string  $adAccountId
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     */
    public function facebookListCampaigns(Request $request, $adAccountId)
    {
        $campaigns = [];

        try {
            $accessToken = $request->user()->facebook_token;

            $service = new FacebookAds($accessToken);
            $campaigns = $service->getCampaigns($adAccountId);
        } catch (Exception $exception) {
            logger()->error(sprintf(
                "[%s] %s\n%s",
                $exception->getCode(),
                $exception->getMessage(),
                $exception->getTraceAsString()
            ));

            throw $exception;
        }

        return response()->json($campaigns);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param string  $campaignId
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     */
    public function facebookGetInsights(Request $request, $campaignId)
    {
        $from = Carbon::parse('2 week ago')->format('Y-m-d');
        $to = Carbon::now()->format('Y-m-d');
        $adsInsights = [];

        try {
            $accessToken = $request->user()->facebook_token;

            $service = new FacebookAds($accessToken);
            $adsInsights = $service->getAdsInsights($campaignId, $from, $to);
        } catch (Exception $exception) {
            logger()->error(sprintf(
                "[%s] %s\n%s",
                $exception->getCode(),
                $exception->getMessage(),
                $exception->getTraceAsString()
            ));

            throw $exception;
        }

        return response()->json($adsInsights);
    }

    /**
     * Facebookアラート
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @throws Exception
     */
    public function facebookAlert(Request $request)
    {
        $campaigns = [];
        $adAccounts = [];

        try {
            $accessToken = $request->user()->facebook_token;

            $service = new FacebookAds($accessToken);
            $adAccounts = $service->getAdAccounts();
            if ($request->has('ad_account_id')) {
                $campaigns = $service->getCampaigns($request->input('ad_account_id'));
            }
        } catch (Exception $exception) {
            logger()->error(sprintf(
                "[%s] %s\n%s",
                $exception->getCode(),
                $exception->getMessage(),
                $exception->getTraceAsString()
            ));

            throw $exception;
        }

        $jobs = TrackingJob::all();

        return view('prime-projects.alert', compact('adAccounts', 'campaigns', 'jobs'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function saveJob(Request $request)
    {
        // validate
        $this->validate($request, [
            'ad_account_id' => 'required',
            'campaign_id' => 'required',
            'condition_type' => 'required',
            'condition_value' => 'required',
        ]);

        $data = $request->only(['ad_account_id','campaign_id','condition_type','condition_value']);

        $job = new TrackingJob($data);
        $job->user()->associate($request->user());

        if (!$job->save()) {
            Session::flash('message', __('flash_messages.prime_projects.save_job_error'));
        }

        return redirect()->route('alerts.index');
    }

    /**
     * @param Request $request
     * @param string $id
     * @return \Illuminate\Http\Response
     */
    public function deleteJob(Request $request, $id)
    {
        /** @var TrackingJob $job */
        $job = $request->user()->trackingJobs()->findOrFail($id);

        if (!$job->forceDelete()) {
            Session::flash('message', __('flash_messages.prime_projects.delete_job_error'));
        }

        return redirect()->route('alerts.index');
    }

    /**
     * Prime proposals accept
     */
    public function acceptProposals(Request $request, $id)
    {
        $project = Project::findOrFail($id);
        $this->authorize('selectProposals', $project);

        $records = [];
        $thumbnail = $project->image ? $project->image : '';
        foreach ($request->input('ids') as $id) {
            $proposal = \App\Proposal::findOrFail($id);

            if ($proposal->offer != 1) {
                $room = \App\CreativeRoom::create([
                    'title' => $project->title . '_' . $id,
                    'user_id' => auth()->id(),
                    'thumbnail' => '',
                    'invitation_token' => Str::random(10)
                ]);

                $room->creativeroomUsers()->createMany([
                    [
                        'user_id' => $room->user_id,
                        'role' => \App\CreativeroomUser::MASTER_ROLE,
                        'state' => 1,
                    ],
                    [
                        'user_id' => $proposal->user_id,
                        'role' => \App\CreativeroomUser::MEMBER_ROLE,
                        'state' => 1,
                    ]
                ]);

                $proposal->update([
                    'room_id' => $room->id,
                    'state' => $project->statuses['started'],
                    'offer' => 1
                ]);
            }
        }

        $project->setStatus('started');
        \Flash::message(__('flash_messages.proposals.c_success_operation'));

        return redirect()->back();
    }

    /**
     * @param string $action
     * @return array
     */
    protected function getValidateRules()
    {
        return [
            'business_type' => 'required|numeric',
            'business_name' => 'required|string',
            'business_url' => 'required|url',
            'purpose' => 'required|numeric',
            'target_product' => 'required|string',
            'point' => 'required|string',
            'keyword1'=> 'nullable|string',
            'keyword2'=> 'nullable|string',
            'keyword3'=> 'nullable|string',
            'describe' => 'required|string',
            'moviesec_min' => 'required|numeric',
            'moviesec_max' => 'required|numeric',
            'similar_video' => 'required|numeric',
            'aspect' => 'required|numeric',
            'aspect_text' => 'nullable|string',
            'title' => 'required|string',
            'duedate_at' => 'nullable|date',
            'reference_url' => 'nullable|url',
            'standard_url' => 'nullable|url',
            'status' => 'required|in:0,10',
            'expired_at' => 'date'
        ];
    }
}
