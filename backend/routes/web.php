<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'FrontendController@homePage')->name('/');
Route::post('/checkEmailExist','FrontendController@checkEmailExist')->name('check-email-exist');
Route::post('/checkMobileExist','FrontendController@checkMobileExist')->name('check-mobile-exist');
Route::get('/privacy','FrontendController@privacy')->name('privacy');
Route::post('/profile-update','FrontendController@updateProfile')->name('profile-update');
Route::get('/profile-edit', 'FrontendController@editProfile')->name('profile-edit');
Route::get('/change-password-form','FrontendController@changePasswordForm')->name('change-password-form');
Route::post('/change-password','FrontendController@changePassword')->name('change-password');
Auth::routes(['verify' => true]);
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/auth/social', 'Auth\LoginController@show')->name('social.login');
Route::get('/oauth/{driver}', 'Auth\LoginController@redirectToProvider')->name('social.oauth');
Route::get('/oauth/{driver}/callback', 'Auth\LoginController@handleProviderCallback')->name('social.callback');

Route::any('test','FrontendController@test'); 
 
Route::get('/getStates/{id}','FrontendController@getStates')->name('regiter-getStates');
Route::get('/getCities/{id}','FrontendController@getCities');
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout')->name('logoutall');


/*******************Admin******************************/ 

    Route::group(['prefix' => 'admin','middleware' => ['auth','admin']], function() {
    Route::get('/dashboard', 'AdminController@dashboard')->name('admin-dashboard');    
    Route::get('/users-list', 'AdminController@usersList')->name('admin-users-list');     
    Route::get('/mailsend', 'AdminController@sendMail2')->name('admin-mailsend');
    Route::post('/edit-user', 'AdminController@editUser')->name('admin-edit-user');
    Route::post('/add-user', 'AdminController@addUser')->name('admin-add-user');
    Route::get('/user-form', 'AdminController@userForm')->name('admin-user-form');
    Route::post('/delete-user', 'AdminController@deleteUser')->name('admin-delete-user');
    Route::post('/change-user-status', 'AdminController@changeUserStatus')->name('admin-change-user-status');
    Route::get('/search-order','AdminController@searchOrder')->name('admin-search-order');
    Route::get('/searchOrderRepresent','AdminController@searchOrderRepresent');
    Route::get('/orderRepresent','AdminController@orderRepresent');
    Route::get('/send-order-id', 'AdminController@submittedOrderDetail')->name('admin-send-order-id');
    Route::get('/order-represent-submitted', 'AdminController@submittedWorkManagement');
    Route::get('/submitted-work','AdminController@submittedOrderDetail')->name('admin-submitted-work-management');
    /*******orders*******/    
    Route::get('/order-management','AdminController@orderManagement')->name('admin-order-management');
    Route::get('/order-detail/{id}','AdminController@orderDetail')->name('admin-order-detail');
    Route::post('/reject-order', 'AdminController@rejectOrder')->name('admin-reject-order');
    Route::post('/reject-submitted-work', 'AdminController@rejectSubmittedWork')->name('admin-reject-submitted-work');
    Route::post('/accept-digitizer', 'AdminController@acceptWorkFromManager')->name('admin-accept-submitted-work');    
    Route::post('/update-order', 'AdminController@updateOrder')->name('admin-update-order');
    Route::post('/cancel-order','AdminController@cancelOrder')->name('admin-cancel-order');
    Route::post('/order-image','AdminController@orderImage')->name('admin-order-image');
    Route::get('/downlaod-image/{feature_image}','AdminController@downloadImage')->name('admin-download-image');
    Route::post('approve-order','AdminController@approveOrder')->name('admin-approve-order');
    Route::post('/reassign-digitizer','AdminController@reassignDigitizer')->name('admin-reassign-digitizer');
    Route::post('/delete-order-image','AdminController@deleteOrderImage')->name('admin-delete-order-image');

     /*******cms*******/
   
   Route::get('/cms/blog-management','AdminController@blogList')->name('admin-blog-list');
   Route::get('/cms//blog-management/blog-form/','AdminController@addBlogForm')->name('admin-blog-form');

   Route::get('/cms/service/categories','AdminController@servicesList')->name('admin-service-list');
   Route::get('/cms/service/form/','AdminController@addServiceForm')->name('admin-service-form');
   Route::get('/edit-service/{id}', 'AdminController@addServiceForm')->name('admin-edit-service');
   Route::post('/delete-service', 'AdminController@deleteServices')->name('admin-delete-service');
   Route::post('/admin-add-service', 'AdminController@addUpdateService')->name('admin-add-update-service');

   Route::get('/cms/categories-management','AdminController@categoriesManagement')->name('admin-categories-management');
   Route::post('/cms/admin-blog-category','AdminController@addBlogCategory')->name('admin-add-blog-category');
   Route::post('/admin-add-blog', 'AdminController@addUpdateBlog')->name('admin-add-update-blog');
   Route::get('/edit-blog/{id}', 'AdminController@addBlogForm')->name('admin-edit-blog');

    Route::post('ckeditor/upload', 'AdminController@ckeditorUpload')->name('ckeditor.upload');
   /*home page*/
   Route::get('/edit-home-page/{id}','AdminController@editHomePage')->name('admin-edit-home-page');
   Route::post('/update-home-page/{id}','AdminController@updateHomePage')->name('admin-update-home-page');
   Route::post('/upload-editor-image','AdminController@saveEditorImage')->name('admin-upload-editor-image');
   Route::post('/upload-home-image','AdminController@saveHomePageEditer')->name('admin-upload-home-image');
   //Contact page
   Route::get('/contact-us/{id}','AdminController@contactUsPage')->name('admin-contact-us');
   Route::post('/update-contact-page/{id}','AdminController@updateContactUsPage')->name('admin-update-contact-page');
   //About Us
   Route::get('/about-us/{id}','AdminController@aboutUsPage')->name('admin-about-us');
   Route::post('/update-about-page/{id}','AdminController@updateAboutUsPage')->name('admin-update-about-page');
   //Privacy policy
   Route::get('/privacy-policy/{id}','AdminController@privacyPolicyPage')->name('admin-privacy-policy');
   Route::post('/update-privacy-policy-page/{id}','AdminController@updatePrivacyPolicyPage')->name('admin-update-privacy-policy-page');
   //Return policy
   Route::get('/return-policy/{id}','AdminController@returnPolicyPage')->name('admin-return-policy');
   Route::post('/update-return-policy-page/{id}','AdminController@updateReturnPolicyPage')->name('admin-update-return-policy-page');
   //Term and Condition
   Route::get('/term-and-condtion/{id}','AdminController@termConditionPage')->name('admin-term-and-condtion');
   Route::post('/update-term-and-condtion-page/{id}','AdminController@updateTermCondition')->name('admin-update-term-and-condtion-page');
   //Blog listing
   Route::get('/general-setting/{id}','AdminController@generalSetting')->name('admin-general-setting');
   Route::post('/update-general-setting-page/{id}','AdminController@updateGeneralSetting')->name('admin-update-general-setting-page');
  
   // Route::post('/update-cms-pages', 'AdminController@updateCmsPages')->name('admin-update-cms-pages');
   Route::get('/get-blog-category-list', 'AdminController@blogCategoryList')->name('admin-blog-categories-list');
   Route::post('/delete-blog-category', 'AdminController@deleteBlogCategory')->name('admin-delete-blog-category');
   Route::post('/cat-slug-checking', 'AdminController@checkSlug')->name('admin-cat-slug-checking');
   Route::post('/delete-blog', 'AdminController@deleteBlog')->name('admin-delete-blog');

    //=========Reports===========
    Route::get('/customer-reports', 'AdminController@customerReports')->name('customer-reports');
    Route::get('/sales-reports', 'AdminController@salesReports')->name('sales-reports');

    //coupons List
    Route::get('/coupons-list','AdminController@couponsList')->name('admin-coupons-list');
    Route::post('/create-coupon','AdminController@createCoupon')->name('admin-create-coupon');
    Route::get('/coupon-form','AdminController@couponForm')->name('admin-coupon-form');
    Route::post('/edit-coupon-form','AdminController@editCouponForm')->name('admin-edit-coupon-form');
    Route::get('/send-data-to-coupon-form/{id}','AdminController@sendDataToCouponForm')->name('admin-send-data-to-coupon-form');
    Route::post('/delete-coupon','AdminController@deleteCoupon')->name('admin-delete-coupon');
    Route::post('/publish-coupon','AdminController@publishCoupon')->name('admin-publish-coupon');
    Route::post('/manage-price-form','AdminController@managePriceForm')->name('admin-manage-price-form');
    Route::get('/manage-price','AdminController@managePrice')->name('admin-manage-price');


});
 
 /*******************Digitizer******************************/

