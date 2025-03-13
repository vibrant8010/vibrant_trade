@extends('adminpanel.adminlayout')

@section('content')

<style>
    .top-products table{
      color: #f1f1f1;
    }
    .btn-edit-blue {
        background-color:#4434a0; /* Blue */
        color: white;
    }
   
</style>

<!-- Include DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">

<div class="container">
    <div class="heading-section">
        <div class="main-heading text-white">
            UserList
        </div>
        <div class="btn btn-primary">
            <a href="{{ route('admin.users.create') }}" class="btn text-white ">Create Users</a>
        </div>
    </div>
    @if (session('success'))
    <div class="alert alert-success" id="success-alert">
        {{ session('success') }}
    </div>

    <script>
        setTimeout(function() {
            document.getElementById('success-alert').style.display = 'none';
        }, 2000); // Change this value to 10000 for 10 seconds
    </script>
    @endif
    <section class="top-products mt-5">
        <div class="d-flex flex-row justify-content-between align-items-center mb-2">
       
            <!-- Search Bar -->
            <form action="{{ route('admin.users.index') }}" method="GET" class="input-group" style="max-width: 200px;">
                @csrf
                <input type="text" name="search" class="form-control border-primary" placeholder="Search Users" aria-label="Search Users" value="{{ request('search') }}" style="border-radius: 3px; box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);">
                {{-- <button type="submit" class="btn btn-primary">Search</button> --}}
            </form>
            
            <!-- Show Entries Dropdown -->
            
            <!-- Create Users Button -->
            {{-- <button class="btn btn-success" >Create Users</button> --}}
        
        </div>
        
    <div class="table-wrapper">
        <table id="usersTable" class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Contact No</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->mobileno }}</td>
                        <td>
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-edit-blue">Edit</a>
                        </td>
                        
                        <td>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    </section>
</div>

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<!-- Include DataTables JS -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>

<script>
    $(document).ready(function() {
        $('#usersTable').DataTable({
            "paging": true, // Enable pagination
            "searching": true, // Enable search functionality
            "ordering": true, // Enable column sorting
            "info": true, // Show table information
            "lengthChange": true, // Enable changing the number of entries shown
            "pageLength": 10, // Set default number of entries to show
            "language": {
                "paginate": {
                    "previous": "Previous",
                    "next": "Next"
                },
                "search": "Search:",
                "lengthMenu": "Show _MENU_ entries",
                "info": "Showing _START_ to _END_ of _TOTAL_ entries"
            }
        });
    });
</script>

@endsection



