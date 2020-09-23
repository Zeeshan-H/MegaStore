@extends('admin.app');

@include('admin.products.partials.navbaraddpod')


@section('content')
    

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
              <h1 class="h2">Products</h1>
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
    
                  @yield('breadcrumbs5')
                </ol>
              </nav>
            </div> 

            <h2>Add/Edit Products</h2>
  
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

                <form action="@if(isset($product)) {{route('admin.product.update', $product)}} @else {{route('admin.product.store')}} @endif" 
                method="POST" accept-charset="utf-8" enctype="multipart/form-data"> 
                  {{ csrf_field() }}
                  @if (isset($product))
                      @method('PUT')
                  @endif
                        <div class="row">


                            <div class="col-lg-9">

                                <div class="form-group row">


                                    <div class="col-lg-12">

                                        <label class="form-control-label">Title</label>
                                        <input type="text" id="txturl" name="title" class="form-control" value="{{@$product->title}}">
                                    </div>
                                </div>

                                <div class="form-group row">

                                    <div class="col-lg-12">

                                        <label class="form-control-label">Description</label>
                                        <textarea name="description" id="editor" cols="30" rows="10" class="form-control">{!! 
                                        @$product->description !!}</textarea>
                                    </div>

                                </div>

                                <div class="form-group row">

                                    <div class="col-6">

                                        <label class="form-control-labe">Price</label>
                                        <div class="input-group mb-3">

                                            <div class="input-group-prepend">

                                                <span class="input-group-text" id="basic-addon1">$</span>
                                                <input type="text" name="price" class="form-control" placeholder="0.00" aria-label="Username" 
                                                aria-describedby="basic-addon1" value="{{@$product->price}}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-6">

                                        <label class="form-control-labe">Discount</label>
                                        <div class="input-group mb-3">

                                            <div class="input-group-prepend">

                                                <span class="input-group-text" id="basic-addon2">$</span>
                                                <input type="text" class="form-control" name="discount_price" placeholder="0.00" aria-label="discount_price" 
                                                aria-describedby="discount" value="{{@$product->discount_price}}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-9">
                                      <div class="form-group row">
                                        <div class="col-lg-12">

                                          <h5>Status</h5>
                                          <select class="form-control" name="status" id="status">
                                              <option value="1" @if(isset($product) && $product->status == 1) {{'selected'}} @endif>Pending</option>
                                              <option value="2" @if(isset($product) && $product->status == 2) {{'selected'}} @endif>Publish</option>

                                          </select>
                                        </div>

                                      </div>
                                   
                                    </div>


                                    <div class="col-lg-9">
                                      <div class="form-group row">
                                        <div class="col-lg-12">
                                        <div class="custom-file">
                                          <input type="file" name="thumbnail" id="thumbnail" class="custom-file-input">
                                      <label class="custom-file-label" for="thumbnail">Choose file</label>
                                      </div>

                                      </div>
                                    </div>
                                    </div>        
                                                
                                    <div class="col-lg-9">
                                      <div class="form-group row">

                                        <div class="col-lg-12">
                                          <h5>Featured Image</h5>
                                          <div class="input-group mb-3">

                                              <div class="input-group-prepend">

                                                  <span class="input-group-text"> <input id="featured" type="checkbox" name="featured" value="@if(isset($product)){{@$product->featured}}@else{{0}}@endif" id="" 
                                                    @if(isset($product) && $product->featured == 1) {{'checked'}} @endif></span>
                                              </div>
                                              <p type="text" class="form-control" name="featured" placeholder="0.00" aria-label="featured" 
                                              aria-describedby="featured">Featured Product</p>
                                          </div>
                                      </div>
                                      </div>

                                    </div>



                                                {{-- <div class="img-thumbnail text-center">
                                                    
                                                    <img height="50px" width="200px" src="@if(isset($product)) {{asset('images/'.$product->thumbnail)}} @else 
                                                    {{asset('images/no-thumbnail.jpeg')}} @endif" id="imgthumbnail" class="img-fluid" alt="">
                                                </div>
                                             --}}



                                            
                                            @php
                                            $ids = (isset($product) && $product->categories->count()> 0) ? array_pluck($product->categories->toArray(), 'id') : null; 
                                         
                                        @endphp
                                        

                                        <div class="col-lg-9">
                                          <div class="form-group row">

                                            <div class="col-lg-12">

                                            
                                            <select name="category_id[]" class="browser-default custom-select" multiple>
                                            
                                                @if($categories->count() > 0)
                                                @foreach ($categories as $category)
                                                    
                        
                                                <option value="{{$category->id}}"
                                                  @if(!is_null($ids) && in_array($category->id, $ids)) 
                                                  {{'selected'}}
                                                  @endif 
                                                  >{{$category->title}}</option>
                                                @endforeach                       
                                                @endif
                                              </select>
                                        </div>
                                      </div>
                                        </div>


                                        <div class="col-lg-12">
                                          <div class="form-group row">

                                            <div class="col-lg-12">
        
                                              @if(isset($product))
                                                <input type="submit" name="submit" class="btn btn-primary btn-block" 
                                                value="Update Product">
                                                @else
                                                <input type="submit" name="submit" class="btn btn-primary btn-block" 
                                                value="Add Product">
        
                                                @endif
                                            </div>
                                        </div>

                                        </div>
                                    </div>



                                </div>
                           


                            </div>
                        </div>
                </form>                

  


@endsection

@section('scripts')

<script type="text/javascript">

  $('#thumbnail').on('change', function() {

    var file = $(this).get(0).files;
    var reader = new FileReader();
    reader.readAsDataURL(file[0]);
    reader.addEventListener("load", function(e) {
      var image = e.target.result;
      $('#imgthumbnail').attr('src', image);
    });
  });

  $('#featured').on('change', function() {
    if($this.is(":checked"))

    $(this).val(1);
    else
    $(this).val(0);
  });
</script>
    
@endsection

