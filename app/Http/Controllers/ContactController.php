<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\ContactWasCreated;

class ContactController extends Controller
{

    /**
     * Show form for create new contact
     */
    public function index()
    {
        return view('contacts.mail');
    }

    /**
     * Preview contact
     *
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Http\Response
     */
    public function preview(Request $request)
    {
        list($rules, $messages) = $this->getValidationRules();

        $this->validate($request, $rules, $messages);
        $data = $request->except('_token');

        return view('contacts.preview', compact('data'));
    }

    /**
     * Send mail to user
     *
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Http\Response
     */
    public function sendMail(Request $request)
    {
        $data = $request->except('_token');
        $data['addr'] = $request->ip;

        event(new ContactWasCreated($data));

        return view('contacts.success');
    }

    /**
     * Get rules and validation messages
     *
     * @return array
     */
    protected function getValidationRules()
    {
        $rules = [
            'text'    => 'required|max:1000',
            'name'    => 'required|max:100',
            'email'   => 'email|required|confirmed',
            'content' => 'required'
        ];

        $messages = [
            'content.required' => 'お問合せ用件の入力は必須となります',
            'name.required'    => 'ご担当者お名前の入力は必須となります',
            'text.required' => '内容の入力は必須となります'
        ];

        return [$rules, $messages];
    }
}
