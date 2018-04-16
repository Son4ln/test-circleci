<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class Message extends Model {
    //
    protected $fillable = ['user_id', 'kind', 'send_user_id', 'title', 'message'];

    public function scopeChatMembers($query, $id)
    {
        
        $first = DB::table('messages')->where('user_id', $id)->where('messages.kind', '1')
        ->join( 'users', 'messages.send_user_id', '=', 'users.id')
        ->select([ 'messages.send_user_id',
          DB::raw(" (CASE WHEN users.nickname <> '' THEN users.nickname WHEN users.company <> '' THEN users.company ELSE users.name END) AS name"),
        ]);
        $union = DB::table('messages')->where('send_user_id', $id)->where('messages.kind', '1')
          ->join( 'users as users2 ', 'messages.user_id', '=', 'users2.id')
          ->select(['messages.user_id',
            DB::raw(" (CASE WHEN users2.nickname <> '' THEN users2.nickname WHEN users2.company <> '' THEN users2.company ELSE users2.name END) AS name"),
          ])->union($first);

      return $union;
    }
    public function scopeChat($query, $id)
    {
      return $query->where('messages.kind', 1)
              ->join( 'users', 'messages.send_user_id', '=', 'users.id')
              ->select(['messages.*', 'users.photo',
                  DB::raw(" (CASE WHEN users.nickname <> '' THEN users.nickname WHEN users.company <> '' THEN users.company  ELSE users.name END) AS name"),
              ])
              ->where(function($query) use ($id){
                  $query->orWhere(function($query) use ($id){
                      $query->where('messages.send_user_id', Auth::id())
                            ->where('messages.user_id', $id);
                  })->orWhere(function($query) use ($id){
                      $query->where('messages.user_id', Auth::id())
                            ->where('messages.send_user_id', $id);
                  });
                })
              ->orderBy('created_at', 'desc');
    }
    public function scopeReceiveChat($query, $id)
    {
      return $query->where('messages.kind', 1)
              ->where(function($query) use ($id){
                  $query->orWhere(function($query) use ($id){
                      $query->where('messages.user_id', Auth::id())
                            ->where('messages.send_user_id', $id);
                  });
                });
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
