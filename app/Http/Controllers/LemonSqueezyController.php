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

    public function productCheckout(Request $request, $variantId): \LemonSqueezy\Laravel\Checkout
    {
        return $request->user()->checkout($variantId)
            ->redirectTo(url('/'));
    }

    public function billing(Request $request): Response
    {
        $url = $request->user()->customerPortalUrl();

        return Inertia::location($url);
    }
}
