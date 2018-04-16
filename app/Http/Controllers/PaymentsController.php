<?php

namespace App\Http\Controllers;

use App\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PaymentsController extends Controller
{
    /**
     * PaymentsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('index', Payment::class);

        $payments = Payment::user($request->user()->id)
            ->with('project:id,title')
            ->orderBy('paid_at', 'desc')->paginate(20);

        return view('payments.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Payment::class);

        $payment = new Payment();

        return view('payments.form', compact('payment'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Payment::class);

        $this->validate($request, $this->getValidateRules('create'));
        $paidAt = Carbon::parse($request->input('paid_at'));

        $payment = new Payment($request->only('title', 'amount', 'status'));
        $payment->user_id = $request->user()->id;
        $payment->paid_at = $paidAt;

        if ($payment->saveOrFail()) {
            Session::flash('flash_message', 'Saved。');

            return redirect('/payments');
        }

        return redirect('/payments/create')->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Payment $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        $this->authorize('view', $payment);

        return view('payments.view', compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Payment $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        $this->authorize('update', $payment);

        return view('payments.form', compact('payment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Payment $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        $this->authorize('update', $payment);

        $this->validate($request, $this->getValidateRules('update'));

        $paidAt = Carbon::parse($request->input('paid_at'));

        $payment->fill($request->only('title', 'amount', 'status'));
        $payment->paid_at = $paidAt;

        if ($payment->saveOrFail()) {
            Session::flash('flash_message', 'Saved。');

            return redirect('/payments');
        }

        return redirect('/payments/edit/' . $payment->id)->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Payment $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        $this->authorize('delete', $payment);

        if ($payment->delete()) {
            Session::flash('flash_message', __('flash_messages.payments.delete_success'));
        }

        return redirect('/payments');
    }

    /**
     * @param string $action
     * @return array
     */
    protected function getValidateRules($action = 'create')
    {
        return [
            'title' => 'required',
            'amount' => 'required|numeric',
            'status' => 'required|in:' . implode(',', array_keys(config('const.payment_status', []))),
            'paid_at' => 'nullable',
        ];
    }
}
