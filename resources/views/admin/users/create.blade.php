@extends('admin.app')

@section('content')
    
@include('admin.users.partials.navbaradduser')

<div class="container-fluid">
    <div class="row">
      <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
        <div class="sidebar-sticky pt-3">
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link active" href="{{url('/admin/dashboard')}}">
                <span data-feather="home"></span>
                Dashboard <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">
                <span data-feather="file"></span>
                Orders
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{route('admin.product.index')}}">
                <span data-feather="shopping-cart"></span>
                Products
              </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('admin.category.index')}}">
                  <span data-feather="bar-chart-2"></span>
                  Categories
                </a>
              </li>
            <li class="nav-item">
              <a class="nav-link" href="#">
                <span data-feather="users"></span>
                Customers
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="#">
                <span data-feather="layers"></span>
                Integrations
              </a>
            </li>
          </ul>
  
          <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
            <span>Saved reports</span>
            <a class="d-flex align-items-center text-muted" href="#" aria-label="Add a new report">
              <span data-feather="plus-circle"></span>
            </a>
          </h6>
          <ul class="nav flex-column mb-2">
            <li class="nav-item">
              <a class="nav-link" href="#">
                <span data-feather="file-text"></span>
                Current month
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">
                <span data-feather="file-text"></span>
                Last quarter
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">
                <span data-feather="file-text"></span>
                Social engagement
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">
                <span data-feather="file-text"></span>
                Year-end sale
              </a>
            </li>
          </ul>
        </div>
      </nav>
  
      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Add/Edit User</h1>
          <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-2">
              <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
              <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
            </div>
            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
              <span data-feather="calendar"></span>
              This week
            </button>
          </div>
        </div>


        <div class="col-md-12">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
  
                @yield('breadcrumbs10')
              </ol>
            </nav>
          </div>

          @if(Session::has('success'))

          <div class="alert alert-success">
          
          <strong>Success:</strong> {{Session::get('success')}}
          </div>
          
          @endif

          @if(count($errors) > 0) 
          <div class="alert alert-danger">
            <strong>Error</strong> 
            
            <ul>
            @foreach($errors->all() as $error) 
            <li>{{ $error }}</li>
            @endforeach
            </ul>
            </div>
            
            
            @endif

          <form action="@if(isset($user)) {{route('admin.profiles.update', $user)}} @else {{route('admin.profiles.store')}} 
          @endif" method="POST" accept-charset="utf-8" enctype="multipart/form-data"> 
          <div class="row">


            @csrf
            @if(isset($user)) 
            @method('PUT')
            @endif

            <div class="col-lg-9">


                <div class="form-group row">

                   
                            <label class="form-control-label">Name: </label>
                            <input type="text" id="name" name="name" class="form-control" 
                            value="{{@$user->profile->name}}"> 
                           
                </div>

                <div class="form-group row">

                   
                  <label class="form-control-label">Email: </label>
                  <input type="text" id="email" name="email" class="form-control" 
                  value="{{@$user->email}}"> 
                 
      </div>

      <div class="form-group row">

                   
        <label class="form-control-label">Password: </label>
        <input type="password" id="password" name="password" class="form-control" 
        value="{{@$user->password}}"> 
       
</div>

<div class="form-group row">

                   
  <label class="form-control-label">Re-type Password: </label>
  <input type="password" id="password_confirm" name="password_confirm" class="form-control"> 
 
