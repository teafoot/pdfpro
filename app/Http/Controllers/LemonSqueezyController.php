<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Laravel\Cashier\Cashier;
use Laravel\Cashier\Checkout;
use Stripe\Exception\ApiErrorException;
use Symfony\Component\HttpFoundation\Response;

class LemonSqueezyController extends Controller
{
    /**
     * @param $variant
     * @return \Illuminate\Http\RedirectResponse
     */
    public function subscriptionCheckout(Request $request, $product, $variant)
    {
        $user = $request->user();

        if ($user->subscription()?->hasVariant($variant)) {
            return redirect()->back()->dangerBanner("You are already subscribed to that plan");
        }

        if ($user->subscribed() && $user->subscription()?->valid()) {
            $user->subscription()
                ?->load('owner')
                ->endTrial()
                ->swap($product, $variant);

            // Replace back() with the route where user should be redirected after successful subscription
            return redirect()->back()->banner('You have successfully subscribed to ' . $variant . ' plan');
        }

        return $user->subscribe($variant);
    }

    /**
     * @param $price
     * @return Checkout
     */
    public function productCheckout($price)
    {
        $user = Auth::user();

        return $user->checkout($price, [
            'success_url' => route('stripe.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('dashboard'),
        ]);
    }

    /**
     * @throws ApiErrorException
     */
    public function success(Request $request)
    {
        $sessionId = $request->get('session_id');

        try {
            Cashier::stripe()->checkout->sessions->retrieve($sessionId);
        } catch (\Exception $exception) {
            return redirect()->route('dashboard')->dangerBanner('Something went wrong');
        }

        $request->user()->update(['trial_is_used' => true]);

        return redirect()->route('dashboard')->banner("You have successfully subscribed");
    }

    /**
     * @return mixed
     */
    public function error()
    {
        return redirect()->route('stripe.plans')->dangerBanner("Something Went Wrong");
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function billing(Request $request)
    {
        $url = $request->user()->billingPortalUrl(route('dashboard'));

        return Inertia::location($url);
    }
}
