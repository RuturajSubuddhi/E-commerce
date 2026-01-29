@extends('adminPanel.layout.layout')
@section('main_content')
<!--start page wrapper -->
<div class="page-content">
    <!--breadcrumb-->
    {{-- <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">--}}
    {{-- <div class="breadcrumb-title">POS Customer List</div>--}}

    {{-- <div class="ms-auto">--}}
    {{-- <div class="btn-group">--}}
    {{-- <div class="d-flex gap-3 mt-3">--}}
    {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" --}} {{--
                            data-bs-target="#exampleModal">--}}
    {{-- <i class="lni lni-circle-plus"></i> Add Customer--}}
    {{-- </button>--}}
    {{-- </div>--}}
    {{-- </div>--}}
    {{-- </div>--}}
    {{-- </div>--}}

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>SI</th>
                            <th>Invoice No</th>
                            <th>Phone</th>
                            <th>Total Payable</th>
                            <th>Total Payed</th>
                            <th>Order Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orderList as $key => $order)
                        <tr>
                            <td>{{$key + 1}}</td>
                            <td>
                                # {{$order->invoice_id}}
                            </td>
                            <td>{{ $order->orderAddress->shipping_phone }}</td>
                            <td>
                                {{ round($order->total_payable_amount) }}
                            </td>
                            <td>{{round($order->total_paid) }}</td>
                            @if($order->order_status == 0)
                            <td><span class="badge bg-warning">Pending</span></td>
                            @elseif($order->order_status == 1)
                            <td>
                                <span class="badge bg-info">Processing</span>
                            </td>
                            @elseif($order->order_status == 2)
                            <td>
                                <span class="badge bg-primary">On The Way</span>
                            </td>
                            @elseif($order->order_status == 3)
                            <td>
                                <span class="badge bg-danger">Cancel Request</span>
                            </td>
                            @elseif($order->order_status == 4)
                            <td>
                                <span class="badge bg-success">Cancel Request accepted</span>
                            </td>
                            @elseif($order->order_status == 5)
                            <td>
                                <span class="badge bg-success">Cancel Process Completed</span>
                            </td>
                            @elseif($order->order_status == 6)
                            <td>
                                <span class="badge bg-success">Order Completed</span>
                            </td>
                            @elseif($order->order_status == 7)
                            <td>
                                <span class="badge bg-success">Out For Delivery</span>
                            </td>
                            @elseif($order->order_status == 8)
                            <td>
                                <span class="badge bg-success">Return Requested</span>
                            </td>

                            @elseif($order->order_status == 9)
                            <td>
                                <span class="badge bg-success">Return Request Accepted</span>
                            </td>
                            @elseif($order->order_status == 10)
                            <td>
                                <span class="badge bg-success">Return Request Rejected </span>
                            </td>
                            @elseif($order->order_status == 11)

                            <td>
                                <span class="badge bg-success">Refund Completed </span>
                            </td>
                            @endif


                            <td>
                                <div class="dropdown d-flex justify-content-center">
                                    <button class="btn btn-primary dropdown-toggle dr-btn" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">Settings
                                    </button>
                                    <ul class="dropdown-menu">

                                        <li>
                                            <a class="dropdown-item" onclick="productDetails({{ $order->id }})"
                                                href="#">
                                                Order Details
                                            </a>
                                        </li>

                                        <!-- Pending -->
                                        <li>
                                            <form action="{{ route('admin.order.status.update') }}" method="POST"
                                                onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                                <input type="hidden" name="status" value="0">
                                                <button type="submit" class="dropdown-item">Pending</button>
                                            </form>
                                        </li>

                                        <!-- Processing -->
                                        <li>
                                            <form action="{{ route('admin.order.status.update') }}" method="POST"
                                                onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                                <input type="hidden" name="status" value="1">
                                                <button type="submit" class="dropdown-item">Processing</button>
                                            </form>
                                        </li>

                                        <!-- On the Way -->
                                        <li>
                                            <form action="{{ route('admin.order.status.update') }}" method="POST"
                                                onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                                <input type="hidden" name="status" value="2">
                                                <button type="submit" class="dropdown-item">On The Way</button>
                                            </form>
                                        </li>

                                        <!-- Cancel Request Accepted (only if status = 3) -->
                                        @if($order->order_status == 3)
                                        <li>
                                            <form action="{{ route('admin.order.status.update') }}" method="POST"
                                                onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                                <input type="hidden" name="status" value="4">
                                                <button type="submit" class="dropdown-item">Cancel Request
                                                    Accepted</button>
                                            </form>
                                        </li>
                                        @endif

                                        @if($order->order_status == 4)
                                        <li>
                                            <form action="{{ route('admin.order.status.update') }}" method="POST"
                                                onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                                <input type="hidden" name="status" value="5">
                                                <button type="submit" class="dropdown-item">Cancel Request
                                                    Completed</button>
                                            </form>
                                        </li>
                                        @endif

                                        <!-- Order Completed -->
                                        <li>
                                            <form action="{{ route('admin.order.status.update') }}" method="POST"
                                                onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                                <input type="hidden" name="status" value="6">
                                                <button type="submit" class="dropdown-item">Order Completed</button>
                                            </form>
                                        </li>

                                        @if($order->order_status == 2)
                                        <li>
                                            <form action="{{ route('admin.order.status.update') }}" method="POST"
                                                onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                                <input type="hidden" name="status" value="7">
                                                <button type="submit" class="dropdown-item">Out For Delivery</button>
                                            </form>
                                        </li>
                                        @endif

                                        @if($order->order_status == 8)
                                        <li>
                                            <form action="{{ route('admin.order.status.update') }}" method="POST"
                                                onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                                <input type="hidden" name="status" value="9">
                                                <button type="submit" class="dropdown-item">Return Request Accepted</button>
                                            </form>
                                        </li>
                                        @endif
                                        @if($order->order_status == 8)
                                        <li>
                                            <form action="{{ route('admin.order.status.update') }}" method="POST"
                                                onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                                <input type="hidden" name="status" value="10">
                                                <button type="submit" class="dropdown-item">Return Request Rejected</button>
                                            </form>
                                        </li>
                                        @endif

                                        @if($order->order_status == 9)
                                        <li>
                                            <form action="{{ route('admin.order.status.update') }}" method="POST"
                                                onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                                <input type="hidden" name="status" value="11">
                                                <button type="submit" class="dropdown-item">Refund Completed</button>
                                            </form>
                                        </li>
                                        @endif

                                    </ul>

                                </div>
                            </td>
                        </tr>

                        @endforeach



                    </tbody>
                    <tfoot>

                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="orderDetails" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Order Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body " id="detailInfo">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->



    {{--Edit --}}

    {{-- modal--}}
