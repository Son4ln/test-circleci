<?php

namespace App\Http\Controllers\Auth;

use App\Http\Traits\AuthenticatedRedirects;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;
    use AuthenticatedRedirects;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        // Require activate account before login
        //Flash::success('メールアドレス確認メールを送付致しました。<br>
        //    ４８時間以内にメールが到着しない場合、お手数ですがお電話にてお問い合わせください。')

        return view('auth.register_done');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        
        return Validator::make($data, [
            'email' => 'required|string|email|max:255|activated_user_unique:users',
            'password' => 'required|string|min:8|confirmed|max:60|new_rule_password:users',
            'agreement' => 'required|accepted',
        ]);
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = User::firstOrNew(['email' => $data['email']]);
        $user->fill([
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'enabled' => 1,
            'created_at' => \Carbon\Carbon::now()
        ]);

        $user->save();

        return $user;
    }
}
