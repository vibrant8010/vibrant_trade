@extends('adminpanel.adminlayout')

@section('content')
    <div class="container">
        <h1>Edit Blog</h1>
        <form action="{{ route('admin.blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data" novalidate>
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="heading">Heading</label>
                <input type="text" class="form-control" name="heading" value="{{ $blog->heading }}" required>
            </div>

            <div class="form-group">
                <label for="detail_subcontent">Detail Subcontent</label>
                <textarea class="form-control ckeditor5" name="detail_subcontent" id="detail_subcontent" required>{{ $blog->detail_subcontent }}</textarea>
            </div>

            <!-- Dynamic Subtitle and Paragraph Fields -->
            <div id="dynamic-fields">
                @foreach ($blog->sections as $index => $section)
                    <div class="form-group">
                        <label for="subtitle{{ $index + 1 }}">Subtitle {{ $index + 1 }}</label>
                        <input type="text" class="form-control" name="subtitles[]" value="{{ $section->subtitle }}" required>
                    </div>
                    <div class="form-group">
                        <label for="textcontent{{ $index + 1 }}">Text Content {{ $index + 1 }}</label>
                        <textarea class="form-control ckeditor5" name="textcontents[]" id="textcontent{{ $index + 1 }}" required>{{ $section->textcontent }}</textarea>
                    </div>
                @endforeach
            </div>

            <!-- Button to Add More Fields -->
            <button type="button" id="add-field" class="btn btn-secondary mb-3">Add More Content</button>

            <div class="form-group">
                <label for="image_url">Blog Image</label>
                <input type="file" class="form-control" name="image_url">
                @if ($blog->image_url)
                    <img src="{{ asset($blog->image_url) }}" alt="Blog Image" width="100" class="mt-2">
                @endif
            </div>

            <button type="submit" class="btn btn-primary">Update Blog</button>
        </form>
    </div>

    <!-- Include CKEditor 5 -->
    <script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>

    <!-- Initialize CKEditor 5 and Handle Form Submission -->
    <script>
        // Initialize CKEditor 5 for all textareas with the class 'ckeditor5'
        document.querySelectorAll('.ckeditor5').forEach(textarea => {
            ClassicEditor
                .create(textarea)
                .catch(error => {
                    console.error(error);
                });
        });

        // Add Dynamic Fields
        document.getElementById('add-field').addEventListener('click', function () {
            const container = document.getElementById('dynamic-fields');
            const fieldCount = container.querySelectorAll('.form-group').length / 2 + 1;

            const subtitleDiv = document.createElement('div');
            subtitleDiv.className = 'form-group';
            subtitleDiv.innerHTML = `
                <label for="subtitle${fieldCount}">Subtitle ${fieldCount}</label>
                <input type="text" class="form-control" name="subtitles[]" required>
            `;
            container.appendChild(subtitleDiv);

            const textContentDiv = document.createElement('div');
            textContentDiv.className = 'form-group';
            textContentDiv.innerHTML = `
                <label for="textcontent${fieldCount}">Text Content ${fieldCount}</label>
                <textarea class="form-control ckeditor5" name="textcontents[]" id="textcontent${fieldCount}" required></textarea>
            `;
            container.appendChild(textContentDiv);

            // Initialize CKEditor 5 for the new textarea
            ClassicEditor
                .create(document.getElementById(`textcontent${fieldCount}`))
                .catch(error => {
                    console.error(error);
                });
        });

        // Validate CKEditor 5 content before form submission
        document.querySelector('form').addEventListener('submit', function (event) {
            let isValid = true;

            // Loop through all CKEditor 5 instances
            document.querySelectorAll('.ckeditor5').forEach(textarea => {
                const editor = ClassicEditor.instances[textarea.id];
                if (editor && editor.getData().trim() === '') {
                    isValid = false;
                    alert(`Please fill out the "${textarea.previousElementSibling.innerText}" field.`);
                }
            });

            // Prevent form submission if validation fails
            if (!isValid) {
                event.preventDefault();
            }
        });
    </script>
@endsection