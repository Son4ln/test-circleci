<?php

namespace App\Repositories;

use App\Portfolio;
use Auth;


/**   disp
 * Class UserRepository
 */
class PortfolioRepository extends Repository
{
	/**
	 * Model class name.
	 *
	 * @return string
	 */
	public function modelName(): string
	{
		return Portfolio::class;
	}

	/**
	 * Get portfolios and filter it
	 *
	 * @param array $columns
	 * @param array $filter
	 * @return Collection
	 */
	public function getPortfolios($columns = ['portfolios.*'], $filter = [])
	{
		$model = $this->model;

		$model = $model->join('users as u','u.id','portfolios.user_id')->where('u.enabled','1')->whereNull('u.deleted_at');

		if(isset($filter['styles']) && count($filter['styles']) > 0) {

			/*$countStyle = count($filter['styles']);

			if($countStyle == 1){
				if( in_array( $filter['styles'][0], array( 1, 2 ) ) ){
					array_push($filter['styles'],3);
				}
			}*/

			$model = $model->whereHas('pivotStyles', function($query) use ($filter) {
				$query->whereIn('style_id', $filter['styles']);
			});
		}

		if(isset($filter['types']) && count($filter['types']) > 0) {
			$model = $model->whereHas('pivotTypes', function($query) use ($filter) {
				$query->whereIn('type_id', $filter['types']);
			});
		}

		if(isset($filter['amount'])) {
			$first = true;
			foreach ($filter['amount'] as $value) {
				$ranges = explode("-", $value);
				if ($first) {
					$model = $model->whereBetween('amount', $ranges);
					$first = false;
				} else {
					$model = $model->orWhere(function($query) use ($ranges) {
						$query->whereBetween('amount', $ranges);
					});
				}
			}
		}

		if (isset($filter['order']) && $filter['order']) {
			if ($filter['order'] == 'asc') {
				$model = $model->orderBy('amount', 'ASC');
			}

			if ($filter['order'] == 'desc') {
				$model = $model->orderBy('amount', 'DESC');
			}
		} else {
			$model = $model->orderBy('id', 'DESC');
		}

		return $model->listByRole()
		/*->whereHas('user', function($query) {
            $query->where('enabled', 1);
        })*/
        ->select($columns);
	}

	public function filterByPrice($ranges)
	{
		return $this->model->whereBetween('amount', $ranges)
			->listByRole();
	}

	/**
	 * Get portfolios of current user
	 *
	 * @param array $column
	 * @return Collection
	 */
	public function getCurrentCreatorPortfolios($columns = ['portfolios.*'])
	{
		return $this->model
		->join('users as u','u.id','portfolios.user_id')->where('u.enabled','1')->whereNull('u.deleted_at')
		->where('portfolios.user_id', Auth::user()->id)
		->select($columns)
		->orderby('portfolios.id', 'DESC');
		//return $this->model->where('user_id', Auth::user()->id)->orderBy('sort', 'ASC')->orderBy('id','DESC');
	}

	/**
	 * get Portfolio by scope
	 * @param number $scope
	 * @return array Portfolio
	 */
	public  function getPortfolioByScope($fields = ['*'], $scope = 0){
		return $this->model->select($fields)->where('scope', $scope)->where('deleted_at' , null)->orderBy('id', 'DESC')->paginate(9);
	}

	public function getPortfolioByIds($datas = array()){
		$model = $this->model;
		if( !empty($datas) ){
			$userId = Auth::user()->id;
			$strQuery = "";
			foreach( $datas as $sort=>$key ){
				$strQuery = "update portfolios set sort =".(int)$sort." where id = ".(int)$key." and user_id = ".(int)$userId." ;";
				\DB::statement( $strQuery );
			}
		}
	}

}
