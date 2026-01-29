<!-- @extends('adminPanel.layouts.master')

@section('content')
<div class="container mt-4">
    <h4 class="mb-4">All Customers</h4>

    <div class="row">
        @foreach($users as $user)
        <div class="col-md-3 mb-4">
            <div class="card radius-10 border-start border-0 border-3 border-success shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Customer</p>
                            <h5 class="my-1 text-success">{{ $user->name }}</h5>
                            <p class="mb-0 font-13">{{ $user->email }}</p>
                            <p class="mb-0 font-13">{{ $user->phone ?? 'N/A' }}</p>
                        </div>
                        <div class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto">
                            <i class='bx bxs-user'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection -->
