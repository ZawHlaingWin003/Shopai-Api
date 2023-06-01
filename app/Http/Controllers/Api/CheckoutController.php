<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use Stripe\StripeClient;

class CheckoutController extends Controller
{
    public function purchase(Request $request)
    {
        // make a purchase
        try {
            $user = auth()->user();

            $stripe = new StripeClient(config('services.stripe.secret_key'));

            $token = $stripe->tokens->create([
                'card' => [
                    'number' => '4242424242424242',
                    'exp_month' => 5,
                    'exp_year' => 2024,
                    'cvc' => '314',
                ],
            ]);

            Stripe::setApiKey(config('services.stripe.secret_key'));

            // $stripe->paymentIntents->create([
            //     'amount' => 1099,
            //     'currency' => 'usd',
            //     'payment_method_types' => ['card'],
            // ]);

            // $intent = PaymentIntent::create([
            //     'amount' => 1099,
            //     'currency' => 'sgd',
            //     // Verify your integration in this guide by including this parameter
            //     'metadata' => ['integration_check' => 'accept_a_payment'],
            // ]);

            // return response()->json([
            //     $intent->client_secret
            // ], 201);

            $charge = $stripe->charges->create([
                'amount' => 2000,
                'currency' => 'sgd',
                'source' => $token->id,
                'description' => 'My First Test Charge (created for API docs at https://www.stripe.com/docs/api)',
            ]);

            return response()->json([
                $charge->status
            ], 201);

            // $payment = $user->charge(
            //     1300,
            //     $request->payment_method_id
            // );

            // $payment = $payment->asStripePaymentIntent(config('services.stripe.secret_key'));

            // $order = $user->orders()->create([
            //         'transaction_id' => $payment->charges->data[0]->id,
            //         'total_price' => $payment->charges->data[0]->amount
            //     ]);

            // foreach (json_decode($request->input('cart'), true) as $item) {
            //     $order->products()
            //         ->attach($item['id'], ['quantity' => $item['quantity']]);
            // }

            // $order->load('products');
            // return $order;
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


    public function getUserInfo()
    {
        $user = auth()->user();
        return response()->json([
            'user' => $user,
            'cart' => $user->cart()->first()
        ]);
    }

    public function getSession()
    {
        $stripe = new StripeClient(config('services.stripe.secret_key'));
        $checkout = $stripe->checkout->sessions->create([
            'success_url' => 'http://localhost:8000/success',
            'cancel_url' => 'http://localhost:8000/cancel',
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'usd',
                        'unit_amount' => 3600 * 100,
                        'product_data' => [
                            'name' => 'Cool Stripe Checkout'
                        ]
                    ],
                    'quantity' => 1
                ]
            ],
            'mode' => 'payment',
        ]);

        return $checkout;
    }

    public function charge(Request $request)
    {
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        try {
            \Stripe\Charge::create([
                'amount' => $request->amount,
                'currency' => 'usd',
                'description' => 'One-time Payment',
                'source' => $request->token,
            ]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }
}
