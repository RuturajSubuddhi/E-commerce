<!-- Sidebar Wrapper -->
<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header d-flex justify-content-center align-items-center">
        <img src="{{ asset('assets/adminPanel/images/Animezz-logo-white.png') }}" class="logo-icon" alt="Company Logo">
        <div>
            <h4 class="logo-text">Animezz</h4>
        </div>
        <div class="toggle-icon ms-auto">
            <i class="bx bx-arrow-to-left"></i>
        </div>
    </div>

    <!-- Navigation -->
    <ul class="metismenu" id="menu">

        <!-- POS Quick Add -->
        <li>
            <a href="{{ route('admin.pos.view') }}">
                <div class="menu-title text-center">
                    <span class="add-menu-sidebar d-flex justify-content-center align-items-center" data-toggle="modal" data-target="#addOrderModalside">
                        <i class="fa fa-plus me-2"></i>
                        <span class="nav-text text-white">
                            <i class="lni lni-circle-plus"></i> POS
                        </span>
                    </span>
                </div>
            </a>
        </li>

        <!-- Home -->
        <li>
            <a href="{{ route('home') }}">
                <div class="parent-icon"><i class="bx bx-home-circle"></i></div>
                <div class="menu-title">Home</div>
            </a>
        </li>

        <!-- Admin Role -->
        @if(userCanAccess('h1'))
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="lni lni-cart"></i></div>
                <div class="menu-title">Admin Role</div>
            </a>
            <ul>
                @if(userCanAccess('1'))
                <li><a href="{{ route('admin.role.create') }}"><i class="bx bx-right-arrow-alt"></i>Role</a></li>
                @endif
                @if(userCanAccess('2'))
                <li><a href="{{ route('admin.admin.create') }}"><i class="bx bx-right-arrow-alt"></i>Create Admin</a></li>
                @endif
            </ul>
        </li>
        @endif

        <!-- POS -->
        @if(userCanAccess('h2'))
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="lni lni-cart"></i></div>
                <div class="menu-title">POS</div>
            </a>
            <ul>
                @if(userCanAccess('3'))
                <li><a href="{{ route('admin.pos.view') }}"><i class="bx bx-right-arrow-alt"></i>POS</a></li>
                @endif
                @if(userCanAccess('4'))
                <li><a href="{{ route('sell.list') }}"><i class="bx bx-right-arrow-alt"></i>Sell List</a></li>
                @endif
                <li><a href="{{ route('admin.pos.customer.list') }}"><i class="bx bx-right-arrow-alt"></i>POS Customer List</a></li>
                <li><a href="{{ route('admin.customer.list') }}"><i class="bx bx-right-arrow-alt"></i>Customer List</a></li>
            </ul>
        </li>
        @endif

        <!-- Product -->
        @if(userCanAccess('h3'))
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="lni lni-producthunt"></i></div>
                <div class="menu-title">Product</div>
            </a>
            <ul>
                @if(userCanAccess('8'))
                <li><a href="{{ route('admin.product.list') }}"><i class="bx bx-right-arrow-alt"></i>Products List</a></li>
                @endif
                @if(userCanAccess('5'))
                <li><a href="{{ route('admin.create.product') }}"><i class="bx bx-right-arrow-alt"></i>Add Products</a></li>
                @endif
                @if(userCanAccess('6'))
                <li><a href="{{ route('admin.product.category') }}"><i class="bx bx-right-arrow-alt"></i>Category</a></li>
                @endif
                @if(userCanAccess('7'))
                <li><a href="{{ route('admin.product.subcategory') }}"><i class="bx bx-right-arrow-alt"></i>Subcategory</a></li>
                @endif
                <li><a href="{{ route('admin.product.color.show') }}"><i class="bx bx-right-arrow-alt"></i>Product Color</a></li>
                <li><a href="{{ route('admin.product.size.show') }}"><i class="bx bx-right-arrow-alt"></i>Product Size</a></li>
                <li><a href="{{ route('admin.product.brand') }}"><i class="bx bx-right-arrow-alt"></i>Product Brand</a></li>
            </ul>
        </li>
        @endif

        <!-- Orders -->
        @if(userCanAccess('h8'))
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="lni lni-package"></i></div>
                <div class="menu-title">Order</div>
            </a>
            <ul>
                @if(userCanAccess('15'))
                <li><a href="{{ route('admin.order.pending') }}"><i class="bx bx-right-arrow-alt"></i>Pending Order</a></li>
                @endif
                @if(userCanAccess('16'))
                <li><a href="{{ route('admin.order.processing') }}"><i class="bx bx-right-arrow-alt"></i>Processing Order</a></li>
                @endif
                @if(userCanAccess('17'))
                <li><a href="{{ route('admin.order.on-the-way') }}"><i class="bx bx-right-arrow-alt"></i>Order On The Way</a></li>
                @endif
                @if(userCanAccess('18'))
                <li><a href="{{ route('admin.order.cancel.request') }}"><i class="bx bx-right-arrow-alt"></i>Order Cancel Request</a></li>
                @endif
                @if(userCanAccess('19'))
                <li><a href="{{ route('admin.order.cancel.accept') }}"><i class="bx bx-right-arrow-alt"></i>Order Cancel Accept</a></li>
                @endif
                @if(userCanAccess('20'))
                <li><a href="{{ route('admin.order.cancel.completed') }}"><i class="bx bx-right-arrow-alt"></i>Cancel Completed</a></li>
                @endif
                @if(userCanAccess('21'))
                <li><a href="{{ route('admin.order.completed') }}"><i class="bx bx-right-arrow-alt"></i>Completed Order</a></li>
                @endif
                @if(userCanAccess('24'))
                <li><a href="{{ route('admin.order.outfordelivery') }}"><i class="bx bx-right-arrow-alt"></i>Out For Delivery</a></li>
                @endif
                @if(userCanAccess('26'))
                <li><a href="{{ route('admin.order.returnRequested') }}"><i class="bx bx-right-arrow-alt"></i>Return Request</a></li>
                @endif
                @if(userCanAccess('27'))
                <li><a href="{{ route('admin.order.approveReturnRequest') }}"><i class="bx bx-right-arrow-alt"></i>Approved Return Request</a></li>
                @endif
                @if(userCanAccess('28'))
                <li><a href="{{ route('admin.order.rejectReturnRequest') }}"><i class="bx bx-right-arrow-alt"></i>Rejected Return Request</a></li>
                @endif
                @if(userCanAccess('29'))
                <li><a href="{{ route('admin.order.refundCompleted') }}"><i class="bx bx-right-arrow-alt"></i>Refund Completed</a></li>
                @endif
            </ul>
        </li>
        @endif

        <!-- Stock Products -->
        @if(userCanAccess('h4'))
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="lni lni-package"></i></div>
                <div class="menu-title">Stock Products</div>
            </a>
            <ul>
                @if(userCanAccess('9'))
                <li><a href="{{ route('admin.product_stock.purchase_product') }}"><i class="bx bx-right-arrow-alt"></i>Purchase Product</a></li>
                @endif
                <li><a href="{{ route('admin.product_stock.purchase_list') }}"><i class="bx bx-right-arrow-alt"></i>Purchase List</a></li>
                <li><a href="{{ route('admin.supplier.list') }}"><i class="bx bx-right-arrow-alt"></i>Supplier List</a></li>
            </ul>
        </li>
        @endif

        <!-- Offer Settings -->
        @if(userCanAccess('h5'))
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="lni lni-offer"></i></div>
                <div class="menu-title">Offer Setting</div>
            </a>
            <ul>
                @if(userCanAccess('10'))
                <li><a href="{{ route('offer.list') }}"><i class="bx bx-right-arrow-alt"></i>Create Offer</a></li>
                @endif
            </ul>
        </li>
        @endif

        <!-- Settings -->
        @if(userCanAccess('h6'))
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="lni lni-cog"></i></div>
                <div class="menu-title">Setting</div>
            </a>
            <ul>
                @if(userCanAccess('12'))
                <li><a href="{{ route('company_info.company_info') }}"><i class="bx bx-right-arrow-alt"></i>Company Details</a></li>
                <li><a href="{{ route('setting.shipping_rate') }}"><i class="bx bx-right-arrow-alt"></i>Shipping Rate Set</a></li>
                @endif
                <li><a href="{{ route('setting.faq') }}"><i class="bx bx-right-arrow-alt"></i>FAQ Set</a></li>
                <li><a href="{{ route('ads.ads_list') }}"><i class="bx bx-right-arrow-alt"></i>Ads Set</a></li>
            </ul>
        </li>
        @endif

        <!-- Featured Link -->
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="lni lni-link"></i></div>
                <div class="menu-title">Featured Link</div>
            </a>
            <ul>
                <li><a href="{{ route('admin.featured_link.featured_link_list') }}"><i class="bx bx-right-arrow-alt"></i>Featured Link List</a></li>
            </ul>
        </li>

        <!-- Bank -->
        @if(userCanAccess('h7'))
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="lni lni-home"></i></div>
                <div class="menu-title">Bank</div>
            </a>
            <ul>
                <li><a href="{{ route('admin.bank.list') }}"><i class="bx bx-right-arrow-alt"></i>Bank List</a></li>
            </ul>
        </li>
        @endif

        <!-- Reports -->
        @if(userCanAccess('h9'))
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="lni lni-stats-up"></i></div>
                <div class="menu-title">Report</div>
            </a>
            <ul>
                @if(userCanAccess('23'))
                <li><a href="{{ route('admin.report.sell.profit') }}"><i class="bx bx-right-arrow-alt"></i>Sell & Profit Report</a></li>
                @endif
                @if(userCanAccess('22'))
                <li><a href="{{ route('admin.report.sell') }}"><i class="bx bx-right-arrow-alt"></i>Best Sell Product Report</a></li>
                @endif
            </ul>
        </li>
        @endif
    </ul>
    <!-- End Navigation -->
</div>
<!-- End Sidebar Wrapper -->