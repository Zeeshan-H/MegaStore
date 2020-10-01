<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Customers;
use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;
use App\Models\Cart;

use App\Http\Requests\StoreOrder;
use Session;
use Stripe\Charge;
use Stripe\Stripe;
use DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
     
        $countries = Country::all();
    	if (!Session::has('cart') || empty(Session::get('cart')->getContents())) {
			return redirect('products')->with('message', 'No Products in the Cart');
		}
        $cart = Session::get('cart');
        // \Stripe\Stripe::setApiKey('sk_test_On5LJnDcrnpxGtdV64BGqLpF00AniHCUdT');
        		
		// $amount = 100;
		// $amount *= 100;
        // $amount = (int) $amount;
        
        // $payment_intent = \Stripe\PaymentIntent::create([
		// 	'description' => 'Stripe Test Payment',
		// 	'amount' => $amount,
		// 	'currency' => 'INR',
		// 	'description' => 'Payment From Codehunger',
		// 	'payment_method_types' => ['card'],
		// ]);
		// $intent = $payment_intent->client_secret;

		return view('products.checkout', compact('cart', 'countries'));


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrder $request)
    {   

        $stripe = new \Stripe\StripeClient(
            'sk_test_On5LJnDcrnpxGtdV64BGqLpF00AniHCUdT'
          );
          $cart = [];
          $order = '';
          $checkout = '';
          $charge = 0;

          if (Session::has('cart')) {
            $cart = Session::get('cart');  
            $charge = $stripe->charges->create([
                'amount' => $cart->getTotalPrice() * 100,
                'currency' => 'usd',
                'source' => 'tok_visa',
                'description' => 'Charge description', 
                'receipt_email' => $request->email,
              ]);
        }
        
    //        dd($charge['id']);
//        dd(request()->all());
       


if (isset($charge)) {
        if ($request->shipping_address) {
            $customer = [
                "billing_firstName" => $request->billing_firstName,
                "billing_lastName" => $request->billing_lastName,
                'username' => $charge['id'],
                "email" => $request->email,
                "billing_address1" => $request->billing_address1,
                "billing_address2" => $request->billing_address2,
                "billing_country" => $request->billing_country,
                "billing_state" => $request->billing_state,
                "billing_zip" => $request->billing_zip,
                "shipping_firstName" => $request->shipping_firstName,
                "shipping_lastName" => $request->shippin_lastName,
                "shipping_address1" => $request->shipping_address1,
                "shipping_address2" => $request->shipping_address2,
                "shipping_country" => $request->shipping_country,
                "shipping_state" => $request->shipping_state,
                "shipping_zip" => $request->shipping_zip,
            ];
        } else {
            $customer = [
                "billing_firstName" => $request->billing_firstaName,
                "billing_lastName" => $request->billing_lastName,
                "username" => $charge['id'],
                "email" => $request->email,
                "billing_address1" => $request->billing_address1,
                "billing_address2" => $request->billing_address2,
                "billing_country" => $request->billing_country,
                "billing_state" => $request->billing_state,
                "billing_zip" => $request->billing_zip,
            ];
        }
    }

        DB::beginTransaction();
		$checkout = Customers::create($customer);
		foreach ($cart->getContents() as $slug => $product) {
			$products = [
				'user_id' => $checkout->id,
				'product_id' => $product['product']->id,
				'qty' => $product['qty'],
				'status' => 'Pending',
				'price' => $product['price'],
				'payment_id' => 0,
			];
			$order = Order::create($products);
        }
        
        if ($checkout && $order) {
			DB::commit();
			$request->session()->forget('cart');
			return redirect('products')->with('message', 'Your Order Successfully Processed');
		} else {
			DB::rollback();
			return redirect('checkout')->with('message', 'Invalid Activity!');
		}


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }


    public function getStates($id) {

        if(request()->ajax())
        return State::where('country_id', $id)->get();
        else
        return 0;

    }
}
