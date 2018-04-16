<?php

namespace App\Http\Controllers;

use Flash;
use App\User;
use Illuminate\Http\Request;

class AdminSubscriptionController extends Controller
{
    /**
     * @var int
     */
    protected $page = 15;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    /**
     * 一覧
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::select('id', 'name', 'email')->has('subscriptions')
            ->with('subscriptions')->paginate($this->page);

        return view('admin.c_operation.index', compact('users'));
    }

    /**
     * Cancel subscription
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->subscription('main')->cancelNow();

        Flash::message('OK!')->important();

        return redirect()->back();
    }
}
