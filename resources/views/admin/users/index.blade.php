@extends('admin.app')


@include('admin.users.partials.navbar')
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
          <h1 class="h2">Profiles</h1>
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
    
                @yield('breadcrumbs6')
              </ol>
            </nav>
          </div>

          <div class="container">

            @if(Session::has('success'))
  
            <div class="alert alert-success">
            
            <strong>Success:</strong> {{Session::get('success')}}
            </div>
            
            @endif

          <h2>Users List</h2>

          <div class="text-right">
            <a href="{{route('admin.profiles.create')}}">
            <input type="button" class="btn btn-success" value="Add User">
          </a>
          </div>

          <table class="table table-responsive">

            <table class="table table-striped table-sm">


                <thead>

                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Address</th>
                        <th>Date Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($users) && $users->count() > 0)
                    @foreach($users as $user)
                    <tr>
                        <td>{{@$user->id}}</td>
                        <td>{{@$user->profile->name}}</td>
                        <td>{{@$user->email}}</td>
                        <td>{{@$user->role->name}}</td>
                        <td>{{@$user->profile->address}}, {{@$user->profile->country->name}}, 
                          {{@$user->profile->state->name}}, {{@$user->profile->city->name}}</td>
                        <td>{{@$user->created_at}}</td>
                        <td>
                            <a href="javascript::" class="btn btn-danger" onclick="confirmDelete({{@$user->id}})">Delete</a> 
                            <form id="delete-user-{{$user->id}}" action="{{route('admin.profiles.destroy', $user->id)}}" 
                                method="POST" style="display: none">
                            
                                @method('DELETE')
                                @csrf
                            </form> | <a href="{{route('admin.profiles.edit', $user->id)}}" class="btn btn-info">Edit</a>
                        </td>

                    </tr>
                    @endforeach

                    @else

                    <tr>
                        <td colspan="6" class="alert alert-info">No users found!</td>
                    </tr>

                    @endif
                </tbody>
            </table>
          </table>
    

</div>

<div class="row">

  {{ $users->links() }}

</div>

@endsection

@section('scripts')
<script type="text/javascript">

    function confirmDelete(id) {

        let choice = confirm("Are you sure? You want to delete this user?");
        if(choice)
        document.getElementById('delete-user-'+id).submit();
    }
</script>


    
@endsection