</div>

                <div class="form-group row">
                    
                        <label class="form-control-label">Status</label>

                        <div class="input-group mb-3">

                            <select name="status" id="status" class="form-control">

                                <option value="0" @if(isset($user) && $user->status == 0) {{'selected'}} @endif>Blocked</option>
                                <option value="1" @if(isset($user) && $user->status == 1) {{'selected'}} @endif>Active</option>
                            </select>
                        </div>
                    

                </div>
                @php
                  $ids = (isset($user->role) && $user->role->count() > 0) ? 
                  array_pluck($user->role->toArray(), 'id') : null;  
                @endphp

            </div>
          </div>

          <div class="form-group row">

            <label class="form-control-label">Select Role: </label>
            <select name="role_id" id="role" class="form-control">

                @if($roles->count() > 0)

                @foreach ($roles as $role)
                    
                <option value="{{$role->id}}" 
                    @if(!is_null($ids) && in_array($role->id, $ids)) 
                    {{'selected'}} 
                    @endif>{{$role->name}}</option>
                @endforeach
                @endif
            </select>
          </div>

            <div class="form-group row">


                <label class="form-control-label">Address: </label> 
                <div class="input-group mb-3">

                    <input type="text" name="address" class="form-control" value="{{@$user->address}}">
                </div>
            </div>

            <div class="form-group row">

              <div class="input-group mb-3">

                <div class="custom-file">

                  <input type="file" class="custom-file-input" name="thumbnail" id="thumbnail"> 
                  <label for="thumbnail" class="custom-file-label">Choose file</label>
                </div>

           
                {{-- <div class="img-thumbnail text-center">
                  
                  
                  <img height="50px" width="200px" src="@if(isset($user)) {{asset('images/profiles'.$user->thumbnail)}} @else 
                  {{asset('images/no-thumbnail.jpeg')}} @endif" id="imgthumbnail" class="img-fluid" alt="">
              </div> --}}
              </div>
            </div>

            <div class="form-group row">

                <div class="col-sm-6 col-md-3">

                    <label class="form-control-label">Country:</label>
                    <div class="input-group mb-3">

                      <select name="country_id" class="form-control" id="countries">
                        <option value="0">Select a Country</option>
                        @foreach($countries as $country)
                        <option value="{{$country->id}}">{{$country->name}}</option>
                        @endforeach
                      </select>
                    </div>
                </div>

                <div class="col-sm-6 col-md-3">

                    <label class="form-control-label">State: </label>

                    <div class="input-group mb-3">

                        <select name="state_id" class="form-control" id="states">
                            <option value="0">Select a state</option>
                       

                        </select>
                    </div>

            </div>

            <div class="col-sm-6 col-md-3">

                <label class="form-control-label">City: </label>

                <div class="input-group mb-3">

                    <select name="city_id" class="form-control" id="cities">


                    </select>
                </div>
        </div>

            </div>

            <div class="form-group row">


                @if(isset($user)) 

                <input type="submit" name="submit" class="btn btn-primary btn-block" value="Update User"> 
                @else 
                <input type="submit" name="submit" class="btn btn-primary btn-block" value="Add User"> 
                @endif
            </div>



          </form>
@endsection


@section('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">

$(function(){
		$('#txturl').on('keyup', function(){
			const pretty_url = slugify($(this).val());
			$('#url').html(slugify(pretty_url));
			$('#slug').val(pretty_url);
		})
$('#thumbnail').on('change', function() {
var file = $(this).get(0).files;
var reader = new FileReader();
reader.readAsDataURL(file[0]);
reader.addEventListener("load", function(e) {
var image = e.target.result;
$("#imgthumbnail").attr('src', image);
});
});
// Set up the Select2 control
$('#countries').select2().trigger('change');
$('#states').select2();
$('#cities').select2();
//On Country Change
$('#countries').on('change', function(){
	var id = $('#countries').select2('data')[0].id;
	$('#states').val(null);
	$('#states option').remove();

  console.log(id);
	// Fetch the preselected item, and add to the control
var studentSelect = $('#states');
$.ajax({
type: 'GET',
url: "{{route('admin.profile.states')}}/" + id
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
//On state Change
$('#states').on('change', function(){
	var id = $('#states').select2('data')[0].id;
	// Fetch the preselected item, and add to the control
	var studentSelect = $('#cities');
	$('#cities').val(null);
	$('#cities option').remove();
$.ajax({
type: 'GET',
url: "{{route('admin.profile.cities')}}/" + id
}).then(function (data) {
	// create the option and append to Select2
	for(i=0; i< data.length; i++){
		var item = data[i]
		var option = new Option(item.name, item.id, false, false);
		studentSelect.append(option);
	}
	});
studentSelect.trigger('change');
})
})
</script>
    
@endsection