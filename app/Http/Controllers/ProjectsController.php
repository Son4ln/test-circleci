<?php

namespace App\Http\Controllers;

use App\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Laravel\FlashMessage\Facades\Flash;
use Mail;
use App\Mail\ProjectNeedPublic;
use App\Mail\Coperation;
use App\Events\EmailShouldBeSent;
use App\Mail\ProjectFinish;
use PDF;
use Auth;
use App\Payment;
use Storage;
use DB;
use App;
class ProjectsController extends Controller
{
	/**
	 * ProjectsController constructor.
	 */
	public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('role:client')->except('index', 'indexAdmin', 'show', 'joined');
		$this->middleware('role:creator')->only('index');
	}

	/**
	 * 仕事を探す
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		//Optimize in Project::searchProject() function
		$this->authorize('index', Project::class);

		$projects = Project::searchProject()->paginate(18);

		return view('projects.index', compact('projects'));
	}

	/**
	 * 仕事依頼一覧
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function indexClient()
	{
    	$this->authorize('index', Project::class);
		$projects = Project::join('users as u','u.id','projects.user_id')
		->where('u.id',Auth::id())
		->select('projects.id','projects.image','projects.title','projects.status','projects.updated_at','projects.user_id','u.background as user_background')->paginate(20);

    	return view('projects.client', compact('projects'));
	}

	/**
	 * Show project for admin
	 *
	 * @return Illuminate\Http\Response
	 */
	public function indexAdmin()
	{
		$this->authorize('admin', Project::class);
		$projects = Project::orderBy('id', 'DESC')->paginate(20);

		return view('projects.admin', compact('projects'));
	}

	/**
	 * Filtering Project (For admin)
	 *
	 * @param Illuminate\Http\Request $request
	 * @return Illuminate\Http\Response
	 */
	public function adminFilter(Request $request)
	{
		$this->authorize('admin', Project::class);
		$projects = Project::where('title', 'like', '%'.$request->title.'%')
			->orderBy('id', 'DESC')->paginate(20);

		return view('projects.partials.projects_list', compact('projects'));
	}

	/**
	 * 仕事を依頼
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function create(Request $request)
	{
		$this->authorize('create', Project::class);

		// if ($request->user()->isPrimeOverload()) {
		//     Flash::warning('あなたはプロジェクトの限界に達しました！')->important();
		//     return view('layouts.ample');
		// }

		$project = new Project();

		return view('projects.create', compact('project'));
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

		$rules = $this->getValidateRules('create');
		$this->validate($request, $rules);

		// Check unset duedate
		$data = $request->only(array_keys($rules));
		if (!empty($data['is_duedate_undecided'])) {
			unset($data['duedate_at']);
		} else {
			$data['duedate_at'] = Carbon::parse($data['duedate_at']);
		};
		unset($data['is_duedate_undecided']);

		if ($request->has('is_expiration_undecided')) {
			$now = Carbon::now(); $now->addDays(30);
			$data['expired_at'] = $now->toDateTimeString();
		} else {
			$data['expired_at'] = Carbon::parse($data['expired_at']);
		};

		if (!empty($data['is_price_undecided'])) {
			unset($data['price_min'], $data['price_max']);
		} else {
			unset($data['is_price_undecided']);
		}

		// Check empty place_pref
		$data['is_place_pref_undecided'] = empty($data['place_pref']) ? 1 : 0;

		$data['attachments'] = $this->uploadAttachments($request->file('attachments'));
		unset($data['image']);
		if ($request->hasFile('image')) {
			$data['image'] = $request->image->storePublicly('project-images/'.Auth::id(), 's3');
		}


		$project = new Project($data);
		$project->user_id = $request->user()->id;
		$project->status = $project->statuses['registered'];

		if ($project->saveOrFail()) {
			Flash::success(__('flash_messages.projects.store_success'))->important();

			return redirect('/projects/' . $project->id);
		}

		Flash::error(__('flash_messages.projects.store_error'));

		return redirect()->back()->withInput();
	}

	/**
	 * Display the specified resource.
	 *
	 * @param Request $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show(Request $request, $id)
	{
		$project = Project::with(['proposals' => function($query) {
			$query->with('user:id,name,photo,background');
		}])
		->with('user:id,name,photo,background,company,department,homepage')
		->findOrFail($id);

		$offeredProposal = \App\Proposal::leftJoin('users','proposals.user_id','users.id')
		->where('proposals.offer','1')
		->where('proposals.project_id',$id)
		->select('proposals.price','proposals.price2','proposals.text','proposals.room_id','proposals.id','proposals.user_id','users.name as user_name')->first();
		$this->authorize('view', $project);

		if ($project->isPrime()) {
			if (($project->isPublic() || $project->isStatus('started'))) {
				$selectedProposals = \App\Proposal::where('state', '<>', 0)
					->whereHas('project', function($query) {
						$query->where('is_prime', 1)
							->where('user_id', auth()->id());
					})->whereMonth('updated_at', date('m'))
					->whereYear('updated_at', date('Y'))->count();
			}
			return view('projects.c_operation_show', compact('project', 'unPaid', 'selectedProposals'));
		}

		// If user is owner of project and project is unpaid (status < 20)
		$unPaid = ($project->user_id == $request->user()->id) && (intval($project->status) < $project->statuses['paid']);

		return view('projects.show', compact('project','offeredProposal', 'unPaid', 'selectedProposals'));
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

		//$this->authorize('update', $project);

		return view('projects.edit', compact('project'));
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

		// Check unset duedate
		$data = $request->only(array_keys($rules));
		if (!empty($data['is_duedate_undecided'])) {
			$data['duedate_at'] = null;
		} else {
			$data['duedate_at'] = Carbon::parse($data['duedate_at']);
		}
		unset($data['is_duedate_undecided']);

        if ($request->has('is_expiration_undecided')) {
            $now = Carbon::now(); $now->addDays(30);
            $data['expired_at'] = $now->toDateTimeString();
        } else {
            $data['expired_at'] = Carbon::parse($data['expired_at']);
        };

		if (!empty($data['is_price_undecided'])) {
			unset($data['price_min'], $data['price_max']);
		} else {
			unset($data['is_price_undecided']);
		}

		unset($data['image']);
		if ($request->hasFile('image')) {
			$data['image'] = $request->image->storePublicly('project-images/'.Auth::id(), 's3');
			Storage::disk('s3')->delete($project->image);
		}

		// Check empty place_pref
		$data['is_place_pref_undecided'] = empty($data['place_pref']) ? 1 : 0;

		$data['attachments'] = $this->uploadAttachments($request->file('attachments'));
		if (empty($data['attachments'])) {
			unset($data['attachments']);
		}

		$project->fill($data);

		if ($project->saveOrFail()) {
			Flash::success(__('flash_messages.projects.update_success'))->important();

			return redirect('/projects/' . $project->id);
		}

		Flash::error(__('flash_messages.projects.update_error'));

		return redirect()->back()->withInput();
	}

	/**
	 * @param Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function pay(Request $request)
	{
		$this->validate($request, [
			'projectId' => 'required|numeric',
			'token' => 'required',
		]);

		/** @var \App\User $user */
		$user = $request->user();
		/** @var Project $project */
		$project = Project::findOrFail($request->input('projectId'));
		$amount = (int) $project->fees;

		$token = $request->input('token');
		$projectId = $request->input('projectId');

		try {
			// Check user is created on Stripe?
			if (!$user->hasStripeId()) {
				$user->createAsStripeCustomer($token);
			} else {
				$user->updateCard($token);
			}

			$charged = $user->invoiceFor('クルオ案件登録', $amount, [
				'metadata' => [
					'project-id' => $projectId,
				],
			]);

		} catch (Exception $e) {
			logger()->error($e->getMessage() . PHP_EOL . $e->getTraceAsString());
			$charged = false;
		}

		//logger()->debug($charged);

		if ($charged) {
			$project->paid();
			Payment::create([
				'user_id' => $user->id,
				'title'   => '仕事を依頼しデポジットを決済',
				'project_id' => $project->id,
				'amount'  => $amount,
				'status'  => 1,
				'paid_at' => \Carbon\Carbon::now()
			]);
			event(new EmailShouldBeSent(
				new ProjectNeedPublic($user->name, $project->title))
			);
			Flash::success(__('flash_messages.projects.pay_success'));
		} else {
			Flash::error(__('flash_messages.projects.pay_error'));
		}

		//logger()->debug($project);

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
		$project = Project::findOrFail($id);

		$this->authorize('cancel', $project);

		$project->cancel();

		Flash::success(__('flash_messages.projects.cancel_success'));

		return redirect()->back();
	}

	/**
	 * Fixed project price and finish project
	 */
	public function fixedPrice(Request $request)
	{
		$project = Project::findOrFail($request->input('project_id'));
		$this->authorize('finish', $project);

		$proposal = $project->offeredProposal();
		$proposal->update([
			'price3' => $proposal->price2
		]);

        $invoiceTo = $request->input('invoice_to') ? $request->input('invoice_to') : $project->user->name;

		$project->update([
			'invoice_to'   => $invoiceTo,
			'delivered_at' => Carbon::now()
		]);

		event(new EmailShouldBeSent(new ProjectFinish($project->title)));
		$project->setStatus('delivered');

		Flash::success(__('flash_messages.projects.fixed_price_success'))->important();
		return redirect()->back();
	}

	/**
	 * Finish project
	 */
	public function finish($id)
	{
		$project = Project::findOrFail($id);

		$this->authorize('delivery', $project);
		$project->update([
			'status' => $project->statuses['checking'],
			'finished_at' => Carbon::now()
		]);

		Flash::success(__('flash_messages.projects.finish_success'))->important();

		return redirect()->back();
	}

	/**
	 * Change status
	 */
	public function status(Request $request, $id)
	{
		if (!$request->user()->hasRole('admin')) {
			abort(403);
		}

		$project = Project::findOrFail($id);
		$project->update(['status' => $request->input('status')]);

		Flash::success(__('flash_messages.projects.change_status_success', ['status' => config('const.project_status.'.$request->input('status'))]))
			->important();
		return redirect()->back();
	}

	/**
	 * Update estimate
	 */
	public function updateEstimate(Request $request, $roomId)
	{
		$room = \App\CreativeRoom::findOrFail($roomId);
		$this->authorize('update', $room);

		$project = $room->project;
		$project->fill(['estimate' => $request->input('estimate')]);
		$project->save();

		Flash::success(__('flash_messages.projects.project_estimate'))->important();

		return redirect()->back();
	}

	/**
	 * Download project file
	 */
	public function downloadPDF(Request $request, $id)
	{
		$project = Project::select('id', 'title', 'user_id', 'invoice_to', 'delivered_at')
			->findOrFail($id);
		// return view('templates.invoice', compact('project'));
		$invoice = PDF::loadView('templates.invoice', compact('project'));
		$pdfFileName = $project->title . '_請求書' . '.pdf';

		if (preg_match('/Edge/i', $request->header('User-Agent'))) {
			$pdfFileName = urlencode($pdfFileName);
		}

		return $invoice->download($pdfFileName);
	}

	/**
	 * @param string $action
	 * @return array
	 */
	protected function getValidateRules($action = 'create')
	{
		return [
			'is_prime'             => 'required|in:0,1',
			'real_or_anime'        => 'required|array',
			'type_of_movie'        => 'required|array',
			'is_certcreator'       => 'required|in:0,1',
			'price_min'            => 'numeric',
			'price_max'            => 'numeric',
			'is_price_undecided'   => 'nullable|numeric',
			'part_of_work'         => 'required_without:request_other|array',
			'client_arrange'       => 'required_without:client_arrange_text|array',
			'client_arrange_text'  => 'nullable|max:4000',
			'request_other'        => 'nullable|max:4000',
			'place_pref'           => 'nullable|max:4000',
			'point'                => 'string|required|max:4000',
			'describe'             => 'string|max:4000',
			'title'                => 'required|string|max:255',
			'duedate_at'           => 'nullable|date',
			'is_duedate_undecided' => 'nullable|numeric',
			'image'                => 'image|nullable',
			'expired_at'           => 'nullable|date'
		];
	}

	/**
	 * Upload project attachments
	 *
	 * @param Uploads $files
	 * @return array
	 */
	public function uploadAttachments($files)
	{
		$paths = [];
		if ($files) {
			foreach ($files as $file) {
				if (!$file) {
					continue;
				}
				$fileName = $file->getClientOriginalName();
				$path = $file->storePubliclyAs('attachments/'.Auth::id(), $fileName, 's3');
				$paths[] = [
					'name' => $fileName,
					'path' => $path
				];
			}
		}

		return $paths;
	}

	/**
	 * coperation
	 */
    public function coperation(){
		
		return view('projects.coperation');
		
	}
	
	public function sendEmailCoperation(){
		
		//$email = empty(auth()->user()->email) ? 'user id :'.auth()->user()->id : auth()->user()->email;
		$email = empty(auth()->user()->email) ? '' : auth()->user()->email;
		$name = auth()->user()->name ;
		$dateTime = date('Y-m-d H:i:s');
		
		$rs = Mail::to(['yoshida@vi-vito.com', 'info@vi-vito.com'])
		->queue(new Coperation($email, $name, $dateTime));
		Flash::success(__('projects.coperation_send_email_success'))->important();
		
		return redirect('/');
	}



	public function updateProjectMovieType(){

		$keyMaps = [
			0 => 0,
			1 => 0,
			2 => 0,
			3 => 0,
			4 => 0,
			5 => 0,
			8 => 0,
			9 => 0,
			10 => 0,
			11 => 0,
			12 => 0,
			13 => 0,
			16 => 0,
			6 => 7,
			7 => 7,
			14 => 7,
			15 => 7,
			17 =>7,
			18 => 7,
			20 => 7,
			21 => 7,
			22 => 7,
			23 => 7,
			19 => 19,
			24 => 24
		];

		$dataUpdate = array();

		$dataProjectObj = DB::select('select id,type_of_movie from projects');
		$dataProjectArr = [];
		foreach( $dataProjectObj as $project ){
			$arr = json_decode($project->type_of_movie,1);
			$dataProjectArr[$project->id] =  [
				'id' => $project->id,
				'type_of_movie' => !empty($arr) ? $arr : []
			];
		}
		unset($dataProject);
		
		foreach( $dataProjectArr as $key => $projectA ) {
			$dataUpdate[$key] =[
				'id' => $projectA['id'],
				'type_of_movie' => []
			];
			
			if( is_array( $projectA['type_of_movie'] ) ){
				foreach( $projectA['type_of_movie'] as $a ){
					$dataUpdate[$key]['type_of_movie'][] = (string)$keyMaps[$a] ;
				}
			}else{
				pr($projectA);
				echo 'not a array';
			}
			if(empty($dataUpdate[$key]['type_of_movie'])){
				$dataUpdate[$key]['type_of_movie'] = NULL;
			}else{
				$dataUpdate[$key]['type_of_movie'] = array_values( array_unique( $dataUpdate[$key]['type_of_movie'] ) );
				$dataUpdate[$key]['type_of_movie'] = json_encode( $dataUpdate[$key]['type_of_movie'],1 );
			}
			App\Project::where('id', $projectA['id'])->update(['type_of_movie' => $dataUpdate[$key]['type_of_movie']]);
			//pr($projectA);
			unset($dataProjectArr[$key]);
		}
	
		pr($dataUpdate,1);
	}

	public function updateProjectMovieStype(){
		$keyMaps = [
			1 => 1,
			2 => 2,
			3 => 2,
		];

		$dataUpdate = array();

		$dataProjectObj = DB::select('select id,real_or_anime from projects');
		$dataProjectArr = [];
		foreach( $dataProjectObj as $project ){
			$arr = json_decode($project->real_or_anime,1);
			$dataProjectArr[$project->id] =  [
				'id' => $project->id,
				'real_or_anime' => !empty($arr) ? $arr : []
			];
		}
		unset($dataProject);
		
		foreach( $dataProjectArr as $key => $projectA ) {
			$dataUpdate[$key] =[
				'id' => $projectA['id'],
				'real_or_anime' => []
			];
			
			if( is_array( $projectA['real_or_anime'] ) ){
				foreach( $projectA['real_or_anime'] as $a ){
					$dataUpdate[$key]['real_or_anime'][] = (string)$keyMaps[$a] ;
				}
			}else{
				pr($projectA);
				echo 'not a array';
			}
			if(empty($dataUpdate[$key]['real_or_anime'])){
				$dataUpdate[$key]['real_or_anime'] = NULL;
			}else{
				$dataUpdate[$key]['real_or_anime'] = array_values( array_unique( $dataUpdate[$key]['real_or_anime'] ) );
				$dataUpdate[$key]['real_or_anime'] = json_encode( $dataUpdate[$key]['real_or_anime'],1 );
			}
			App\Project::where('id', $projectA['id'])->update(['real_or_anime' => $dataUpdate[$key]['real_or_anime']]);
			//pr($projectA);
			unset($dataProjectArr[$key]);
		}


	}

	public function updatePortfolioStyles(){

		$keyMaps = [
			1 => 1,
			2 => 2,
			3 => 2,
		];

		$dataUpdate = [];
		$dataPortfolioArr = [];

		$dataPortfolioObj = DB::select('select * from portfolio_styles');
		
		//Mapping data
		foreach( $dataPortfolioObj as $portfolio ){
			
			if(!isset( $dataPortfolioArr[$portfolio->portfolio_id] )){
				$dataPortfolioArr[$portfolio->portfolio_id] =  [
					'id' => $portfolio->id,
					'portfolio_id' => $portfolio->portfolio_id,
					'style_id' => [$keyMaps[$portfolio->style_id]]
				];
			}else{
				$dataPortfolioArr[$portfolio->portfolio_id]['style_id'][] = $keyMaps[$portfolio->style_id];
			}
			$dataPortfolioArr[$portfolio->portfolio_id]['style_id'] = array_values( array_unique($dataPortfolioArr[$portfolio->portfolio_id]['style_id']) );
		
		}


		foreach($dataPortfolioArr as $portfolio){
			DB::table('portfolio_styles')->where('portfolio_id', '=', $portfolio['portfolio_id'])->delete();
			foreach( $portfolio['style_id'] as $por ){
				DB::table('portfolio_styles')->insert(
					[
						'portfolio_id' => $portfolio['portfolio_id'],
						'style_id' => $por
					]
				);
			}
		}

		unset($dataPortfolioObj);

		pr( count( $dataPortfolioArr ) );
		pr($dataPortfolioArr);
		
	}


	public function updatePortfolioTypes(){

		$keyMaps = [
			0 => 0,
			1 => 0,
			2 => 0,
			3 => 0,
			4 => 0,
			5 => 0,
			8 => 0,
			9 => 0,
			10 => 0,
			11 => 0,
			12 => 0,
			13 => 0,
			16 => 0,
			6 => 7,
			7 => 7,
			14 => 7,
			15 => 7,
			17 =>7,
			18 => 7,
			20 => 7,
			21 => 7,
			22 => 7,
			23 => 7,
			19 => 19,
			24 => 24
		];
		$dataUpdate = [];
		$dataPortfolioArr = [];

		$dataPortfolioObj = DB::select('select * from portfolio_types ');
		
		//Mapping data
		foreach( $dataPortfolioObj as $portfolio ){
			
			if(!isset( $dataPortfolioArr[$portfolio->portfolio_id] )){
				$dataPortfolioArr[$portfolio->portfolio_id] =  [
					'id' => $portfolio->id,
					'portfolio_id' => $portfolio->portfolio_id,
					'type_id' => [$keyMaps[$portfolio->type_id]]
				];
			}else{
				$dataPortfolioArr[$portfolio->portfolio_id]['type_id'][] = $keyMaps[$portfolio->type_id];
			}
			$dataPortfolioArr[$portfolio->portfolio_id]['type_id'] = array_values( array_unique($dataPortfolioArr[$portfolio->portfolio_id]['type_id']) );
		
		}


		foreach($dataPortfolioArr as $portfolio){
			DB::table('portfolio_types')->where('portfolio_id', '=', $portfolio['portfolio_id'])->delete();
			foreach( $portfolio['type_id'] as $por ){
				DB::table('portfolio_types')->insert(
					[
						'portfolio_id' => $portfolio['portfolio_id'],
						'type_id' => $por
					]
				);
			}
		}

		unset($dataPortfolioObj);

		pr( count( $dataPortfolioArr ) );
		pr($dataPortfolioArr);
		
	}

}
