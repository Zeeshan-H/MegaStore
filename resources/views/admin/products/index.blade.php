@extends('admin.app');

@include('admin.products.partials.navbar')  


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
                  <a class="nav-link" href="{{route('admin.profiles.index')}}">
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
    
                  @yield('breadcrumbs')
                </ol>
              </nav>
            </div> 

            <div class="container">

              @if(Session::has('success'))
    
              <div class="alert alert-success">
              
              <strong>Success:</strong> {{Session::get('success')}}
              </div>
              
              @endif

            <div class="text-right">
              <a href="{{route('admin.product.create')}}">
              <input type="button" class="btn btn-success" value="Add Product">
            </a>
            </div>

            <h2>Products List</h2>
            <div class="table-responsive">
              <table class="table table-striped table-sm">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Date Created</th>
                    <th>Actions</th>
  
   
                  
                  </tr>
                </thead>
                <tbody>
  
                    @if($products)
                    @foreach ($products as $product)
                    <tr>                      
  
                    <td>{{$product->id}}</td>
                    <td>{{$product->title}}</td>
                    <td>{!! $product->description !!}</td>
                    <td>
                       {{-- @if($product->childrens()->count() > 0)
                      
                      @foreach ($product->childrens as $children)
                          {{$children->title}},
                      @endforeach
                      @else
                      <strong>{{"Parent Category"}}</strong>
                      @endif
                        --}}
                        {{$product->price}}
                    </td>
                    <td>{{$product->created_at}}</td>
  
                    <td><a href="{{route('admin.product.edit', $product->id)}}" class="btn btn-info">Edit</a> | <a href="javascript::" onclick="confirmDelete('{{$product->id}}')" class="btn btn-danger">Delete</a> 
                    
                    <form action="{{route('admin.product.destroy', $product->id)}}" method="POST" style="display: none" id="delete-product-{{$product->id}}">
  
                      @method('DELETE')
                      @csrf
                    </form>
                    </td>
                    @endforeach
                  </tr>
  
                  @else
                  <tr>
                    <td colspan="5">No Products Found!</td>
                  </tr>
                  @endif
                  
                </tbody>
              </table>
  
@endsection

@section('scripts')
            
<script type="text/javascript">

  function confirmDelete(id) {

    let choice = confirm('Are you sure you want to delete this product?');
    if(choice)
    document.getElementById('delete-product-' +id).submit();
  }
</script>
@endsection