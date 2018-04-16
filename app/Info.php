<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Info extends Model {

    //
   protected $guarded = ['id'];
   public $timestamps = true;

   /**
    * Scope a query to only include creator.
    *
    * @param \Illuminate\Database\Eloquent\Builder $query
    * @return \Illuminate\Database\Eloquent\Builder
    */
   public function scopeCreator($query)
   {
       return $query->where('kind', 1)->orderBy('created_at', 'desc');
   }

   /**
    * Scope a query to only include client.
    *
    * @param \Illuminate\Database\Eloquent\Builder $query
    * @return \Illuminate\Database\Eloquent\Builder
    */
   public function scopeClient($query)
   {
       return $query->where('kind', 2)->orderBy('created_at', 'desc');
   }
}
