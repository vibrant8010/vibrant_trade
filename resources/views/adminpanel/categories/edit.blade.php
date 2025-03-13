@extends('adminpanel.adminlayout')

@section('content')
<div class="container">
    <h2>Edit Category</h2>
    <form action="{{ route('categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Category Name</label>
            <input type="text" name="name" id="name" 
                   class="form-control @error('name') is-invalid @enderror" 
                   value="{{ old('name', $category->name) }}" required>
            
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="subcategories">Subcategories</label>
            <input type="text" name="subcategories" id="subcategories" 
                   class="form-control @error('subcategories') is-invalid @enderror" 
                   value="{{ old('subcategories', $category->subcategories->implode('name', ', ')) }}" 
                   placeholder="Enter subcategories (comma-separated)">
            
            @error('subcategories')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update Category</button>
    </form>
</div>
@endsection