@extends('adminpanel.adminlayout')

@section('content')
<div class="container">
    <h1>Edit User</h1>

    <!-- Display Validation Errors -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <!-- Basic User Fields -->
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" class="form-control" value="{{ old('username', $user->name) }}" required>
            @error('username')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            @error('email')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="mobileno">Mobile No.</label>
            <input type="number" name="mobileno" class="form-control" value="{{ old('mobileno', $user->mobileno) }}" required>
            @error('mobileno')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="role">Role</label>
            <select name="role" id="role" class="form-control" required>
                <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>User</option>
                <option value="business" {{ old('role', $user->role) === 'business' ? 'selected' : '' }}>Business</option>
            </select>
            @error('role')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <!-- Company Details Fields (Hidden by Default) -->
        <div id="company-details" style="display: {{ old('role', $user->role) === 'business' ? 'block' : 'none' }};">
            <h2>Company Details</h2>
            <div class="form-group">
                <label for="name">Company Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user->companyDetails->name ?? '') }}">
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="logo_upload">Upload Logo</label>
                <input type="file" name="logo_upload" class="form-control" id="logo_upload" accept="image/jpeg, image/png, image/jpg, image/gif, image/webp">
                @error('logo_upload')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                <!-- Image Preview -->
                <img id="logo_preview" src="{{ $user->companyDetails && $user->companyDetails->logo_url ? asset($user->companyDetails->logo_url) : '#' }}" alt="Logo Preview" style="max-width: 200px; margin-top: 10px; display: {{ $user->companyDetails && $user->companyDetails->logo_url ? 'block' : 'none' }};">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" class="form-control">{{ old('description', $user->companyDetails->description ?? '') }}</textarea>
                @error('description')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="gst_registration_date">GST Registration Date</label>
                <input type="date" name="gst_registration_date" class="form-control" value="{{ old('gst_registration_date', $user->companyDetails->gst_registration_date ?? '') }}">
                @error('gst_registration_date')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="gst_no">GST Number</label>
                <input type="text" name="gst_no" class="form-control" value="{{ old('gst_no', $user->companyDetails->gst_no ?? '') }}">
                @error('gst_no')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="legal_status">Legal Status</label>
                <input type="text" name="legal_status" class="form-control" value="{{ old('legal_status', $user->companyDetails->legal_status ?? '') }}">
                @error('legal_status')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="nature_of_business">Nature of Business</label>
                <input type="text" name="nature_of_business" class="form-control" value="{{ old('nature_of_business', $user->companyDetails->nature_of_business ?? '') }}">
                @error('nature_of_business')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="alternate_names">Alternate Names</label>
                <textarea name="alternate_names" class="form-control">{{ old('alternate_names', $user->companyDetails->alternate_names ?? '') }}</textarea>
                @error('alternate_names')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="city">City</label>
                <input type="text" name="city" class="form-control" value="{{ old('city', $user->companyDetails->city ?? '') }}">
                @error('city')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="state">State</label>
                <input type="text" name="state" class="form-control" value="{{ old('state', $user->companyDetails->state ?? '') }}">
                @error('state')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="pincode">Pincode</label>
                <input type="text" name="pincode" class="form-control" value="{{ old('pincode', $user->companyDetails->pincode ?? '') }}">
                @error('pincode')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>

<script>
    // Show/hide company details based on role selection
    document.getElementById('role').addEventListener('change', function () {
        const companyDetails = document.getElementById('company-details');
        if (this.value === 'business') {
            companyDetails.style.display = 'block';
        } else {
            companyDetails.style.display = 'none';
        }
    });

    // Image preview for logo upload
    document.getElementById('logo_upload').addEventListener('change', function(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('logo_preview');
            output.src = reader.result;
            output.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    });
</script>
@endsection