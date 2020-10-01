<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @php
        $stripe_key = 'pk_test_jhCSeiX9cKjxeOUgniateRya00nzRBlzxe';
    @endphp
    @extends('layouts.app')
    @section('content')
    @include('layouts.partials.header')
    <div class="row">
            <div class="col-md-4 order-md-2 mb-4">
    
              <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted">Your cart</span>
                <span class="badge badge-secondary badge-pill">{{$cart->countProduct()}}</span>
              </h4>
              <ul class="list-group mb-3">
                @foreach($cart->getContents() as $slug => $product)
                <li class="list-group-item d-flex justify-content-between lh-condensed">
                  <div>
                    <h6 class="my-0">{{$product['product']->title}}</h6>
                    <small class="text-muted">{{$product['qty']}}</small>
                  </div>
                  <span class="text-muted">{{$product['product']->price}}</span>
                </li>
              @endforeach
      {{--           <li class="list-group-item d-flex justify-content-between bg-light">
                  <div class="text-success">
                    <h6 class="my-0">Promo code</h6>
                    <small>EXAMPLECODE</small>
                  </div>
                  <span class="text-success">-$5</span>
                </li> --}}
                <li class="list-group-item d-flex justify-content-between">
                  <span>Total (USD)</span>
                  <strong>${{$cart->getTotalPrice()}}</strong>
                </li>
              </ul>
    
    {{--           <form class="card p-2">
                  @csrf
                <div class="input-group">
                  <input type="text" class="form-control" placeholder="Promo code">
                  <div class="input-group-append">
                    <button type="submit" class="btn btn-secondary">Redeem</button>
                  </div>
                </div>
              </form> --}}
            </div>
            <div class="col-md-8 order-md-1">
              <h4 class="mb-3">Billing address</h4>
              <form action="{{route('checkout.store')}}" method="POST" id="payment-form">
                  @csrf
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label for="firstName">First name</label>
                    <input type="text" name="billing_firstName" class="form-control" id="firstName" placeholder="" value="" required="">
                    @if($errors->has('billing_firstName')) 
                    <div class="alert alert-danger">
                        {{$errors->first('billing_firstName')}}
                      </div>
                      @endif
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="lastName">Last name</label>
                    <input type="text" name="billing_lastName" class="form-control" id="lastName" placeholder="" value="" required="">
                    @if($errors->has('billing_lastName'))
                      <div class="alert alert-danger">
                        {{$errors->first('billing_lastName')}}
                      </div>
                      @endif
                  </div>
                </div>
    
    {{--             <div class="mb-3">
                  <label for="username">Username</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">@</span>
                    </div>
                    <input name="username" type="text" class="form-control" id="username" placeholder="Username" required="" value="{{ @Auth::user()->email}}">
                     @if($errors->has('username'))
                      <div class="alert alert-danger">
                        {{$errors->first('username')}}
                      </div>
                      @endif
                  </div>
                </div> --}}
    
                <div class="mb-3">
                  <label for="email">Email <span class="text-muted">(Optional)</span></label>
                  <input type="email" name="email" class="form-control" id="email" placeholder="you@example.com" value="">
                  @if($errors->has('email'))
                      <div class="alert alert-danger">
                        {{$errors->first('email')}}
                      </div>
                      @endif
                </div>
    
                <div class="mb-3">
                  <label for="address">Address</label>
                  <input type="text" name="billing_address1" class="form-control" id="address" placeholder="1234 Main St" required="">
                  @if($errors->has('billing_address1'))
                      <div class="alert alert-danger">
                        {{$errors->first('billing_address1')}}
                      </div>
                      @endif
                </div>
    
                <div class="mb-3">
                  <label for="address2">Address Line 2 <span class="text-muted">(Optional)</span></label>
                  <input type="text"name="billing_address2" class="form-control" id="address2" placeholder="Apartment or suite">
                  @if($errors->has('billing_address2'))
                      <div class="alert alert-danger">
                        {{$errors->first('billing_address2')}}
                      </div>
                      @endif
                </div>
    
                <div class="row">
                  <div class="col-md-5 mb-3">
                    <label for="country">Country</label>
                    <select name="country_id" class="form-control" id="countries" required="">
                      <option value="0">Choose...</option>
                      @foreach ($countries as $country)
                      <option value="{{$country->id}}">{{$country->name}}</option>                          
                      @endforeach

                    </select>
                    @if($errors->has('billing_country'))
                      <div class="alert alert-danger">
                        {{$errors->first('billing_country')}}
                      </div>
                      @endif
                  </div>
                  <div class="col-md-4 mb-3">
                    <label for="states">State</label>
                    <select name="state_id" class="form-control" id="states">
                      <option value="">Choose...</option>
 
                    </select>
                    @if($errors->has('billing_state'))
                      <div class="alert alert-danger">
                        {{$errors->first('billing_state')}}
                      </div>
                      @endif
                  </div>
                  <div class="col-md-3 mb-3 ml-2">
                    <label for="zip">Zip</label>
                    <input name="billing_zip" type="text" class="form-control" id="zip" placeholder="" required="">
                    @if($errors->has('billing_zip'))
                      <div class="alert alert-danger">
                        {{$errors->first('billing_zip')}}
                      </div>
                      @endif
                  </div>
                </div>
                <hr class="mb-4">
                <div class="custom-control custom-checkbox">
                  <input name="shipping_address" value="true" type="checkbox" class="custom-control-input" id="same-address">
                  <label class="custom-control-label" for="same-address">Shipping address is the same as my billing address</label>
                </div>
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="save-info">
                  <label name="guest" class="custom-control-label" for="save-info">Checkout as Guest</label>
                </div>
    
    
                <div id="shipping_address2" class="col-md-12 order-md-1">
                    <hr class="mb-4">
              <h4 class="mb-3">Shipping address</h4>
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label for="firstName2">First name</label>
                    <input name="shipping_firstName" type="text" class="form-control" id="firstName2" placeholder="" value="">
    
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="lastName2">Last name</label>
                    <input type="text" name="shipping_lastName" class="form-control" id="lastName2" placeholder="" value="" >
    
                  </div>
                </div>
                <div class="mb-3">
                  <label for="address">Address</label>
                  <input type="text" name="shipping_address1" class="form-control" id="address3" placeholder="1234 Main St">
                  <div class="invalid-feedback">
                    Please enter your shipping address.
                  </div>
                </div>
    
                <div class="mb-3">
                  <label for="address2">Address Line 2<span class="text-muted">(Optional)</span></label>
                  <input type="text" name="shipping_address2" class="form-control" id="address2" placeholder="Apartment or suite">
                </div>
    
                <div class="row">
                  <div class="col-md-5 mb-3">
                    <label for="country2">Country</label>
                    <select name="shipping_country" class="custom-select d-block w-100" id="countries2" >
                      <option value="0">Select a Country</option>
                      @foreach($countries as $country)
                      <option value="{{$country->id}}">{{$country->name}}</option>
                      @endforeach
                    </select>
    
                  </div>
                  <div class="col-md-4 mb-3">
                    <label for="states2">State</label>
                    <select name="shipping_state" class="custom-select d-block w-100" id="states2" >
                      <option value="0">Select a state</option>
                       
                    </select>
    
                  </div>
                  <div class="col-md-3 mb-3">
                    <label for="zip">Zip</label>
                    <input type="text" name="shipping_zip" class="form-control" id="zip2" placeholder="" >
    
                  </div>
                </div>
                 </div>
                <hr class="mb-4">
                <script src="https://js.stripe.com/v3/"></script>
                 
                <div class="form-group">
                    <div class="card-header">
                        <label for="card-element">
                            Enter your credit card information
                        </label>
                    </div>
                    <div class="card-body">
                        <div id="card-element">
                        <!-- A Stripe Element will be inserted here. -->
                        </div>
                        <!-- Used to display form errors. -->
                        <div id="card-errors" role="alert"></div>
                        <input type="hidden" name="plan" value="" />
                    </div>
                </div>
                <div class="card-footer">
                  <button
                  id="card-button"
                  class="btn btn-dark"
                  type="submit"
                > Pay </button>
                </div>
              </form>
           </div>
          </div>
    
    @endsection
    
  
</body>
</html>


@section('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="https://js.stripe.com/v3/"></script>



<script type="text/javascript">
 
    	 $(function(){
	 	$('#same-address').on('change', function(){
	 		// $('#shipping_address').slideToggle(!this.checked)
       if(this.checked)
       $('#shipping_address2').hide();
       else 
       $('#shipping_address2').show();
	 	})
   
// Set up the Select2 control
$('#countries').select2().trigger('change');
$('#states').select2();

//On Country Change


$('#countries').on('change', function() {

	var id = $('#countries').select2('data')[0].id;
	$('#states').val(null);
	$('#states option').remove();

  console.log(id);
	// Fetch the preselected item, and add to the control
var studentSelect = $('#states');
$.ajax({
type: 'GET', 
url: "{{route('products.products.states')}}/" + id
}).then(function (data) {
	// create the option and append to Select2\
  console.log(data);
	for(i=0; i< data.length; i++){
		var item = data[i]
		var option = new Option(item.name, item.id, true, true);
		studentSelect.append(option);
	}
studentSelect.trigger('change');
	});

})

	 });


  

</script>

@endsection