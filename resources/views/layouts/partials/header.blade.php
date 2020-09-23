<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
  <div class="container">
      <a class="navbar-brand" href="{{ url('/') }}">
          {{ config('app.name', 'Mega Store') }}
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
          <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <!-- Left Side Of Navbar -->
          <ul class="navbar-nav mr-auto">

          </ul>

          <!-- Right Side Of Navbar -->
          <ul class="navbar-nav ml-auto">
              <!-- Authentication Links -->
              @guest
                  <li class="nav-item">
                      <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                  </li>
                  @if (Route::has('register'))
                      <li class="nav-item">
                          <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                      </li>
                  @endif
              @else

                  <li class="nav-item dropdown">
                      <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                          {{ Auth::user()->email }}
                      </a>

                      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                          <a class="dropdown-item" href="{{ route('logout') }}"
                             onclick="event.preventDefault();
                                           document.getElementById('logout-form').submit();">
                              {{ __('Logout') }}
                          </a>

                          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                              @csrf
                          </form>
                      </div>
                  </li>

              @endguest
          </ul>
      </div>
  </div>
</nav>


<section class="jumbotron text-center">
  <div class="row">
    <div class="container">
      <h1>Mega Store</h1>
      <p class="lead text-muted">Welcome to Mega Store. We make sure that all products are available for online transactions.</p>
      <p>
        <a href="{{route('cart.all')}}" class="btn btn-primary my-2">View Cart</a>
        <a href="{{route('checkout.index')}}" class="btn btn-secondary my-2">CheckOut</a>
      </p>
    </div>
  </div>
    


  <div class="container text-center">

    <div class="row">
      <div class="col-md-3">
        @include('layouts.partials.sidebar')
      </div>

      <div class="col-md-12">

        @if (session()->has('message'))

        <p class="alert alert-success">

          {{ session()->get('message')}}
        </p>
            
        @endif
      </div>
    </div>
  </div>
  
  </section>

