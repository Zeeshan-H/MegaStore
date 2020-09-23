@extends('admin.app')
@include('admin.categories.partials.navbaraddcat')
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
          <h1 class="h2">Categories</h1>
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

              @yield('breadcrumbs3')
            </ol>
          </nav>
        </div> 

<div class="container">

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
    <form action="@if(isset($category)) {{route('admin.category.update', $category->id)}} @else {{ route('admin.category.store')}} @endif" method='POST'>
    
    {{ csrf_field() }}
      @if(isset($category)) 

      @method('PUT')
      @endif

    <div class="col-xl-12">
    <label for="title">Title</label>
    <input type="text" id="texturl" class="form-control" name="title" value="{{@$category->title}}"> 
    
    </div>
        
    <div class="col-sm-12" style="margin-top:20px; margin-bottom:20px">
    
      <div class = "form-group">
        <label>Description</label>
        <textarea name="description" id="description" class = "form-control" rows = "14">{!! 
        @$category->description !!}  
        </textarea>
     </div>
    </div>

    <div class="col-sm-12">
      <div class="form-group">

        @php
            $ids = (isset($category->childrens) && $category->childrens->count()> 0) ? array_pluck($category->childrens, 'id') : null
        @endphp
        <label class="form-control-label">Select Category:</label>
        <select class="custom-select" name="parent_id[]" id="parent_id"  multiple>
          @if(isset($categories))
          <option value="0">No Category</option>
          @foreach ($categories as $cat)
          <option value="{{$cat->id}}" @if (!is_null($ids) && in_array($cat->id, $ids))
              {{'selected'}}
          @endif>{{$cat->title}}</option>              
          @endforeach
          @endif

        </select>
      </div>

    </div>
      <div class="col-sm-12">
        <div class="form-group">
         @if (isset($category))
         <input type="submit" class="btn btn-primary btn-block" value="Edit Category">
         @else
         <input type="submit" class="btn btn-primary btn-block" value="Add Category">

         @endif
          
        </div>
      </div>
    
    </form>
     
    
  @endsection
</div>

@section('scripts')

<script type="text/javascript">

$(function() {

    ClassicEditor
        .create( document.querySelector( '#editor' ), {

            toolbar: ['Heading', 'Link', 'bold', 'italic', 'bulletedList', 'numberedList', 
            'blockQuote', 'undo', 'redo'
        ]
        } )
        .then( editor => {

            console.log(editor);
        } )
        .catch( error => {
            console.error( 'There was a problem initializing the editor.', error );
        } );

        $('#txturl').on('keyup', function() {

            var url = slugify($(this).val());
            $('#url').html(url);
            $(#slug).val(url);
        })

});
</script>
@endsection