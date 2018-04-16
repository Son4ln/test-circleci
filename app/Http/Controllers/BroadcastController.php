<?php

namespace App\Http\Controllers;

use App\Mail\FreeMail;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Laravel\FlashMessage\Facades\Flash;

class BroadcastController extends Controller
{
    /**
     * BroadcastController constructor.
     */
    public function __construct()
    {
        $this->middleware([
            'auth',
            'can:send broadcast mail',
        ]);
    }

    /**
     * View form
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.send_mails');
    }

    /**
     * Send email
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function send(Request $request)
    {
        $rules = [
            'title' => 'required',
            'mailtext' => 'required',
            'mail' => 'required',
        ];

        $validator = $this->getValidationFactory()->make($request->except(['_method', '_token']), $rules);
        $validator->sometimes('skill', 'required', function ($input) {
            return $input->mail == 3;
        });

        if ($validator->fails()) {
            return $this->throwValidationException($request, $validator);
        }

        $users = [];
        switch ($request->input('mail')) {
            case 3:
                $users = User::skill($request->input('skill', []))->get();
                break;
            case 2:
            default:
                $users = User::creator()->get();
//                $users = User::all();
                break;
        }

        $mail = new FreeMail();
        $mail->mailtext = $request->input('mailtext');
        $mail->title = $request->input('title');

        foreach ($users as $user) {
            $mail->name = $user->name;
            $mail->email = $user->email;
            Mail::queue($mail);
        }

        if (($count = count($users)) > 0) {
            Flash::success(__('flash_messages.broadcast.send_success', ['count' => $count]))->important();
            return redirect()->back();
        }

        Flash::warning(__('flash_messages.broadcast.send_warning'))->important();
        return redirect()->back()->withInput();
    }
}
