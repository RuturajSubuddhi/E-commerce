<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CartController as ApiCartController;
use App\Http\Controllers\Api\CashOnDeliveryController;
use App\Http\Controllers\Api\CompanyInfoController;
use App\Http\Controllers\Api\OfferController;
use App\Http\Controllers\Api\PopularProductController;
use App\Http\Controllers\Api\ProductCategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProductSubcategoryController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\StorageController;
use App\Http\Controllers\api\StripePaymentController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\UserOrderController;
use App\Http\Controllers\Api\WishListController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\ProductReviewController;
// use App\Http\Controllers\Api\CartController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post("/logout", [AuthController::class, 'logout']);
    Route::post('user/shipping/billing/address', [UserController::class, 'userAddress']);
    Route::get('user/shipping/billing/address/get', [UserController::class, 'userAddressGet']);

    Route::post('stripe/payment', [StripePaymentController::class, 'stripePayment']);
    Route::post('cashOnDelivery/payment', [CashOnDeliveryController::class, 'cashOnDeliveryOrder']);

    // Route::get('user/order/list', [UserOrderController::class, 'orderList']);
    // Route::get('user/order/details/by/orderId', [UserOrderController::class, 'orderDetails']);

    // Order List
    Route::get('user/order/list', [UserOrderController::class, 'orderList']);

    // Order Details
    Route::get('user/order/details/by/orderId', [UserOrderController::class, 'orderDetails']);

    // Cancel Order
    // Route::post('/order/cancel-request', [UserOrderController::class, 'cancel']);
    // PLACE ORDER
    Route::post('/place-order', [UserOrderController::class, 'placeOrder']);
    Route::post('/order/return-request', [UserOrderController::class, 'returnRequest']);
    Route::post('/order/cancel-request', [UserOrderController::class, 'cancel']);
    Route::post('/apply-promo', [UserOrderController::class, 'applyPromo']);
    Route::get(
        '/order/invoice/{orderId}',
        [UserOrderController::class, 'downloadInvoice']
    );


    Route::post('user/changePassword', [AuthController::class, 'changePassword']);

    Route::post('user/update-profile', [AuthController::class, 'updateProfile']);
    Route::get('user/profile', [AuthController::class, 'user']);

    Route::post('user/savedAddress', [AuthController::class, 'saveAddress']);
    Route::get('user/address/get', [AuthController::class, 'getAddresses']); // return all addresses
    Route::put('user/address/update/{id}', [AuthController::class, 'updateAddress']);
    Route::delete('user/address/delete/{id}', [AuthController::class, 'deleteAddress']);
    Route::put('user/address/set-default/{id}', [AuthController::class, 'setDefaultAddress']);

    Route::post('/rating-review/add', [ProductReviewController::class, 'addRatingReview']);

    // ⭐ Reviews
    Route::get('/product/{id}/reviews', [ProductReviewController::class, 'productReviews']);
    Route::get('/my/reviews', [ProductReviewController::class, 'myReviews']);

    // ⭐ Track Order
    Route::get('/order/track/{order_id}', [UserOrderController::class, 'trackOrder']);


    // Route::post('user/wish/list/add', [WishListController::class, 'addWishList']);
    // Route::get('user/wish/get', [WishListController::class, 'getWishList']);
    // Route::get('user/wish/count', [WishListController::class, 'count']);
    // Route::get('user/order/cancel', [UserOrderController::class, 'cancel']);
});
Route::post('user/forgetpassword', [AuthController::class, 'forgetPassword']);
Route::post('user/verify-otp', [AuthController::class, 'verifyOtp']);
Route::post('user/reset-password', [AuthController::class, 'resetPassword']);


Route::post("/signup", [AuthController::class, 'signup']);
Route::post("/login", [AuthController::class, 'login']);

Route::get('home/popular/product/get', [ProductController::class, 'homePopularProduct']);
Route::get('home/trending/product/get', [ProductController::class, 'homeTrendingProduct']);
Route::get('home/category/product', [ProductController::class, 'categoryProduct']);

Route::get('home/subcategory/product', [ProductController::class, 'subCategoryProduct']);
Route::get('home/subcategory/product/related', [ProductController::class, 'relatedProductGet']);

