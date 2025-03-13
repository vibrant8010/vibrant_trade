@extends('adminpanel.adminlayout')

@section('content')
    <div class="container">
        <h1>Blogs</h1>
        <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary mb-3">Create New Blog</a>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Heading</th>
                    <th>Detail Subcontent</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($blogs as $blog)
                    <tr>
                        <td>{{ $blog->id }}</td>
                        <td>{{ $blog->heading }}</td>
                        <td>{!! Str::limit($blog->detail_subcontent, 50) !!}</td>
                        <td>
                            @if ($blog->image_url)
                                <img src="{{ asset($blog->image_url) }}" alt="Blog Image" width="100">
                            @else
                                No Image
                            @endif
                        </td>
                        <td>
                             <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('admin.blogs.destroy', $blog->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection