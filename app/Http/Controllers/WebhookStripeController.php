<?php

namespace App\Http\Controllers;
use App\Models\Orders;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Support\Str;
use Laravel\Cashier\Events\WebhookHandled;
use Laravel\Cashier\Events\WebhookReceived;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;
use Illuminate\Support\Facades\Log;
use Session;
use Stripe\PaymentIntent;
use Stripe\Stripe;


class WebhookStripeController extends CashierController
{

    public function handleWebhook(Request $request)
    {
        $payload = json_decode($request->getContent(), true);

        $method = 'handle'.Str::studly(str_replace('.', '_', $payload['type']));

        WebhookReceived::dispatch($payload);

        if (method_exists($this, $method)) {
            $response = $this->{$method}($payload);

            WebhookHandled::dispatch($payload);

            return $response;
        }
       // Log::info($payload['data']['object']);
        $data = $payload['data']['object'];

        if($data['object'] == 'checkout.session') {


            $data_order['payment_intent'] = $data['payment_intent'];
            $data_order['stripe_response'] = $data;

            Stripe::setApiKey(env('STRIPE_SECRET'));
            $intent = PaymentIntent::retrieve($data_order['payment_intent']);
            if($intent != ''){
                $data_order['receipt_url'] = $intent['charges']['data'][0]['receipt_url'];
            }

            $orders = Orders::where('id', $data['client_reference_id'])->latest()->first();
            $orders->fill($data_order);
            $orders->save();
        }
//        if($data['object'] == 'charge') {
//
//            Log::info('payment_intent.charge'.$data['payment_intent']);
//
//            session()->put('payment_intent', $data['payment_intent']);
//            session()->put('receipt_url', $data['receipt_url']);
//        }

        return $this->missingMethod($payload);
    }

    public function handleInvoicePaymentSucceeded(array $payload)
    {
        log::info('Invoice Success'.$payload);
//
//        $data = $request->all();
//        switch ($data['type']) {
//            case 'customer.subscription.created':
//                $subscription = $data['data']['object'];
//                break;
//
//            default:
//                echo 'Received unknown event type ' . $data['type'];
//        }



    }

    public function handleInvoicePaymentFailed(array $payload)
    {
        log::info('Invoice Failed'.$payload);
//
//        $data = $request->all();
//        switch ($data['type']) {
//            case 'customer.subscription.created':
//                $subscription = $data['data']['object'];
//                break;
//
//            default:
//                echo 'Received unknown event type ' . $data['type'];
//        }



    }
}