Route::group(['prefix' => 'digitizer','middleware' => ['auth','digitizer']], function() {
    Route::get('/dashboard', 'DigitizerController@dashboard')->name('digitizer-dashboard');
    Route::get('/search-order','DigitizerController@searchOrder')->name('digitizer-search-order');
    Route::get('/searchOrderRepresent','DigitizerController@searchOrderRepresent');
    Route::get('/order-management','DigitizerController@orderManagement')->name('digitizer-order-management');
    Route::get('/order-detail/{id}','DigitizerController@orderDetail')->name('digitizer-order-detail');
    Route::get('/order-history','DigitizerController@orderHistory')->name('digitizer-order-history');
    Route::post('/submitted-work','DigitizerController@submittedWork')->name('digitizer-submitted-work');
    Route::get('/orderRepresent','DigitizerController@orderRepresent');
    Route::get('/send-order-id', 'DigitizerController@submittedOrderDetail')->name('digitizer-send-order-id');
    Route::get('/downlaod-image/{feature_image}','DigitizerController@downloadImage')->name('digitizer-download-image');
    Route::get('/order-history-management', 'DigitizerController@orderHistory');
});

/*******************Digitizer Manager******************************/

Route::group(['prefix' => 'digitizer-manager','middleware' => ['auth','digitizer-manager']], function() {
    Route::get('/dashboard', 'DigitizerManagerController@dashboard')->name('digitizer-manager-dashboard');
    Route::get('/order-management','DigitizerManagerController@orderManagement')->name('digitizer-manager-order-management');
    Route::get('/search-order','DigitizerManagerController@searchOrder')->name('digitizer-manager-search-order');
    Route::get('/searchOrderRepresent','DigitizerManagerController@searchOrderRepresent');
    Route::get('/order-detail/{id}','DigitizerManagerController@orderDetail')->name('digitizer-manager-order-detail');
    Route::post('/reject-order', 'DigitizerManagerController@rejectOrder')->name('digitizer-manager-reject-order');

    Route::post('/reject-submitted-work', 'DigitizerManagerController@rejectSubmittedWork')->name('digitizer-manager-reject-submitted-work');
    Route::get('/orderRepresent','DigitizerManagerController@orderRepresent');

    Route::post('/accept-digitizer', 'DigitizerManagerController@acceptWorkFromManager')->name('digitizer-manager-accept-submitted-work');
    Route::get('/send-order-id', 'DigitizerManagerController@submittedOrderDetail')->name('digitizer-manager-send-order-id');
    Route::get('/order-represent-submitted', 'DigitizerManagerController@submittedWorkManagement');
    
    Route::post('/update-order', 'DigitizerManagerController@updateOrder')->name('digitizer-manager-update-order');
    Route::post('/cancel-order','DigitizerManagerController@cancelOrder')->name('digitizer-manager-cancel-order');
    Route::post('/order-image','DigitizerManagerController@orderImage')->name('digitizer-manager-order-image');
    Route::get('/downlaod-image/{feature_image}','DigitizerManagerController@downloadImage')->name('digitizer-manager-download-image');
    Route::post('approve-order','DigitizerManagerController@approveOrder')->name('digitizer-manager-approve-order');
    Route::get('/submitted-work','DigitizerManagerController@submittedOrderDetail')->name('digitizer-manager-submitted-work-management');
    Route::get('/completed-work','DigitizerManagerController@completedOrderDetail')->name('digitizer-manager-completed-work-management');
     Route::get('/order-represent-completed', 'DigitizerManagerController@completedWorkManagement');

     Route::get('/inprogress-orderRepresent','DigitizerManagerController@OrderRepresentInProgress');
     Route::get('/inprogress','DigitizerManagerController@InProgressOrderManagement')->name('digitizer-manager-order-management-inprogress');

     Route::get('/rejected-orderRepresent','DigitizerManagerController@OrderRepresentRejected');
     Route::get('/rejected','DigitizerManagerController@rejectedOrderManagement')->name('digitizer-manager-order-management-rejected');

      Route::get('/canceled-orderRepresent','DigitizerManagerController@OrderRepresentCanceled');

      Route::get('/canceled','DigitizerManagerController@canceledOrderManagement')->name('digitizer-manager-order-management-canceled');

      Route::get('/reworking-orderRepresent','DigitizerManagerController@OrderRepresentReworking');
      
      Route::get('/reworking','DigitizerManagerController@reworkingOrderManagement')->name('digitizer-manager-order-management-reworking');

      Route::post('/reassign-digitizer','DigitizerManagerController@reassignDigitizer')->name('digitizer-manager-reassign-digitizer');
});

