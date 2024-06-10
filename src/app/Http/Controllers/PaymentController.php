<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Charge;
use Stripe\PaymentMethod;
use Stripe\PaymentIntent;

class PaymentController extends Controller
{

    public function viewPayment(Request $request)
    {
        return view('payment');
    }
    public function processPayment(Request $request)
    {

        try{
            Stripe::setApiKey(env('STRIPE_SECRET')); //①

            //ここで顧客情報を登録②
            $customer = Customer::create(array('email' => $request->stripeEmail,
                                               'source' => 'tok_visa',
                                              )
                                         );

            // PaymentIntentを作成③
            $paymentIntent = PaymentIntent::create([
                'customer' => $customer->id,
                'amount' => 100, // 金額は最小通貨単位で指定（例：100円 = 100）
                'currency' => 'jpy',
                'payment_method' => 'pm_card_visa',
                'automatic_payment_methods' => [
                'enabled' => true,
                'allow_redirects' => 'never',
                ],
            ]);

            return view("/payment-result");

        }catch(Exception $e){

            return $e->getMessage();

        }

    }

    public function paymentResult(Request $request)
    {
        return view('/payment-result');
    }
}
