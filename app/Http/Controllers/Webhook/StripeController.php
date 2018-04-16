<?php

namespace App\Http\Controllers\Webhook;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Cashier\Http\Controllers\WebhookController as Controller;

class StripeController extends Controller
{
    /**
     * Handle a Stripe webhook.
     *
     * @param  array $payload
     * @return Response
     */
    protected function handleInvoicePaymentSucceeded($payload)
    {
        // TODO: Log to Database
    }
}
