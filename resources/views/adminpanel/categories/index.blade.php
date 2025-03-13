@extends('adminpanel.adminlayout')

@section('content')
<div class="container">
    <h2>Categories</h2>
    <a href="{{ route('categories.create') }}" class="btn btn-primary mb-3">Create New Category</a>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Subcategories</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                <td>{{ $category->name }}</td>
                <td>
                    @if($category->subcategories->count() > 0)
                        <ul>
                            @foreach($category->subcategories as $subcategory)
                                <li>{{ $subcategory->name }}</li>
                            @endforeach
                        </ul>
                    @else
                        No subcategories
                    @endif
                </td>
                <td>
                    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endsection