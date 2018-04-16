<?php namespace App;

use Illuminate\Database\Eloquent\Model;

use Auth;

class Reword extends Model {

    //
   protected $primaryKey = 'id';
   protected $guarded = ['id'];

   protected $dates = [
       'created_at', 'updated_at', 'reword_date'
   ];

    public function scopeReword($query)
    {
        if (!Auth::user()->isAdmin()) {
            $query->where('reword_user_id', Auth::id());
        }

        return $query->join('projects', 'projects.id', '=', 'rewords.project_id')
                    ->select(['rewords.*', 'projects.title'])
                    ->orderBy('rewords.project_id', 'desc')
                    ->orderBy('rewords.id', 'asc');
    }

    /**
     * Get associate with Project
     */
    public function project()
    {
        return $this->belongsTo('App\Project');
    }

}
