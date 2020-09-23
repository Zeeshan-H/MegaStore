@extends('layouts.app')
@include('layouts.partials.header')

@section('content')
    
<div class="album py-5 bg-light">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="mb-4">
              <div class="row">

                <div class="col-md-4">
                    <img class="img-thumbnail" src="{{ asset(''. $product->thumbnail)}}">
                </div>

                <div class="col-md-8">
                    <div class="card-body">
                        <h4 class="card-title">{{ $product->title }}</h4>
                        <p class="card-text">{!! $product->description !!}</p>
                        <strong class="cart-text">PRICE: USD {!! $product->price !!}</strong>
                        <div class="d-block justify-content-between align-items-center">
                          <div class="btn-group">
                        
                            <a type="button" href="{{route('products.addToCart', $product)}}" class="btn btn-sm btn-info">Add to Cart</a>
                          </div>
                          <p class="text-muted">9 mins</p>
                        </div>
                      </div>
                </div>
              </div>


          </div>
        </div>

      </div>
 
    </div>
  </div>
@endsection