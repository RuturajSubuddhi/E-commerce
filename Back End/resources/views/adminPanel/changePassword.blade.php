@extends('adminPanel.layout.layout')
 
@section('main_content')
    <div class="page-content">
        <div class="container mt-5 d-flex justify-content-center">
            <div class="card p-4 profile-card"
                style="border-radius: 12px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); width: 480px;">
                <h3 class="text-center mb-4">Change Password</h3>
 
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
 
                <form action="{{ route('admin.password.save') }}" method="POST">
                    @csrf
 
                    {{-- Old Password --}}
                    <div class="mb-3 position-relative">
                        <label class="profile-label">Old Password</label>
                        <input type="password" name="old_password" class="form-control" id="old_password">
                        <span class="toggle-password" onclick="togglePassword('old_password')"
                            style="position:absolute; right:10px; top:25px; cursor:pointer;">👁️</span>
                        @error('old_password') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
 
                    {{-- New Password --}}
                    <div class="mb-3 position-relative">
                        <label class="profile-label">New Password</label>
                        <input type="password" name="new_password" class="form-control" id="new_password">
                        <span class="toggle-password" onclick="togglePassword('new_password')"
                            style="position:absolute; right:10px; top:25px; cursor:pointer;">👁️</span>
                        @error('new_password') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
 
                    {{-- Confirm Password --}}
                    <div class="mb-3 position-relative">
                        <label class="profile-label">Confirm New Password</label>
                        <input type="password" name="new_password_confirmation" class="form-control" id="confirm_password">
                        <span class="toggle-password" onclick="togglePassword('confirm_password')"
                            style="position:absolute; right:10px; top:25px; cursor:pointer;">👁️</span>
                    </div>
 
                    <div class="text-center d-flex justify-content-between mt-4">
                        <a href="{{ route('admin.myprofile') }}" class="btn btn-warning px-4">Back</a>
                        <button type="submit" class="btn btn-success px-4">Update Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
 
@section('css_plugins')
    <style>
        .profile-card {
            width: -webkit-fill-available;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
 
        .profile-label {
            font-weight: 600;
            color: #333;
        }
 
        .toggle-password {
            font-size: 1.1rem;
            user-select: none;
        }
    </style>
 
    <script>
        function togglePassword(fieldId) {
            const input = document.getElementById(fieldId);
            if (input.type === "password") {
                input.type = "text";
            } else {
                input.type = "password";
            }
        }
    </script>
@endsection