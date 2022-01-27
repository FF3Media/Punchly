<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Blog;
use App\CmsMeta;
use App\Cms;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();


});

Route::get('/cms/blog/','ApiController@getAllBlogs' )->name('blog');

Route::get('/cms/getBlogsByCategory/{cat_id}','ApiController@getBlogsByCategory');
Route::get('/cms/blog-single/{id}','ApiController@singleBlog');
/***Home*****/
Route::get('/cms/cms-meta/{id}', 'ApiController@allCmsPages');
/***Contact us*****/
Route::get('/cms/contact-us/{id}', 'ApiController@contactUsPAge');
Route::post('/cms/contact-mail/', 'ApiController@contactSendMail');
Route::post('/cms/newsletter/', 'ApiController@newsletterSubscription');

Route::get('/cms/services/', 'ApiController@serviceCateSlug');
Route::get('/cms/service/{id}', 'ApiController@getServiceBySlug');
Route::get('/stripe-status-update','ApiController@statusUpdateAfterSevendays')->name('stripe-status-update-seven-day');

Route::post('/login_access', 'ApiController@loginAccess')->name('login-access');
 

Route::post('/payment-invoices', 'EmbroidererController@paymentInvoices')->name('embroiderer-payment-invoices');




