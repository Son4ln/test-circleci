<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Payment;
use App\Project;
use Flash;

class AdminPaymentController extends Controller
{
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
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $payments = Payment::user($id)
            ->with('project:id,title')
            ->orderBy('paid_at', 'desc')->paginate(20);

        return view('admin.payments.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $projects = Project::whereUserId($id)->pluck('title', 'id');

        return view('admin.payments.create', compact('projects'));
    }

    /**
     * 支払い 追加
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $userId)
    {
        list($rules, $messages) = $this->getValidateRules();
        $this->validate($request, $rules);

        $data = $request->only('title', 'project_id', 'amount');
        $data['user_id'] = $userId;
        $data['status']  = 1;
        $data['paid_at'] = date('Y-m-d', strtotime($request->input('paid_at')));
        $payment = new Payment($data);
        $payment->save();

        Flash::success(__('flash_messages.payments.store_success'))->important();
        return redirect()->route('admin.payments.index', ['userId' => $userId]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $userId
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($userId, $id)
    {
        $payment  = Payment::findOrFail($id);
        $projects = Project::whereUserId($userId)->pluck('title', 'id');

        return view('admin.payments.edit', compact('payment', 'projects'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $userId
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        list($rules, $messages) = $this->getValidateRules();
        $this->validate($request, $rules);

        $payment = Payment::findOrFail($id);
        $data = $request->only('title', 'project_id', 'amount');
        $data['paid_at'] = date('Y-m-d', strtotime($request->input('paid_at')));
        $payment->fill($data);
        $payment->save();

        Flash::success(__('flash_messages.payments.update_success'))->important();
        return redirect()->back();
    }


    /**
     * Get validate rules
     */
    public function getValidateRules()
    {
        $rules = [
            'title' => 'required',
            'amount' => 'required|numeric',
            'paid_at' => 'required|date'
        ];

        $messages = [

        ];

        return [$rules, $messages];
    }
}
