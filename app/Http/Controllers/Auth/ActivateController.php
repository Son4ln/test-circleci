<?php

namespace App\Http\Controllers\Auth;

use App\Repositories\ActivationTokenRepository;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ActivateController extends Controller
{
    /**
     * @var ActivationTokenRepository
     */
    protected $repository;

    /**
     * Constructor
     *
     * @param ActivationTokenRepository $repository
     */
    public function __construct(ActivationTokenRepository $repository)
    {
        $this->middleware('guest');

        $this->repository = $repository;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function handle(Request $request)
    {
        $this->validator($request->all())->validate();

        $email = $request->input('email');
        $token = $request->input('token');

        if ($this->repository->exists($email, $token)) {
            $this->repository->delete($email);

            /** @var \App\User $user */
            $user = User::where('email', $email)->firstOrFail();

            $user->update([
                'activated_at' => Carbon::now(),
            ]);

            // TODO: flash message
        }

        return redirect('/login');
    }

    /**
     * Get a validator for an incoming activation request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'token' => 'required',
            'email' => 'required',
        ]);
    }
}
