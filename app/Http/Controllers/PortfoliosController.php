<?php

namespace App\Http\Controllers;

use App\Repositories\PortfolioRepository;
use App\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Laravel\FlashMessage\Facades\Flash;
class PortfoliosController extends Controller
{
	const PER_PAGE = 18;

	/**
	 * @var PortfolioRepository
	 */
	protected $repository;

	/**
	 * Create controller install
	 *
	 * @param PortfolioRepository $repository
	 */
	public function __construct(PortfolioRepository $repository)
	{
		$this->repository = $repository;
		$this->middleware('auth')->except('list', 'index', 'show');
		$this->middleware('role:creator')->except('list', 'index', 'show', 'filterPrice');
	}

	/**
	 * ポートフォリオ一覧
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{

		$portfolios = $this->repository->getPortfolios(['portfolios.*','u.nickname as user_nickname','u.name as user_name','u.photo as user_photo','u.photo_thumbnail as user_photo_thumbnail'])
		->paginate(self::PER_PAGE)->setPath('/portfolios/filter');

		$pivotStyles = array();
		if($portfolios){
			//build arr id for query
			$arr_portfolios_id = array();
			foreach ($portfolios as $item) {
				$arr_portfolios_id[] = $item->id;
			}

			//get pivotStyles
			$pivotStyles_db = \App\PortfolioStyle::whereIn('portfolio_id',$arr_portfolios_id)->select('style_id','portfolio_id')->get();
			if($pivotStyles_db){
				foreach ($pivotStyles_db as $style) {
					$pivotStyles[$style->portfolio_id][] = $style;
				}
			}
		}
		return view('portfolios.index', compact('portfolios','pivotStyles'));

	}

	/**
	 * Get portfolios list
	 *
	 * @param \Illuminate\Http\Request
	 * @return \Illuminate\Http\Response
	 */
	public function list(Request $request)
	{
		
		if ($request->has('self')) {
			$portfolios = $this->repository->getCurrentCreatorPortfolios(['portfolios.*','u.nickname as user_nickname','u.name as user_name','u.photo as user_photo','u.photo_thumbnail as user_photo_thumbnail'])
				->paginate(self::PER_PAGE);
			//=====================get pivotStyles =======================
			$pivotStyles = array();
			if($portfolios){
				//build arr id for query
				$arr_portfolios_id = array();
				foreach ($portfolios as $item) {
					$arr_portfolios_id[] = $item->id;
				}

				//get pivotStyles
				$pivotStyles_db = \App\PortfolioStyle::whereIn('portfolio_id',$arr_portfolios_id)->select('style_id','portfolio_id')->get();
				if($pivotStyles_db){
					foreach ($pivotStyles_db as $style) {
						$pivotStyles[$style->portfolio_id][] = $style;
					}
				}
				//mapping with portfolios id
			}
			//=====================end get pivotStyles =======================
			return view('widget.portfolios.list', compact('portfolios','pivotStyles'));
		}

		$filter = $request->except('_token');

		$portfolios = $this->repository->getPortfolios(['portfolios.*','u.nickname as user_nickname','u.name as user_name','u.photo as user_photo','u.photo_thumbnail as user_photo_thumbnail'], $filter)
			->paginate(self::PER_PAGE)->setPath('/portfolios/filter');

		//=====================get pivotStyles =======================
		$pivotStyles = array();
		if($portfolios){
			//build arr id for query
			$arr_portfolios_id = array();
			foreach ($portfolios as $item) {
				$arr_portfolios_id[] = $item->id;
			}

			//get pivotStyles
			$pivotStyles_db = \App\PortfolioStyle::whereIn('portfolio_id',$arr_portfolios_id)->select('style_id','portfolio_id')->get();
			if($pivotStyles_db){
				foreach ($pivotStyles_db as $style) {
					$pivotStyles[$style->portfolio_id][] = $style;
				}
			}
			//mapping with portfolios id
		}
		//=====================end get pivotStyles =======================

		return view('widget.portfolios.list', compact('portfolios','pivotStyles'));
	}


	public function filterPrice(Request $request) {
		$portfolios = $this->repository
			->filterByPrice($request->except('_token'))
			->limit(2)
			->get();

		return view('projects.partials.portfolio_hint', compact('portfolios'));
	}

	/**
	 * Get portfolios of current user
	 */
	public function me()
	{
		$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
		$index = ($page-1)*10;

		$portfolios = $this->repository->getCurrentCreatorPortfolios(['portfolios.*','u.nickname as user_nickname','u.name as user_name','u.photo as user_photo','u.photo_thumbnail as user_photo_thumbnail'])
		->paginate(self::PER_PAGE);
		$pivotStyles = array();
		if($portfolios){
			//build arr id for query
			$arr_portfolios_id = array();
			foreach ($portfolios as $item) {
				$arr_portfolios_id[] = $item->id;
			}

			//get pivotStyles
			$pivotStyles_db = \App\PortfolioStyle::whereIn('portfolio_id',$arr_portfolios_id)->select('style_id','portfolio_id')->get();
			if($pivotStyles_db){
				foreach ($pivotStyles_db as $style) {
					$pivotStyles[$style->portfolio_id][] = $style;
				}
			}
			//mapping with portfolios id
		}
		return view('portfolios.creator', compact('portfolios','pivotStyles','index'));
	}

