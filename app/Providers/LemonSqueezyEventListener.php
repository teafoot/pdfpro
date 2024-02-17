<?php

namespace App\Providers;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use LemonSqueezy\Laravel\Events\WebhookHandled;

class LemonSqueezyEventListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(WebhookHandled $event): void
    {
        if ($event->payload['meta']['event_name'] === 'subscription_updated') {
            // Handle the incoming event...
        }
    }
}
