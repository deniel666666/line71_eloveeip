<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
| Api here could be used by anyone, whether he/she has logined with admin/member account or not!!!
| Api here can't use session!!!
|
*/

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:api');

//-------------
//   Customer
//-------------
// member: customer
Route::post('customer/register',        'Api\Customer\MemberApiController@storeRegister');        //register
Route::post('customer/forgetPassword',  'Api\Customer\MemberApiController@forgetPassword');       //forget Password
Route::post('customer/login',           'Api\Customer\MemberApiController@accountLogin');         //do login
Route::post('customer/page/get',        'Api\Customer\MemberApiController@clientShowPage');       //get user list(client)
Route::get('customer/Info/{memberId}',  'Api\Customer\MemberApiController@clientShowMemberInfo'); //get user info by id(client)
/*customer 特有api*/
Route::post('customer/login/outside',   'Api\Customer\MemberApiController@outSideLogin');             //login and return account data(use when acrossing web)
Route::post('customer/update/by_ac_pw', 'Api\Customer\MemberApiController@updateByAccountPassword');  //update data by user account and password
Route::post('customer/rapidRegister',   'Api\Customer\MemberApiController@rapidRegister');            //rapid Register
Route::post('customer/rapidLogin',      'Api\Customer\MemberApiController@rapidLogin');               //do login

//-------------
//   Member
//-------------
Route::post('member/register',        'Api\Member\MemberApiController@storeRegister');        //register
Route::post('member/forgetPassword',  'Api\Member\MemberApiController@forgetPassword');       //forget Password
Route::post('member/login',           'Api\Member\MemberApiController@accountLogin');         // do login
Route::post('member/page/get',        'Api\Member\MemberApiController@clientShowPage');       //get user list(client)
Route::get('member/Info/{memberId}',  'Api\Member\MemberApiController@clientShowMemberInfo'); //get user info by id(client)

Route::group(['middleware' => 'cors'], function () { /* 被cor包住的api才允許跨網域請求*/
  //activate member account
  Route::get('member/activecode/{code}', 'Api\Member\MemberApiController@active');
});


//-------------
//   Client
//-------------
Route::group(['middleware' => 'cors'], function () { /* 被cor包住的api才允許跨網域請求*/
  Route::options('/{any}', function(){ return ''; })->where('any', '.*');

  //lang
  Route::get('/lang', 'Api\LangApiController@index'); //List

  Route::get('/lind_card/{rand}', 'Client\LinecardController@get_line_card'); //List

  //development
  Route::get('development/team/show','Api\SystemApiController@devTeamShow'); // get devTeam data

  //miscellaneous
  Route::post('miscellaneous', 'Api\MiscellaneousApiController@show');

  //gallery
  Route::post('gallery/showClient/{galleryTypeId}',	'Api\Gallery\GalleryApiController@showClient');//show gallery List

  //cms
  Route::get('cms/{cmsTypeId}/',      'Api\Cms\CmsApiController@clientShowCmsByTypeId');  //Show CMS By CmsType
  Route::get('cms/{cmsTypeId}/view',  'Api\Cms\CmsApiController@clientGetView');			    //Get CMS Rendered Html By CmsType
    
  //contact: contact
  Route::post('contact',                            'Api\Contact\ContactApiController@addContact'); //Create One Contact
  Route::get('contact/item/{contaTypeId}/{langId}',	'Api\Contact\ContactApiController@showItem');   //Get Contact Item

  //contact: member_contact
  Route::post('member_contact',                             'Api\Member\ContactApiController@addContact');  //Create One Contact
  Route::get('member_contact/item/{contaTypeId}/{langId}',  'Api\Member\ContactApiController@showItem');    //Get Contact Item

  //category tag
  Route::post('categoryTag/layer/find', 'Api\CategoryTagApiController@clientShowLayerId');  //Show layer

  //product
  Route::post('product/find/{productNum}',              'Api\ProductApiController@showProductsClient');     //search product(client)
  Route::get('product/getOne/{productId}',              'Api\ProductApiController@showProductOne');         //Get one product by id(client)
  Route::get('product/prodType/{prodTypeId}',           'Api\ProductApiController@showProductByTypeId');    //Get one product by type_id
  Route::get('product_cms/{productId}/view',            'Api\Cms\Product\CmsApiController@clientGetView');  //Get CMS Rendered Html By productId
  Route::get('product_img/{imgColumn}/{productId}.png', 'Api\ProductApiController@getProductImg');          //Get Target Column Img of Product

  //--------------------------------------------------------------------------------------------------------
  //cart(暫不使用)
  Route::post('cart/{langType}',      'Api\CartApiController@getCart');     //Get cart & total
  Route::post('cart/order',           'Api\CartApiController@order');       //order product
  Route::post('cart/order/guest',     'Api\CartApiController@guestOrder');  //order product
  Route::post('product/{productNum}', 'Api\ProductApiController@show');     //List show product

  //journal
  Route::post('journal/order',        'Api\JournalApiController@guestOrder'); //order journal
  Route::post('journal/order/guest',  'Api\JournalApiController@guestOrder'); //order journal

  //fare
  Route::post('fare', 'Api\FareApiController@show');
});
