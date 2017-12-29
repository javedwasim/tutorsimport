<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Stripe\Stripe;
use Stripe\Charge;
use Stripe\Customer;

class PurchasesController extends Controller
{
    public function store(){
        $request = Request::all();
        Stripe::setApiKey(config('services.stripe.secret'));
        //create customer.
        $customer = Customer::create([
            'email'=>$request['stripeEmail'],
            'source'=>$request['stripeToken'],
        ]);
        //charge customer.
        Charge::create([
            'customer'=>$customer->id,
            'amount'=>2000,
            'currency'=>'usd',
        ]);

        return 'All Done';
    }
}
