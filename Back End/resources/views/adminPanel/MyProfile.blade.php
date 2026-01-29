@extends('adminPanel.layout.layout')

@section('main_content')
<!--start page wrapper -->
<div class="page-content">

    <div class="container mt-5 d-flex justify-content-center">

        <div class="card p-4 profile-card" style="border-radius: 12px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);">
            <!-- Display Success/Error Messages -->
            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="text-center mb-4">
                <h3 class="mb-2">My Profile</h3>
                <img src="{{ $admin->profile_photo ? asset('uploads/admin/' . $admin->profile_photo) : asset('adminPanel/assets/img/default_profile.png') }}"
                    alt="Profile Picture" class="profile-img"
                    style="width:130px;height:130px;object-fit:cover;border-radius:50%;border:3px solid #18b48c;">
            </div>

            <form action="{{ route('admin.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="mb-3 col-md-3">
                        <label class="profile-label" style="font-weight:600;color:#333;">Full Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $admin->name ?? '' }}">
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-3 col-md-3">
                        <label class="profile-label" style="font-weight:600;color:#333;">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ $admin->email ?? '' }}">
                        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-3 col-md-3">
                        <label class="profile-label" style="font-weight:600;color:#333;">Phone Number</label>
                        <input type="text" name="phone" class="form-control" value="{{ $admin->phone ?? '' }}" maxlength="10" minlength="10" oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                        @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-3 col-md-3">
                        <label class="profile-label" style="font-weight:600;color:#333;">Gender</label>
                        <select name="gender" class="form-control">
                            <option value="">Select Gender</option>
                            <option value="Male" {{ ($admin->gender == 'Male') ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ ($admin->gender == 'Female') ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ ($admin->gender == 'Other') ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('gender') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="section-title"
                    style="font-size:1.2rem;font-weight:600;color:#18b48c;margin-top:20px;margin-bottom:10px;">Address
                </div>

                <div class="row">
                    <div class="mb-2 col-md-4">
                        <label class="profile-label">Address Line</label>
                        <input type="text" name="address" class="form-control" value="{{ $admin->address ?? '' }}">
                        @error('address') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-2 col-md-4">
                        <label class="profile-label">City</label>
                        <input type="text" name="city" class="form-control" value="{{ $admin->city ?? '' }}">
                        @error('city') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-2 col-md-4">
                        <label class="profile-label">State</label>
                        <input type="text" name="state" class="form-control" value="{{ $admin->state ?? '' }}">
                        @error('state') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-4 col-md-4">
                        <label class="profile-label">Pincode</label>
                        <input type="text" name="pincode" class="form-control" value="{{ $admin->pincode ?? '' }}" maxlength="7" minlength="7" oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                        @error('pincode') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-4 col-md-4">
                        <label class="profile-label">Profile Photo</label>
                        <input type="file" name="photo" class="form-control">
                        @error('photo') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="text-center d-flex justify-content-between">
                    <a href="{{ route('home') }}" class="btn btn-warning px-4">Back</a>
                    <button type="submit" class="btn btn-success px-4">Update Profile</button>
                </div>
            </form>

        </div>

    </div>

</div>
<!--end page wrapper -->
@endsection

@section('css_plugins')
<style>
    .profile-card {
        width: -webkit-fill-available;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .profile-img {
        width: 130px;
        height: 130px;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid #18b48c;
    }

    .profile-label {
        font-weight: 600;
        color: #333;
    }

    .section-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: #18b48c;
        margin-top: 20px;
        margin-bottom: 10px;
    }
</style>
@endsection