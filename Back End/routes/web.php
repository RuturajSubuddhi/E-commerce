<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BankAccountController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CompanyInfoController;
use App\Http\Controllers\Admin\FeaturedLinkController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\OfferController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PosController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductSubcategoryController;
use App\Http\Controllers\Admin\PurchaseController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SubcategoryController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\StripePaymentController;
use App\Http\Controllers\CartController; // ✅ Missing semicolon fixed
use App\Models\Supplier;
use App\Http\Controllers\Admin\ShippingSettingController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\AdsController;
use App\Http\Controllers\Admin\CartAdminController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [AdminController::class, 'loginView'])->name('login');
Route::post('admin/login', [AdminController::class, 'loginAdmin'])->name('admin.login');

Route::prefix('admin')->group(function () {
    // ... other admin routes
    Route::get('/my-profile', [AdminController::class, 'myProfile'])->name('admin.myprofile');
    Route::post('/my-profile/update', [AdminController::class, 'updateProfile'])->name('admin.update');

    Route::get('/change-password', [AdminController::class, 'changePasswordPage'])->name('admin.password');
    Route::post('/change-password/update', [AdminController::class, 'updatePassword'])->name('admin.password.save');

    Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');
});


Route::group(['middleware' => 'authCheck'], function () {

    // ================== DASHBOARD ==================
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('admin/role', [AdminController::class, 'adminRole'])->name('admin.role.create');
    Route::post('admin/role/store', [AdminController::class, 'adminRoleStore'])->name('admin.role.store');

    Route::get('admin/create', [AdminController::class, 'adminCreate'])->name('admin.admin.create');
    Route::post('admin/store', [AdminController::class, 'adminStore'])->name('admin.admin.store');
    Route::delete('admin/delete/{id}', [AdminController::class, 'adminDelete'])->name('admin.admin.delete');


    Route::get('/post/sell/list', [PosController::class, 'sellList'])->name('sell.list');
    Route::get('/admin/order/pending', [OrderController::class, 'pending'])->name('admin.order.pending');




    // ================== PRODUCT ==================
    Route::get('/create/product/view', [ProductController::class, 'createProduct'])->name('admin.create.product');
    Route::post('/product/store', [ProductController::class, 'storeProduct'])->name('admin.store.product');
    Route::get('/product/list', [ProductController::class, 'productList'])->name('admin.product.list');
    Route::get('/product/edit/info', [ProductController::class, 'productEditDetails'])->name('product.edit.info');
    Route::get('/product/image/delete', [ProductController::class, 'imageDelete'])->name('product.image.delete');
    Route::post('/product/update', [ProductController::class, 'productUpdate'])->name('admin.edit.product');

    Route::get('/admin/product/barcode', [ProductController::class, 'productBarcodeGenerate'])
    ->name('admin.product.barcode');

    // ================== PRODUCT COLOR ==================
    Route::get('/product/color', [ProductController::class, 'productColor'])->name('admin.product.color.show');
    Route::post('/product/color/store', [ProductController::class, 'productColorStore'])->name('admin.product.color.store');
    Route::post('/product/color/update', [ProductController::class, 'productColorUpdate'])->name('admin.product.color.update');

    // ================== PRODUCT SIZE ==================
    Route::get('/product/size', [ProductController::class, 'productSize'])->name('admin.product.size.show');
    Route::post('/product/size/store', [ProductController::class, 'productSizeStore'])->name('admin.product.size.store');
    Route::post('/product/size/update', [ProductController::class, 'productSizeUpdate'])->name('admin.product.size.update');

    // ================== CATEGORY ==================
    Route::get('/product/category', [ProductCategoryController::class, 'productCategory'])->name('admin.product.category');
    Route::post('/product/category/store', [ProductCategoryController::class, 'productCategoryStore'])->name('admin.store.category');
    Route::post('/product/category/update', [ProductCategoryController::class, 'productCategoryUpdate'])->name('admin.update.category');
    Route::get('/product/category/delete', [ProductCategoryController::class, 'productCategoryDelete'])->name('admin.delete.category');

    // ================== BRAND ==================
    Route::get('/product/brand', [BrandController::class, 'brandShow'])->name('admin.product.brand');
    Route::post('/product/brand/store', [BrandController::class, 'brandStore'])->name('admin.product.brand.store');
    Route::post('/product/brand/update', [BrandController::class, 'brandUpdate'])->name('admin.product.brand.update');

    // ================== SUBCATEGORY ==================
    Route::get('/product/subcategory', [ProductSubcategoryController::class, 'productSubcategory'])->name('admin.product.subcategory');
    Route::post('/product/subcategory/store', [ProductSubcategoryController::class, 'productSubCategoryStore'])->name('admin.store.subcategory');
    Route::post('/product/subcategory/update', [ProductSubcategoryController::class, 'productSubCategoryUpdate'])->name('admin.update.subcategory');
    Route::get('/product/subcategory/delete', [ProductSubcategoryController::class, 'productSubCategoryDelete'])->name('admin.delete.subcategory');
    Route::get('/product/subcategory/list/get', [ProductSubcategoryController::class, 'subcategoryListGet'])->name('subcategory.list.get');

    // ================== SUPPLIER ==================
    Route::get('/supplier/list', [SupplierController::class, 'supplierList'])->name('admin.supplier.list');
    Route::post('/supplier/store', [SupplierController::class, 'supplierStore'])->name('admin.store.supplier');
    Route::get('/supplier/edit/info', [SupplierController::class, 'supplierEditInfo'])->name('supplier.edit.info');
    Route::post('/supplier/update', [SupplierController::class, 'supplierUpdate'])->name('admin.update.supplier');

    // ================== BANK ==================
    Route::get('/bank/list', [BankAccountController::class, 'bankList'])->name('admin.bank.list');
    Route::post('/bank/store', [BankAccountController::class, 'bankStore'])->name('admin.store.bank');
    Route::post('/bank/update', [BankAccountController::class, 'bankUpdate'])->name('admin.update.bank');

    // ================== POS ==================
    Route::get('/pos/customer', [PosController::class, 'posCustomerList'])->name('admin.pos.customer.list');
    Route::post('/pos/customer/store', [PosController::class, 'posCustomerStore'])->name('admin.store.pos.customer');
    Route::get('/pos/customer/store/in-pos', [PosController::class, 'posCustomerStoreInPos'])->name('admin.pos.customer.add.in-pos');
    Route::post('/pos/customer/update', [PosController::class, 'posCustomerUpdate'])->name('admin.pos.customer.update');
    Route::get('/pos/view', [PosController::class, 'posView'])->name('admin.pos.view');
    Route::get('/pos/product/get', [PosController::class, 'getPostProductList'])->name('admin.pos.product.get');
    Route::get('/pos/product/src/get', [PosController::class, 'postProductSearch'])->name('admin.pos.product.src');
    Route::get('/pos/sell/item/get', [PosController::class, 'sellItemGet'])->name('admin.pos.sell.item.get');
    Route::post('/pos/payment/store', [PosController::class, 'posPaymentStore'])->name('pos.payment.store');

    // ================== ADMIN CUSTOMERS ==================
    Route::prefix('admin')->group(function () {
        Route::get('/customers', [UserController::class, 'adminUserList'])->name('admin.customer.list');
        Route::get('/customer/view/{id}', [UserController::class, 'view'])->name('admin.customer.view');
        Route::delete('/customer/delete/{id}', [UserController::class, 'destroy'])->name('admin.customer.delete');
        Route::post('/customer/store', [UserController::class, 'store'])->name('admin.customer.store');
    });

    // ================== CART ==================
    Route::middleware('auth')->group(function () {
        Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
        Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.view');
    });

    // Route::prefix('admin/order')->group(function () {
    //     // Route::get('/pending', [OrderController::class, 'orderPending'])->name('admin.order.pending');
    //     Route::get('/admin/order/pending', [OrderController::class, 'orderPending'])->name('admin.order.pending');

    //     Route::get('/processing', [OrderController::class, 'processing'])->name('admin.order.processing');
    //     Route::get('/approved', [OrderController::class, 'approved'])->name('admin.order.approved');
    //     Route::get('/completed', [OrderController::class, 'completed'])->name('admin.order.completed');
    // });

    // Route::prefix('admin/order')->group(function () {
    //     Route::get('/pending', [OrderController::class, 'pending'])->name('admin.order.pending');
    //     Route::get('/processing', [OrderController::class, 'processing'])->name('admin.order.processing');
    //     Route::get('/on-the-way', [OrderController::class, 'onTheWay'])->name('admin.order.on-the-way'); // 👈 add this
    //     Route::get('/approved', [OrderController::class, 'approved'])->name('admin.order.approved');
    //     Route::get('/completed', [OrderController::class, 'completed'])->name('admin.order.completed');
    // });

    Route::prefix('admin/order')->group(function () {
        Route::get('/pending', [OrderController::class, 'orderPending'])->name('admin.order.pending');
        Route::get('/processing', [OrderController::class, 'orderProcessing'])->name('admin.order.processing');
        Route::get('/on-the-way', [OrderController::class, 'orderOnTheWay'])->name('admin.order.on-the-way');
        Route::get('/cancel-request', [OrderController::class, 'orderCancelRequest'])->name('admin.order.cancel.request'); // 👈 add this
        Route::get('/cancel-accept', [OrderController::class, 'orderCancelAccept'])->name('admin.order.cancel.accept');
        Route::get('/cancel-completed', [OrderController::class, 'orderCancelCompleted'])->name('admin.order.cancel.completed');
        Route::get('/completed', [OrderController::class, 'OrderComplete'])->name('admin.order.completed');
        Route::post('/status/update', [OrderController::class, 'orderStatusUpdate'])
            ->name('admin.order.status.update');
        Route::get('/details', [OrderController::class, 'sellOrderDetails'])
            ->name('admin.order.details');
        Route::post('/update-note', [OrderController::class, 'updateOrderNote'])->name('admin.order.update.note');
        Route::get('/out-for-delivery', [OrderController::class, 'OrderOutForDelivery'])->name('admin.order.outfordelivery');
        Route::get('/return-request-orders', [OrderController::class, 'OrderReturnRequest'])->name('admin.order.returnRequested');

        Route::get('/return-order-accepted', [OrderController::class, 'OrderReturnAccepted'])->name('admin.order.approveReturnRequest');

        Route::get('/return-order-rejected', [OrderController::class, 'OrderReturnRejected'])->name('admin.order.rejectReturnRequest');

        Route::get('/order-refund-completed', [OrderController::class, 'OrderRefundCompleted'])->name('admin.order.refundCompleted');
    });

    Route::prefix('admin/product')->group(function () {
        // Purchase product form
        Route::get('/purchase', [PurchaseController::class, 'purchaseProductView'])->name('admin.product_stock.purchase_product');

        // Purchase list page
        Route::get('/purchase/list', [PurchaseController::class, 'purchaseList'])->name('admin.product_stock.purchase_list');
        Route::post('/payment/store', [PurchaseController::class, 'purchasePaymentStore'])
            ->name('admin.product_stock.payment.store');

        Route::post('/supplier/store-from-purchase', [SupplierController::class, 'purchaseSupplierStore'])
            ->name('admin.supplier.store.form.purchase');
    });

    Route::prefix('admin/pos')->group(function () {
        Route::get('/purchase/item/get', [PurchaseController::class, 'getPurchaseItem'])
            ->name('admin.pos.purchase.item.get');
    });

    Route::prefix('admin')->group(function () {
        Route::get('/offer/list', [OfferController::class, 'offerList'])->name('offer.list');
        Route::post('/store/offer', [OfferController::class, 'storeOffer'])->name('admin.store.offer');
        Route::post('/update/offer', [OfferController::class, 'offerBannerUpdate'])->name('admin.update.offer');
        Route::get('/delete/offer/banner', [OfferController::class, 'offerBannerDelete'])->name('admin.delete.offer.banner');
        Route::get('/offer/product/list/{id}', [OfferController::class, 'offerProductList'])->name('admin.offer.product.list');
        Route::post('/offer/product/store', [OfferController::class, 'storeOfferProduct'])->name('admin.offer.product.store');
        Route::get('/offer/product/delete', [OfferController::class, 'offerProductDelete'])->name('admin.offer.product.delete');
        Route::get('/offer/product/delete', [OfferController::class, 'offerProductDelete'])->name('admin.product.offerProduct.delete');
    });

    Route::prefix('admin')->group(function () {
        Route::get('/setting/company-details', [SettingController::class, 'companyDetails'])->name('company_info.company_info');
        Route::post('/setting/company-details/update', [SettingController::class, 'updateCompanyDetails'])->name('company_info.update');
    });

    Route::prefix('admin')->group(function () {
        Route::get('/setting/shipping-rate', [ShippingSettingController::class, 'index'])->name('setting.shipping_rate');
        Route::post('/setting/shipping-rate/update', [ShippingSettingController::class, 'updateShipping'])->name('setting.shipping_rate.update');
        Route::post('/setting/currency/update', [ShippingSettingController::class, 'updateCurrency'])->name('currency.setting.store');

        // AJAX route
        Route::get('/district/list/get', [ShippingSettingController::class, 'getDistrictList']);
    });

    Route::prefix('admin')->group(function () {
        Route::get('/faq', [FaqController::class, 'index'])->name('setting.faq');
        Route::get('/faq/create', [FaqController::class, 'create'])->name('setting.create');
        Route::post('/faq/store', [FaqController::class, 'store'])->name('setting.store');
        Route::get('/faq/edit/{id}', [FaqController::class, 'edit'])->name('setting.edit');
        Route::post('/faq/update/{id}', [FaqController::class, 'update'])->name('setting.update');
        Route::delete('/faq/delete/{id}', [FaqController::class, 'destroy'])->name('setting.delete');
    });

    Route::prefix('admin')->group(function () {
        Route::get('/ads', [AdsController::class, 'index'])->name('ads.ads_list');
        Route::get('/ads/create', [AdsController::class, 'create'])->name('ads.create');
        Route::post('/ads/store', [AdsController::class, 'store'])->name('ads.store');
        Route::get('/ads/edit/{id}', [AdsController::class, 'edit'])->name('ads.edit');
        Route::post('/ads/update/{id}', [AdsController::class, 'update'])->name('ads.update');
        Route::delete('/ads/delete/{id}', [AdsController::class, 'destroy'])->name('ads.delete');
    });


    // Route::prefix('admin')->group(function () {
    //     Route::get('/featured-links', [FeaturedLinkController::class, 'index'])->name('admin.featured.link.list');
    //     Route::get('/featured-links/create', [FeaturedLinkController::class, 'create'])->name('admin.featured.link.create');
    //     Route::post('/featured-links/store', [FeaturedLinkController::class, 'store'])->name('admin.featured.link.store');
    //     Route::get('/featured-links/edit/{id}', [FeaturedLinkController::class, 'edit'])->name('admin.featured.link.edit');
    //     Route::post('/featured-links/update/{id}', [FeaturedLinkController::class, 'update'])->name('admin.featured.link.update');
    //     Route::delete('/featured-links/delete/{id}', [FeaturedLinkController::class, 'destroy'])->name('admin.featured.link.delete');
    // });

    Route::prefix('admin')->group(function () {
        Route::get('/featured-links', [FeaturedLinkController::class, 'featuredLinkList'])
            ->name('admin.featured_link.featured_link_list');

        Route::get('/featured-links/create', [FeaturedLinkController::class, 'featuredLinkCreate'])
            ->name('admin.featured_link.create');

        Route::post('/featured-links/store', [FeaturedLinkController::class, 'featuredLinkStore'])
            ->name('admin.featured_link.store');

        Route::get('/featured-links/edit/{id}', [FeaturedLinkController::class, 'featuredLinkEdit'])
            ->name('admin.featured_link.edit');

        Route::post('/featured-links/update/{id}', [FeaturedLinkController::class, 'featuredLinkUpdate'])
            ->name('admin.featured_link.update');

        Route::delete('/featured-links/delete/{id}', [FeaturedLinkController::class, 'featuredLinkDelete'])
            ->name('admin.featured_link.delete');
    });


    // Route::prefix('admin')->group(function () {
    //     Route::get('/report/sell-profit', [ReportController::class, 'sellProfit'])->name('admin.report.sell.profit');
    // });

    Route::prefix('admin')->group(function () {
        // Existing profit route
        Route::get('/report/sell-profit', [ReportController::class, 'sellProfitReport'])->name('admin.report.sell.profit');

        // ➕ Add this one for normal sales report
        Route::get('/report/sell', [ReportController::class, 'sellReport'])->name('admin.report.sell');
    });

    Route::middleware('auth')->group(function () {
        Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
        Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.view');
        Route::delete('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
    });

    Route::prefix('admin')->middleware(['auth', 'isAdmin'])->group(function () {
        Route::get('/cart/list', [CartAdminController::class, 'index'])->name('admin.cart.list');
    });

    Route::get('/category-product', [ProductController::class, 'categoryProduct']);
    Route::get('/subcategory-product', [ProductController::class, 'subCategoryProduct']);
    Route::get('/trending-products', [ProductController::class, 'homeTrendingProduct']);
    Route::get('/popular-products', [ProductController::class, 'homePopularProduct']);
    Route::get('/new-arrivals', [ProductController::class, 'newArrivalProduct']);
    Route::get('/best-sellers', [ProductController::class, 'bestSellProduct']);
    Route::get('/product/{id}', [ProductController::class, 'productDetails']);
});
