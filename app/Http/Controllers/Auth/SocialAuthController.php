<?php

namespace App\Http\Controllers\Auth;

use App\Events\SocialUserWasLogged;
use App\Http\Controllers\Controller;
use App\Http\Traits\AuthenticatedRedirects;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use InvalidArgumentException;
use Laravel\FlashMessage\Facades\Flash;
use Laravel\Socialite\Contracts\Provider;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class SocialAuthController extends Controller
{
    use AuthenticatedRedirects;

    /**
     * Constructor
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * @param Request $request
     * @param string  $network
     * @return \Illuminate\Http\Response
     * @throws BadRequestHttpException
     */
    public function redirect(Request $request, $network)
    {
        // TODO: save ref URL
        $request->session()->put('redirect_url', url()->previous());
        try {
            $driver = Socialite::driver($network);
        } catch (InvalidArgumentException $exception) {
            logger()->debug("Socialite not support {$network} driver");
        }

        if (is_null($driver) || !($driver instanceof Provider)) {
            throw new BadRequestHttpException();
        }

        if (method_exists($driver, 'scopes')) {
            $driver->scopes(Config::get("services.{$network}.scopes", []));
        }

        return $driver->redirect();
    }

    /**
     * @param Request $request
     * @param string  $network
     * @return \Illuminate\Http\Response
     * @throws BadRequestHttpException
     */
    public function callback(Request $request, $network)
    {
        try {
            $driver = Socialite::driver($network);
        } catch (InvalidArgumentException $exception) {
            logger()->debug("Socialite not support {$network} driver");
        }

        if (is_null($driver) || !($driver instanceof Provider)) {
            throw new BadRequestHttpException();
        }

        $redirect = $this->redirectTo();

        try {
            /** @var \Laravel\Socialite\Contracts\User $socialUser */
            $socialUser = Socialite::driver($network)->user();
            $user = $request->user();
            if ($user) {
                $redirect = $request->session()->get('redirect_url');
                if (strpos($redirect, 'profile/account')) {
                    if (User::where('facebook_id', $socialUser->id)->count() > 0) {
                        Flash::error('既に他のアカウントと連携をしております')->important();
                        return redirect()->back();
                    }
                    $user->fill([
                        'facebook_token' => $socialUser->token,
                        'facebook_id'    => $socialUser->id,
                        'facebook_name'  => $socialUser->name,
                    ]);
                    $user->save();
                }
            } else {
                $user = User::where('facebook_id', $socialUser->id)->orWhere(function($query) use ($socialUser) {
                    return $query
                        ->whereNull('facebook_id')
                        ->where('email', $socialUser->email);

                })->first();
                if (!$user) {
                    $user = User::create([
                        'facebook_token' => $socialUser->token,
                        'facebook_id'    => $socialUser->id,
                        'facebook_name'  => $socialUser->name,
                        'name'           => $socialUser->name,
                        'email'          => $socialUser->email,
                        'photo'          => $socialUser->avatar,
                        'password'       => '',
                    ]);
                }

                Auth::login($user, true);
            }

            // Trigger event
            SocialUserWasLogged::dispatch($user, $socialUser, $network);

            // Save default access token
            if (isset($socialUser->token)) {
                $request->session()->put("{$network}_access_token", $socialUser->token);
            }
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage() . PHP_EOL . $exception->getTraceAsString());
            Flash::error('Facebook連携時にエラーが起きました。管理者にお問い合わせください');
            return redirect('/');
        }

        return redirect($redirect);
    }

    /**
     * Revoke facebook connection
     */
    public function revoke(Request $request, $network)
    {
        if ($network == 'facebook') {
            $user = $request->user();
            if ($user->email == '' || $user->password == '') {
                Flash::error(__('flash_messages.facebook_connect.error'))->important();
                return redirect()->back();
            }
            $user->fill([
                'facebook_token' => null,
                'facebook_id'    => null,
                'facebook_name'  => null,
            ]);

            $user->save();
        }

        Flash::success(__('flash_messages.facebook_connect.success'));
        return redirect()->back();
    }

    /**
     * Revoke facebook connection
     */
    public function revokeUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($user->email == '' || $user->password == '') {
            Flash::error(__('flash_messages.facebook_connect.error'))->important();
            return redirect()->back();
        }

        $user->fill([
            'facebook_token' => null,
            'facebook_id'    => null,
            'facebook_name'    => null,
        ]);

        $user->save();

        Flash::success(__('flash_messages.facebook_connect.success'));
        return redirect()->back();
    }
}