Route::get('home/new/arrival/product', [ProductController::class, 'newArrivalProduct']);
Route::get('home/best/sell/product', [ProductController::class, 'bestSellProduct']);
Route::get('product/details', [ProductController::class, 'productDetails']);
Route::get('search/product', [ProductController::class, 'srcProductList']);
Route::get('offer/banner', [OfferController::class, 'offerBanner']);
Route::get('offer/product/list', [OfferController::class, 'offerProduct']);
Route::get('product/category', [ProductCategoryController::class, 'categoryList']);
Route::get('product/popular/category', [ProductCategoryController::class, 'popularCategory']);


Route::get('category/wise/subcategory', [ProductSubcategoryController::class, 'categoryWiseSubcategory']);
Route::get('section/product', [ProductController::class, 'sectionProductList']);
Route::get('all/subcategory', [ProductSubcategoryController::class, 'allSubcategory']);
Route::get('all/category/subcategory', [ProductCategoryController::class, 'allCategorySubcategory']);
Route::post('product/price/range/src', [ProductController::class, 'priceRangeSrc']);

Route::get('country/list', [StorageController::class, 'countryList']);
Route::get('shipping/cost/get', [SettingController::class, 'shippingCost']);
Route::get('currency/get', [SettingController::class, 'currency']);
Route::get('division/list', [StorageController::class, 'divisionList']);
Route::get('district/list', [StorageController::class, 'districtList']);
Route::get('product/size/list', [ProductController::class, 'productSizList']);
Route::get('product/color/list', [ProductController::class, 'productColorList']);
Route::get('product/company/info', [CompanyInfoController::class, 'getCompanyInfo']);
Route::get('product/price/min/max', [ProductController::class, 'minMaxPrice']);

Route::get('product/all/color', [ProductController::class, 'allColor']);
Route::get('product/all/size', [ProductController::class, 'allSize']);
Route::get('product/all/brand', [BrandController::class, 'allBrand']);
Route::get('product/top/brand', [BrandController::class, 'topBrand']);

Route::get('product/all/category', [ProductCategoryController::class, 'allCategory']);
Route::get('featured/link/list', [SettingController::class, 'featuredList']);

Route::get('faq/list', [SettingController::class, 'getFaq']);
Route::get('ads/list', [SettingController::class, 'getAds']);
// Route::middleware('auth:sanctum')->get('/admin/users', [UserController::class, 'getAllUsers']);
// Route::get('/users', [UserController::class, 'getAllUsers']);
// Route::middleware('auth:sanctum')->get('/admin/users', [App\Http\Controllers\Api\UserController::class, 'getAllUsers']);
Route::get('/admin/users', [App\Http\Controllers\Api\UserController::class, 'getAllUsers']);



Route::get('/products', [ProductApiController::class, 'index']);
Route::get('/products/category/{categoryId}', [ProductApiController::class, 'getByCategory']);
Route::get('/products/subcategory/{subcategoryId}', [ProductApiController::class, 'getBySubcategory']);
// routes/api.php
Route::get('/categories/{categoryId}/subcategories', [ProductApiController::class, 'getSubcategoriesByCategory']);
Route::get('/product/{id}', [ProductApiController::class, 'getProductDetails']);

Route::get('products/latest', [ProductApiController::class, 'latestProducts']);

Route::post('/cart/add', [ApiCartController::class, 'addToCart']);
Route::post('/cart/list', [ApiCartController::class, 'viewCart']);
Route::post('/cart/update', [ApiCartController::class, 'updateQty']);
Route::post('/cart/remove', [ApiCartController::class, 'removeFromCart']);
Route::post('/cart/clear', [ApiCartController::class, 'clearCart']);
// WISHLIST ROUTES
Route::post('/wishlist/add', [WishListController::class, 'addWishList']);
Route::post('/wishlist/list', [WishListController::class, 'getWishList']);
Route::post('/wishlist/count', [WishListController::class, 'count']);
Route::post('/wishlist/remove', [WishListController::class, 'removeWishList']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user/orders', [UserOrderController::class, 'myOrders']);
});
Route::middleware('auth:sanctum')->group(function () {
    Route::get(
        'user/orders/{orderId}/invoice',
        [UserOrderController::class, 'downloadInvoice']
    );
});
Route::get('/products/search', [ProductController::class, 'search']);