	/**
	 * ポートフォリオ追加
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('portfolios.create');
	}

	/**
	 * ポートフォリオ追加
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		list($rules, $messages) = $this->getValidationRules();
		$this->validate($request, $rules, $messages);

		$input = $request->only('thumb_path', 'url', 'title', 'scope', 'amount', 'comment', 'mime');
		$input['user_id']    = $request->user()->id;
		$input['url']        = explode('?', $input['url'])[0];
		if ($input['thumb_path']) {
			$input['thumb_path'] = explode('?', $input['thumb_path'])[0];
		} else {
			$input['thumb_path'] = $input['url'];
		}

		$portfolio = $this->repository->create($input);

		$portfolio->types()->attach($request->types);
		$portfolio->styles()->attach($request->styles);

		Flash::success(__('flash_messages.portfolios.store_success'))->important();
		return redirect()->back();
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show(Request $request, $id)
	{

		$portfolio = Portfolio::join('users as u','u.id','portfolios.user_id')->where('u.enabled','1')->whereNull('u.deleted_at')->select('portfolios.*','u.nickname as user_nickname','u.name as user_name','u.photo as user_photo','u.photo_thumbnail as user_photo_thumbnail','u.comment as user_comment','u.enabled as user_enabled')->findOrFail($id);
        if (!$portfolio->user_enabled) {
            abort(404);
        }
		if (!$request->user() && !$portfolio->isPublicScope()) {
			$this->authorize('view', $portfolio);
		}
		$types = $portfolio->pivotTypes()->select('type_id')->pluck('type_id')->all();
		$styles = $portfolio->pivotStyles()->select('style_id')->pluck('style_id')->all();

		return view('portfolios.show', compact('portfolio', 'types', 'styles'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$portfolio = $this->repository->findOrFail($id);
		$this->authorize('update', $portfolio);
		$types = $portfolio->pivotTypes()->select('type_id')->pluck('type_id')->all();
		$styles = $portfolio->pivotStyles()->select('style_id')->pluck('style_id')->all();

		return view('portfolios.edit', compact('portfolio', 'types', 'styles'));
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
		list($rules, $messages) = $this->getValidationRules();
		$this->validate($request, $rules, $messages);

		$portfolio = $this->repository->findOrFail($id);
		$this->authorize('update', $portfolio);

		$input = $request->only('thumb_path', 'url', 'title', 'scope', 'amount', 'comment', 'mime');

        // User will not edit portfolio when admin_updated fields change to 1
        if (auth()->user()->hasRole('admin')) {
            $input['admin_updated'] = 1;
        }

		if ($request->input('url') != $portfolio->url) {
			$input['url'] = explode('?', $input['url'])[0];
		}

		if ($request->input('thumb_path') != $portfolio->thumb_path) {
			if ($input['thumb_path']) {
				$input['thumb_path'] = explode('?', $input['thumb_path'])[0];
			} else {
				$input['thumb_path'] = $input['url'];
			}
		}

		$portfolio->fill($input);
		$portfolio->save();

		$portfolio->types()->sync($request->types);
		$portfolio->styles()->sync($request->styles);

		Flash::success(__('flash_messages.portfolios.update_success'))->important();
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
		$portfolio = $this->repository->findOrFail($id);
		$this->authorize($portfolio);

		// $portfolio->skills()->delete();

		// $arrayPath = explode("amazonaws.com/", $portfolio->url);
		// $filePath = end($arrayPath);
		// Storage::disk('s3')->delete($filePath);
		//
		// $arrayThumb = explode("amazonaws.com/", $portfolio->thumb_path);
		// $thumbPath = end($arrayThumb);
		// Storage::disk('s3')->delete($thumbPath);

		$portfolio->delete();
	}

	/**
	 * Update portfolio scope
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function scope(Request $request, $id)
	{
		$portfolio = $this->repository
			->update(['scope' => $request->input('scope')], $id);

		Flash::success(__('flash_messages.portfolios.change_scope_success'))->important();

		return redirect()->back();
	}

	/**
	 * @return array
	 */
	protected function getValidationRules()
	{
		$rules = [
			'title'    => 'required|max:255',
			'comment'  => 'max:32000',
			'url'      => 'required',
			'styles'   => 'required',
			'styles.*' => 'between:1,3|distinct',
			'types'    => 'required'
		];

		$messages = [
			'styles.required' => '動画のスタイルを、一つ以上選択してください',
			'types.required'  => '動画のタイプを、一つ以上選択してください',
			'url.required'    => '動画/画像 の入力は必須となります'
		];

		return [$rules, $messages];
	}

	public function portfoliossort(Request $request){
		$data = $request->all();
		$result = $this->repository->getPortfolioByIds($data);
	}
}
