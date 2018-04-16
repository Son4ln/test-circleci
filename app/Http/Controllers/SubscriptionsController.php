<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Stripe\Plan;
use Stripe\Stripe;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Mail;
use App\Mail\PlanSubcribed;
use App\Events\EmailShouldBeSent;

class SubscriptionsController extends Controller
{
    /**
     * SubscriptionsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth')->only('show', 'subscribe', 'index');
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        Stripe::setApiKey(User::getStripeKey());
        $plans = $this->getAllPlans();

        if (Auth::check()) {
            $user = Auth::user();

            // Check is subscribed
            $isSubscribed = $user->subscribed('main');

            // If subscribed get the subscription
            $subscription = $user->subscription('main');
        }

        return view('subscriptions.index', compact('plans', 'isSubscribed', 'subscription'));
    }

    /**
     * @param string $planId
     * @return \Illuminate\Http\Response
     */
    public function show($planId)
    {
        $plan = $this->getPlanByIdOrFail($planId);
        // Check is subscribed
        $isSubscribed = Auth::user()->subscribedToPlan($planId);

        return view('subscriptions.show', compact('plan', 'isSubscribed'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function subscribe(Request $request)
    {
        $this->validate($request, [
            'plan' => 'required',
            'token' => 'required',
        ]);

        /** @var \App\User $user */
        $user = $request->user();

        $token = $request->input('token');
        $planId = $request->input('plan');

        try {
            // check already subscribed
            if ($user->subscribed('main')) {
                if (!$user->subscribedToPlan($planId, 'main')) {
                    // swap if different plan attempt
                    $user->subscription('main')->swap($planId);
                }
            } else {
                // Its new subscription
                $subscriptionBuilder = $user->newSubscription('main', $planId);

                // if user has a coupon, create new subscription with coupon applied
                if ($coupon = $request->input('coupon')) {
                    $subscriptionBuilder->withCoupon($coupon);
                }

                $subscriptionBuilder->create($token, [
                    'email' => $user->email,
                    'description' => $user->name,
                ]);
            }
        } catch (Exception $e) {
            logger()->error($e->getMessage() . PHP_EOL . $e->getTraceAsString());

            // Catch any error from Stripe API request and show
            return redirect()->back()->withErrors(['status' => $e->getMessage()]);
        }

        event(new EmailShouldBeSent(new PlanSubcribed($user->name)));

        return redirect()->route('home')->with('status', __('flash_messages.subscriptions.status', ['planId' => $planId]));
    }

    /**
     * Get Cached Plan by Id
     *
     * @param string $id
     * @return Plan|null
     * @throws NotFoundHttpException
     */
    private function getPlanByIdOrFail($id)
    {
        $plans = $this->getAllPlans();

        if (empty($plans)) {
            throw new NotFoundHttpException();
        }

        return array_first(array_filter($plans, function ($plan) use ($id) {
            return $id == $plan->id;
        }));
    }

    /**
     * Get all plans and cache it
     *
     * @return array
     */
    private function getAllPlans()
    {
        Stripe::setApiKey(User::getStripeKey());

        try {
            // Fetch all the Plans and cache it
            return Cache::remember('stripe.plans', 60 * 24, function () {
                return Plan::all()->data;
            });
        } catch (Exception $e) {
            logger()->error($e->getMessage() . PHP_EOL . $e->getTraceAsString());
        }

        return [];
    }
}
