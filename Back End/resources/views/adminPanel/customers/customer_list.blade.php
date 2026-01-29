@extends('adminPanel.layout.layout')

@section('main_content')
<div class="page-content">

    <!-- Breadcrumb -->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title fw-bold fs-4 text-primary">All Customer List</div>
        <div class="ms-auto">
            <button type="button" class="btn btn-gradient-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#addCustomerModal">
                <i class="lni lni-circle-plus me-1"></i> Add Customer
            </button>
        </div>
    </div>

    <!-- Customer List Table -->
    <div class="card border-0 shadow-lg rounded-4">
        <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center py-3 rounded-top">
            <h5 class="mb-0"><i class="lni lni-users me-1"></i> Customer Overview</h5>
            <span class="badge bg-light text-primary">Total: {{ $users->count() }}</span>
        </div>

        <div class="card-body p-4">
            <div class="table-responsive">
                <table id="customerTable" class="table table-hover align-middle">
                    <thead class="table-success text-center align-middle">
                        <tr>
                            <th>Sl</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $index => $customer)
                        <tr>
                            <td class="text-center fw-semibold">{{ $index + 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar bg-light-primary text-primary fw-bold me-2">
                                        {{ strtoupper(substr($customer->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <span class="fw-semibold">{{ $customer->name }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $customer->phone ?? 'N/A' }}</td>
                            <td>{{ $customer->email ?? 'N/A' }}</td>
                            <td>{{ $customer->address ?? 'N/A' }}</td>
                            <td class="text-center">
                                @if($customer->status == 1 || $customer->status === 'active')
                                <span class="badge bg-gradient-success px-3 py-2">Active</span>
                                @else
                                <span class="badge bg-gradient-danger px-3 py-2">Inactive</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        <i class="lni lni-cog"></i> Manage
                                    </button>
                                    <ul class="dropdown-menu shadow-sm">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('admin.customer.view', $customer->id) }}">
                                                <i class="lni lni-eye text-primary me-1"></i> View
                                            </a>
                                        </li>
                                        <li>
                                            <form action="{{ route('admin.customer.delete', $customer->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete this customer?')">
                                                    <i class="lni lni-trash me-1"></i> Delete
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Customer Modal -->
    <form action="{{ route('admin.customer.store') }}" method="POST">
        @csrf
        <div class="modal fade" id="addCustomerModal" tabindex="-1" aria-labelledby="addCustomerLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg rounded-4">
                    <div class="modal-header bg-gradient-primary text-white">
                        <h5 class="modal-title fw-bold"><i class="lni lni-user"></i> Add New Customer</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body px-4">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="fw-semibold">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control shadow-sm" name="name" placeholder="Enter full name" required>
                            </div>
                            <div class="col-md-4">
                                <label class="fw-semibold">Email</label>
                                <input type="email" class="form-control shadow-sm" name="email" placeholder="example@mail.com">
                            </div>
                            <div class="col-md-4">
                                <label class="fw-semibold">Phone</label>
                                <input type="text" class="form-control shadow-sm" name="phone" placeholder="Enter phone number">
                            </div>
                            <div class="col-md-12">
                                <label class="fw-semibold">Address</label>
                                <textarea class="form-control shadow-sm" name="address" rows="2" placeholder="Enter address"></textarea>
                            </div>
                            <div class="col-md-4">
                                <label class="fw-semibold">Status <span class="text-danger">*</span></label>
                                <select class="form-select shadow-sm" name="status" required>
                                    <option value="" disabled selected>Select status</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary shadow-sm" data-bs-dismiss="modal">
                            <i class="lni lni-close"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-gradient-primary shadow-sm">
                            <i class="lni lni-save"></i> Save Customer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

</div>
@endsection

@section('css_plugins')
<link href="{{ asset('assets/adminPanel/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
<style>
    .btn-gradient-primary {
        background: linear-gradient(45deg, #4facfe, #00f2fe);
        color: #fff;
        border: none;
    }

    .btn-gradient-primary:hover {
        background: linear-gradient(45deg, #00f2fe, #4facfe);
        color: #fff;
    }

    .badge.bg-gradient-success {
        background: linear-gradient(45deg, #56ab2f, #a8e063);
    }

    .badge.bg-gradient-danger {
        background: linear-gradient(45deg, #ff4b2b, #ff416c);
    }

    .avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
@endsection

@section('js_plugins')
<script src="{{ asset('assets/adminPanel/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/adminPanel/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        $('#customerTable').DataTable({
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            ordering: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search customers...",
            }
        });
    });
</script>
@endsection