</div>
<!--end page wrapper -->
@endsection
@section('css_plugins')
<link href="{{asset('assets/adminPanel')}}/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
@endsection
@section('js_plugins')

<script src="{{asset('assets/adminPanel')}}/plugins/datatable/js/jquery.dataTables.min.js"></script>
<script src="{{asset('assets/adminPanel')}}/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
@endsection
@section('js')
<script>
    function productDetails(order_id) {
        // alert(data)
        const router = "{{url('admin/order/details')}}"

        $.ajax({
            url: router,
            type: "get",
            data: {
                "id": order_id,
            },
            success: function(response) {
                console.log(response)
                $('#detailInfo').html(response);
            },
            error: function(xhr) {
                //Do Something to handle error
            }
        });



        $('#orderDetails').modal('show')
    }
    $(document).ready(function() {
        $('#example').DataTable({});
    });
</script>
<script>
    $(document).ready(function() {
        var table = $('#example2').DataTable({
            lengthChange: false,
            buttons: ['copy', 'excel', 'pdf', 'print']
        });

        table.buttons().container()
            .appendTo('#example2_wrapper .col-md-6:eq(0)');
    });
</script>
<script>
    $('#orderDetails').on('click', '.btn-primary', function(e) {
        e.preventDefault();

        var form = $('#orderNoteForm');
        if (form.length === 0) {
            alert('Note form is not loaded.');
            return;
        }

        var data = {
            _token: "{{ csrf_token() }}",
            order_id: form.find('input[name="order_id"]').val(),
            note: form.find('textarea[name="note"]').val()
        };

        $.ajax({
            url: "{{ route('admin.order.update.note') }}",
            type: "POST",
            data: data,
            success: function(response) {
                alert(response.message);
                $('#orderDetails').modal('hide');
                location.reload(); // optional, to refresh the list with updated data
            },
            error: function(xhr) {
                alert('Failed to update the note.');
            }
        });
    });
</script>


@endsection