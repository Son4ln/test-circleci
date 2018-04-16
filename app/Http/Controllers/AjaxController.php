<?php
namespace App\Http\Controllers;

use App\Message;
use App\User;
use App\Project;
use DB;
use Log;
use Illuminate\Support\Facades\Input;
use App\Notifications\AlertMessage;

class AjaxController extends Controller {

    /*
    |--------------------------------------------------------------------------
    | Ajax Controller
    |--------------------------------------------------------------------------
    |
    | This controller renders the "Ajax communicate" for the application
    |
    */

    /* const*/
    public $pages = 10;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest');
        $this->middleware('auth');
    }

    public function anyMessage($kind, $id = null)
    {

        switch($kind){
            case 'sendchat':
                $input = Input::except('_method', '_token');
                Log::alert('chat log', $input);
                $message = Message::create($input);
                $data['messages'] = Message::chat($input['user_id'])->paginate($this->pages);
                $data['id'] = $input['user_id'];
                $view = 'widget.chat';
                $recipient = User::findOrFail($input['user_id']);
                $recipient->notify(new AlertMessage($message));
                $error = '';
                return view($view, $data)->withErrors($error);
                break;
            case 'chat':
                $input = Input::except('_method', '_token');
                Message::reciveChat($input['user_id'])->update(['readed' => true]);
                $data['messages'] = Message::chat($input['user_id'])->paginate($this->pages);
                $data['id'] = $input['user_id'];
                $view = 'widget.chat';
                $error = '';
                return  view($view, $data)->withErrors($error);
                break;
            case 'send':
                $user =  User::where('id', $id)
                            ->select(DB::raw(" (CASE WHEN nickname <> '' THEN nickname ELSE name END) AS username "))
                            ->first();
                return view('widget/message_send')->with('username', $user->username)->with('id', $id);
                break;
          case '':
            default:
                return;
                break;
        }
    }
}