/*******************Embroiderer******************************/

     Route::group(['prefix' => 'embroiderer','middleware' => ['verified','auth','embroiderer']], function() {
     Route::get('/test','EmbroidererController@test');
     Route::get('/orderRepresent','EmbroidererController@orderRepresent');
     Route::get('/createNew','EmbroidererController@createNew');

     Route::get('/confirmation/{id}','EmbroidererController@confirmationPage');

     Route::get('/search-order','EmbroidererController@searchOrder')->name('embroiderer-search-order');
     Route::get('/searchOrderRepresent','EmbroidererController@searchOrderRepresent');
    
     Route::post('/create-order-paypal','EmbroidererController@createOrderPaypal')->name('embroiderer-create-order-paypal');
     Route::get('/authorize-order','EmbroidererController@authorizeOrder')->name('embroiderer-authorize-order');
     Route::get('/capture-authrize-request','EmbroidererController@captureAuthrizeRequest')->name('embroiderer-capture-authrize-request');
     Route::get('/reauthrize-request/{authorization_id}','EmbroidererController@reauthrizeRequest')->name('embroiderer-reauthrize-request');
     Route::get('/return-authorize-payment/{authorization_id}','EmbroidererController@returnAuthorizePayment')->name('embroiderer-return-authorize-payment');

    Route::post('/update-cart-order', 'EmbroidererController@updateCartOrder')->name('embroiderer-update-cart-order'); 
    Route::post('/get-cart-order', 'EmbroidererController@getCartOrder')->name('embroiderer-get-cart-order');
    
    Route::get('/cancelingIntent','EmbroidererController@cancelingIntent');

    Route::get('/dashboard', 'EmbroidererController@dashboard')->name('embroiderer-dashboard');  
    Route::post('/create-payment-intent','EmbroidererController@createPaymentIntent')->name('embroiderer-create-charge');
     Route::post('/embroiderer-create-zero-charge','EmbroidererController@embroidererCreateZeroCharge')->name('embroiderer-create-zero-charge');
    Route::get('/cards-management','EmbroidererController@cardsManagement')->name('embroiderer-cards-management');
    Route::post('/set-default-card','EmbroidererController@setDefaultCard')->name('embroiderer-set-default-card'); 
    Route::post('/add-card','EmbroidererController@addCard')->name('embroiderer-add-card');
    Route::post('/delete-card','EmbroidererController@deleteCard')->name('embroiderer-delete-card'); 
    Route::get('/card-list','EmbroidererController@cardList')->name('embroiderer-card-list');
    Route::get('/order-management','EmbroidererController@orderManagement')->name('embroiderer-order-management');
    Route::get('/order-detail/{id}','EmbroidererController@embroidererOrderDetail')->name('embroiderer-order-detail');
    Route::get('/order-form', 'EmbroidererController@orderForm')->name('embroiderer-order-form');
    Route::post('/create-order','EmbroidererController@createOrder')->name('embroiderer-create-order');
    Route::post('/cancel-order','EmbroidererController@cancelOrder')->name('embroiderer-cancel-order');
    Route::post('/order-image','EmbroidererController@orderImage')->name('embroiderer-order-image');
    Route::get('/cart','EmbroidererController@cart')->name('embroiderer-cart');
    Route::post('/remove-item', 'EmbroidererController@removeItem')->name('embroiderer-cart-remove');
    Route::post('/place-order','EmbroidererController@placeOrder')->name('embroiderer-place-order');
    Route::get('/clear-cart', 'EmbroidererController@clearCart')->name('embroiderer-clear-cart');
    Route::get('/checkout-payment', 'EmbroidererController@checkoutPayment')->name('embroiderer-checkout-payment');

    Route::post('/check-coupon', 'EmbroidererController@checkCoupon')->name('embroiderer-check-coupon');
    Route::post('/reorder', 'EmbroidererController@reOrder')->name('embroiderer-reorder');
    Route::post('/create-reorder', 'EmbroidererController@createReOrder')->name('embroiderer-create-reorder');
    Route::get('pdf-create','PdfController@create')->name('embroiderer-pdf-create');
    Route::get('send-invoice-data','PdfController@pdfdta')->name('embroiderer-send-invoice-data');
    
    Route::get('/downlaod-image/{feature_image}','EmbroidererController@downloadImage')->name('embroiderer-download-image');
    Route::get('/send-order-id', 'EmbroidererController@completedImagesDetail')->name('embroiderer-send-order-id');
});