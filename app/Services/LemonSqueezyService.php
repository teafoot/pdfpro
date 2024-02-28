<?php

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;

class LemonSqueezyService
{
    private PendingRequest $client;

    public function __construct(PendingRequest $client)
    {
        $this->client = $client;
    }

    public function products()
    {
        return $this->client->get('products?filter[store_id]='.config('services.lemonsqueezy.store'))->json();
    }
}
