<?php


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
define('__APP__','App\Http\Controllers');

//Route::get('/', __APP__. '\home\IndexController@index');
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//   Client
//
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Route::group(['langeId'=>1, 'middleware'=>'changelang'], function () { // 做語言版跳轉
Route::group(['langeId'=>1], function () {
    Route::get('/',                             __APP__.'\Client\HomeController@index');
    Route::get('/home.html',                    __APP__.'\Client\HomeController@index');


    Route::get('/privacy_policy.html',          __APP__.'\Client\CmsController@privacy_policy'); # 請勿刪除
    Route::get('/test/email.html',              __APP__.'\Api\Contact\ContactApiController@test_email'); # 請勿刪除

    Route::get('/line_card/select_share_target.html', __APP__.'\Client\LinecardController@select_share_target');
    Route::get('/{id}/online_page.html',              'Client\OnlineController@online_page_by_id');
    
});

/////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//   Customer
//
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
//member:customer login
Route::get('customer/login',            __APP__.'\Customer\CustomerController@login');           //login
Route::get('customer/register',         __APP__.'\Customer\CustomerController@register');        //register
Route::get('customer/logout',           __APP__.'\Customer\CustomerController@logout');          //logout
Route::get('customer/forgetPassword',   __APP__.'\Customer\CustomerController@forgetPassword');  //forget password

Route::get('customer/fill_register',        __APP__.'\Customer\CustomerController@fillRegister');        // fill up register
Route::get('customer/go_line_page',         __APP__.'\Customer\CustomerController@goLinePage');          // go to line page
Route::get('api/customer/line_auth',        __APP__.'\Api\Customer\MemberApiController@lineAuth');       // line auth callback
Route::post('api/customer/social_login',    __APP__.'\Api\Customer\MemberApiController@socialLogin');    //login
Route::get('/admin/line_auth',      __APP__.'\Api\MailboxApiController@lineAuth');   // line auth callback   
Route::group(['prefix'=>'customer', 'middleware'=>'customer', 'langeId'=>1], function () {
    //member:customer
    Route::get('/',                 __APP__.'\Customer\CustomerController@index');   // Index page
    //member:customer api
    Route::get('api/register',      __APP__.'\Api\Customer\MemberApiController@memberShowRegister');     // Show registered data
    Route::put('api/register',      __APP__.'\Api\Customer\MemberApiController@memberUpdateRegister');   // Update registered data
    Route::put('api/fill_register', __APP__.'\Api\Customer\MemberApiController@fillUpRegister');         // fill up registered data
    /*customer特有功能*/
    Route::get('shop',              __APP__.'\Customer\CustomerController@shop');                // shop page
    Route::post('api/tracking_shop',__APP__.'\Api\Customer\MemberApiController@tracking_shop');  //tracking/cancel tracking shop

});


/////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//   Member
//
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
//member:member login
Route::get('member/login',            __APP__.'\Member\MemberController@login');            //login
Route::get('member/register',         __APP__.'\Member\MemberController@register');         //register
Route::get('member/logout',           __APP__.'\Member\MemberController@logout');           //logout
Route::get('member/forgetPassword',   __APP__.'\Member\MemberController@forgetPassword');   //forget password

Route::group(['prefix'=>'member', 'middleware'=>'member', 'langeId'=>1], function () {
    //member:member
    Route::get('/',             __APP__.'\Member\MemberController@index');       // Index page
    //member:member api
    Route::get('api/register',  __APP__.'\Api\Member\MemberApiController@memberShowRegister');    // Show registered data
    Route::put('api/register',  __APP__.'\Api\Member\MemberApiController@memberUpdateRegister');  // Update registered data

    //gallery: member_gallery(extands gallery)
    Route::get('member_gallery/{galleryTypeId}',                    __APP__.'\Member\MemberGalleryController@index');   //List
    Route::get('member_gallery/{galleryTypeId}/create',             __APP__.'\Member\MemberGalleryController@create');  //Create
    Route::get('member_gallery/{galleryTypeId}/edit/{galleryId}',   __APP__.'\Member\MemberGalleryController@edit');    //Edit
    //gallery: member_gallery api(extands gallery api)
    Route::post('api/member_gallery/showAll/{galleryTypeId}',       __APP__.'\Api\Member\MemberGalleryApiController@showAll');            //show gallery List
    Route::put('api/member_gallery/status/multiple',                __APP__.'\Api\Member\MemberGalleryApiController@changeMultiStatus');  //Update gallery multi-status
    Route::put('api/member_gallery/delete',                         __APP__.'\Api\Member\MemberGalleryApiController@deleteGallery');      //Delelte gallery
    Route::get('api/member_gallery/{galleryId}',                    __APP__.'\Api\Member\MemberGalleryApiController@show');               //Show
    Route::post('api/member_gallery/{galleryTypeId}',               __APP__.'\Api\Member\MemberGalleryApiController@create');             //Create
    Route::post('api/member_gallery/update/{galleryId}',            __APP__.'\Api\Member\MemberGalleryApiController@update');             //Update
    Route::delete('api/member_gallery/{galleryTypeId}/{galleryId}', __APP__.'\Api\Member\MemberGalleryApiController@destroy');            //delete
    //cms: member_gallery_cms
    Route::get('member_gallery_cms/{cmsTypeId}',                    __APP__.'\Member\GalleryCmsController@index');       /*編輯畫面*/
    //cms: member_gallery_cms api
    Route::get('api/member_gallery_cms/{cmsTypeId}/view',           __APP__.'\Api\Member\GalleryCmsApiController@GetView'); /*預覽畫面*/
    Route::get('api/member_gallery_cms/showContent/{cmsTypeId}',    __APP__.'\Api\Member\GalleryCmsApiController@showCmsByTypeId');    //Show CMS By Type CmsType
    Route::post('api/member_gallery_cms/add',                       __APP__.'\Api\Member\GalleryCmsApiController@addCms');             //Create CMS
    Route::put('api/member_gallery_cms/edit',                       __APP__.'\Api\Member\GalleryCmsApiController@updateCms');          //Update One CMS
    Route::post('api/member_gallery_cms/delete',                    __APP__.'\Api\Member\GalleryCmsApiController@destroy');            //Delete One CMS
    Route::post('api/member_gallery_cms/delete/img',                __APP__.'\Api\Member\GalleryCmsApiController@destroyImg');         //Delete Img of CMS

    //contact: member_contact
    Route::get('member_contact/{contaTypeId}',                  __APP__.'\Member\ContactController@index');   //List
    Route::get('member_contact/edit/{contaTypeId}/{contaId}',   __APP__.'\Member\ContactController@edit');    //Edit
    //contact: member_contact api
    Route::get('api/member_contact/new/check',              __APP__.'\Api\Member\ContactApiController@checkNew');               //Get Edit One Contact
    Route::post('api/member_contact/show/get/all',          __APP__.'\Api\Member\ContactApiController@show');                   //Show Contact
    Route::put('api/member_contact/remove',                 __APP__.'\Api\Member\ContactApiController@remove');                 //Batch Remove Contact
    Route::put('api/member_contact/delete',                 __APP__.'\Api\Member\ContactApiController@destroy');                //Batch Delete Contact
    Route::get('api/member_contact/edit/{contaId}',         __APP__.'\Api\Member\ContactApiController@getOneContact');          //Get Edit One Contact
    Route::put('api/member_contact/{contaId}',              __APP__.'\Api\Member\ContactApiController@update');                 //Update One Contact
    Route::post('api/member_contact/item/add',              __APP__.'\Api\Member\ContactApiController@addContactItem');         //Create Contact Item
    Route::put('api/member_contact/item/update',            __APP__.'\Api\Member\ContactApiController@updateContactItem');      //Editor Contact Item
    Route::put('api/member_contact/item/updateItemName',    __APP__.'\Api\Member\ContactApiController@updateContactItemName');  //Editor Contact Item
    Route::put('api/member_contact/item/delete',            __APP__.'\Api\Member\ContactApiController@deleteContactItem');      //Batch Remove Contact Item
});



/////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//   Admin
//
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
//login
Route::get('/admin/login', __APP__.'\Admin\LoginController@index'); //Login page
Route::group(['middleware' => 'accountdolog'], function () {
    Route::get('/admin/logout',__APP__.'\Admin\LoginController@logout');//Logout page
    //login api
    Route::post('/admin/api/login/account', __APP__.'\Api\LoginApiController@accountLogin');
});

//---account has admin role can get these pages 
Route::group(['middleware' => 'role:admin'], function () {
    
    
    //account
    Route::get('/admin/account_do_log', __APP__.'\Admin\AccountController@account_do_log'); //List account_do_log
    Route::get('/admin/account', __APP__.'\Admin\AccountController@index'); //List
    Route::get('/admin/account/create', __APP__.'\Admin\AccountCreateController@index'); //Create
    Route::get('/admin/account/edit/{uid}', __APP__.'\Admin\AccountEditController@index'); //Editor
    //account api
    Route::get('/admin/api/account', __APP__.'\Api\AccountApiController@index'); //List
    Route::get('/admin/api/account/{acctId}', __APP__.'\Api\AccountApiController@show'); //Show
    Route::post('/admin/api/account', __APP__.'\Api\AccountApiController@create'); //Create
    Route::put('/admin/api/account', __APP__.'\Api\AccountApiController@update'); //Batch Update
    Route::put('/admin/api/account/{antId}', __APP__.'\Api\AccountApiController@update'); //Update
    Route::delete('/admin/api/account', __APP__.'\Api\AccountApiController@destroy'); //Batch Delete
    Route::delete('/admin/api/account/{acctId}', __APP__.'\Api\AccountApiController@destroy'); //Delete
});
//---account has admin,manager role can get these pages 
Route::group(['middleware' => 'role:admin,manager'], function () {
    Route::get('/admin', __APP__.'\Admin\AdminController@index');

    Route::get('/admin/go_line_page',   __APP__.'\Api\MailboxApiController@goLinePage'); // go to line page
     
    Route::post('/admin/api/lind_card', __APP__.'\Client\LinecardController@add');       //add

    //cms_type: cms type
    Route::get('/admin/cms/management/type',                    __APP__.'\Admin\Cms\CmsController@createType');      //createType
    //cms_type: cms type api
    Route::post('/admin/api/cms/management/cmsType/show',       __APP__.'\Api\Cms\CmsTypeApiController@show');       //Show
    Route::post('/admin/api/cms/management/cmsType/add',        __APP__.'\Api\Cms\CmsTypeApiController@typeAdd');    //typeAdd
    Route::put('/admin/api/cms/management/cmsType/save',        __APP__.'\Api\Cms\CmsTypeApiController@save');       //save
    Route::put('/admin/api/cms/management/cmsType/delete',      __APP__.'\Api\Cms\CmsTypeApiController@delete');     //delete
    Route::put('/admin/api/cms/management/cmsType/setStatus',   __APP__.'\Api\Cms\CmsTypeApiController@setStatus');  //Update setStatus
    //cms: cms
    Route::get('/admin/cms/{cmsTypeId}',                    __APP__.'\Admin\Cms\CmsController@index');       /*編輯畫面*/
    //cms: cms api
    Route::get('/admin/api/cms/{cmsTypeId}/view',           __APP__.'\Api\Cms\CmsApiController@GetView');    /*預覽畫面*/
    Route::get('/admin/api/cms/showContent/{cmsTypeId}',    __APP__.'\Api\Cms\CmsApiController@showCmsByTypeId');    //Show CMS By Type CmsType
    Route::post('/admin/api/cms/add',                       __APP__.'\Api\Cms\CmsApiController@addCms');             //Create CMS
    Route::put('/admin/api/cms/edit',                       __APP__.'\Api\Cms\CmsApiController@updateCms');          //Update One CMS
    Route::post('/admin/api/cms/delete',                    __APP__.'\Api\Cms\CmsApiController@destroy');            //Delete One CMS
    Route::post('/admin/api/cms/delete/img',                __APP__.'\Api\Cms\CmsApiController@destroyImg');         //Delete Img of CMS

    //cms_type: cms_layout type
    Route::get('/admin/cms_layout/management/type',                     __APP__.'\Admin\Cms\CmsLayoutController@createType');                //createType
    //cms_type: cms_layout type api
    Route::post('/admin/api/cms_layout/management/cmsType/show',        __APP__.'\Api\Cms\CmsLayoutTypeApiController@show');                 //Show types
    Route::post('/admin/api/cms_layout/management/cmsType/add',         __APP__.'\Api\Cms\CmsLayoutTypeApiController@typeAdd');              //Add type
    Route::put('/admin/api/cms_layout/management/cmsType/save',         __APP__.'\Api\Cms\CmsLayoutTypeApiController@save');                 //Save type
    Route::put('/admin/api/cms_layout/management/cmsType/delete',       __APP__.'\Api\Cms\CmsLayoutTypeApiController@delete');               //Delete type
    Route::put('/admin/api/cms_layout/management/cmsType/setStatus',    __APP__.'\Api\Cms\CmsLayoutTypeApiController@setStatus');            //Update setStatus
    //cms_type: cms_layout cms use layout api
    Route::post('/admin/api/cms_layout/mother_template/show',           __APP__.'\Api\Cms\CmsLayoutTypeApiController@show_mother_template'); //Show cms add mother template 
    Route::post('/admin/api/cms_layout/mother_template/add',            __APP__.'\Api\Cms\CmsLayoutTypeApiController@add_mother_template');  //From cms add mother template 
    Route::post('/admin/api/cms_layout/child_template/show',            __APP__.'\Api\Cms\CmsLayoutTypeApiController@show_child_template');  //Show Child template 
    Route::post('/admin/api/cms_layout/child_template/add',             __APP__.'\Api\Cms\CmsLayoutTypeApiController@add_child_template');   //Add Child template 
    Route::post('/admin/api/cms_layout/child_template/switch',          __APP__.'\Api\Cms\CmsLayoutTypeApiController@switch_child_template');//Switch Child template 
    Route::post('/admin/api/cms_layout/child_template/delete',          __APP__.'\Api\Cms\CmsLayoutTypeApiController@delete_child_tmplate'); //Delete Child template 

    //cms: cms_layout
    Route::get('/admin/cms_layout/{cmsTypeId}',                     __APP__.'\Admin\Cms\CmsLayoutController@index');     /*編輯畫面*/
    //cms: cms_layout api
    Route::get('/admin/api/cms_layout/{cmsTypeId}/view',            __APP__.'\Api\Cms\CmsLayoutApiController@GetView');  /*預覽畫面*/
    Route::get('/admin/api/cms_layout/showContent/{cmsTypeId}',     __APP__.'\Api\Cms\CmsLayoutApiController@showCmsByTypeId');      //Show CMS By Type CmsType
    Route::post('/admin/api/cms_layout/add',                        __APP__.'\Api\Cms\CmsLayoutApiController@addCms');               //Create CMS
    Route::put('/admin/api/cms_layout/edit',                        __APP__.'\Api\Cms\CmsLayoutApiController@updateCms');            //Update One CMS
    Route::post('/admin/api/cms_layout/delete',                     __APP__.'\Api\Cms\CmsLayoutApiController@destroy');              //Delete One CMS
    Route::post('/admin/api/cms_layout/delete/img',                 __APP__.'\Api\Cms\CmsLayoutApiController@destroyImg');           //Delete Img of CMS

    //cms_type: product_cms_layout type
    Route::get('/admin/product_cms_layout/management/type',                     __APP__.'\Admin\Cms\Product\CmsLayoutController@createType');                //createType
    //cms_type: product_cms_layout type api
    Route::post('/admin/api/product_cms_layout/management/cmsType/show',        __APP__.'\Api\Cms\Product\CmsLayoutTypeApiController@show');                 //Show types
    Route::post('/admin/api/product_cms_layout/management/cmsType/add',         __APP__.'\Api\Cms\Product\CmsLayoutTypeApiController@typeAdd');              //Add type
    Route::put('/admin/api/product_cms_layout/management/cmsType/save',         __APP__.'\Api\Cms\Product\CmsLayoutTypeApiController@save');                 //Save type
    Route::put('/admin/api/product_cms_layout/management/cmsType/delete',       __APP__.'\Api\Cms\Product\CmsLayoutTypeApiController@delete');               //Delete type
    Route::put('/admin/api/product_cms_layout/management/cmsType/setStatus',    __APP__.'\Api\Cms\Product\CmsLayoutTypeApiController@setStatus');            //Update setStatus
    //cms_type: product_cms_layout cms use layout api
    Route::post('/admin/api/product_cms_layout/mother_template/show',           __APP__.'\Api\Cms\Product\CmsLayoutTypeApiController@show_mother_template'); //Show cms add mother template 
    Route::post('/admin/api/product_cms_layout/mother_template/add',            __APP__.'\Api\Cms\Product\CmsLayoutTypeApiController@add_mother_template');  //From cms add mother template 
    Route::post('/admin/api/product_cms_layout/child_template/show',            __APP__.'\Api\Cms\Product\CmsLayoutTypeApiController@show_child_template');  //Show Child template 
    Route::post('/admin/api/product_cms_layout/child_template/add',             __APP__.'\Api\Cms\Product\CmsLayoutTypeApiController@add_child_template');   //Add Child template 
    Route::post('/admin/api/product_cms_layout/child_template/switch',          __APP__.'\Api\Cms\Product\CmsLayoutTypeApiController@switch_child_template');//Switch Child template 
    Route::post('/admin/api/product_cms_layout/child_template/delete',          __APP__.'\Api\Cms\Product\CmsLayoutTypeApiController@delete_child_tmplate'); //Delete Child template 
    
    //cms: product_cms_layout
    Route::get('/admin/product_cms_layout/{cmsTypeId}',                     __APP__.'\Admin\Cms\Product\CmsLayoutController@index');     /*編輯畫面*/
    //cms: product_cms_layout api
    Route::get('/admin/api/product_cms_layout/{cmsTypeId}/view',            __APP__.'\Api\Cms\Product\CmsLayoutApiController@GetView');  /*預覽畫面*/
    Route::get('/admin/api/product_cms_layout/showContent/{cmsTypeId}',     __APP__.'\Api\Cms\Product\CmsLayoutApiController@showCmsByTypeId');      //Show CMS By Type CmsType
    Route::post('/admin/api/product_cms_layout/add',                        __APP__.'\Api\Cms\Product\CmsLayoutApiController@addCms');               //Create CMS
    Route::put('/admin/api/product_cms_layout/edit',                        __APP__.'\Api\Cms\Product\CmsLayoutApiController@updateCms');            //Update One CMS
    Route::post('/admin/api/product_cms_layout/delete',                     __APP__.'\Api\Cms\Product\CmsLayoutApiController@destroy');              //Delete One CMS
    Route::post('/admin/api/product_cms_layout/delete/img',                 __APP__.'\Api\Cms\Product\CmsLayoutApiController@destroyImg');           //Delete Img of CMS
    
    //cms: product_cms
    Route::get('/admin/product_cms/{cmsTypeId}',                    __APP__.'\Admin\Cms\Product\CmsController@index');       /*編輯畫面*/
    //cms: product_cms api
    Route::get('/admin/api/product_cms/{cmsTypeId}/view',           __APP__.'\Api\Cms\Product\CmsApiController@GetView');    /*預覽畫面*/
    Route::get('/admin/api/product_cms/showContent/{cmsTypeId}',    __APP__.'\Api\Cms\Product\CmsApiController@showCmsByTypeId');    //Show CMS By Type CmsType
    Route::post('/admin/api/product_cms/add',                       __APP__.'\Api\Cms\Product\CmsApiController@addCms');             //Create CMS
    Route::put('/admin/api/product_cms/edit',                       __APP__.'\Api\Cms\Product\CmsApiController@updateCms');          //Update One CMS
    Route::post('/admin/api/product_cms/delete',                    __APP__.'\Api\Cms\Product\CmsApiController@destroy');            //Delete One CMS
    Route::post('/admin/api/product_cms/delete/img',                __APP__.'\Api\Cms\Product\CmsApiController@destroyImg');         //Delete Img of CMS


    //gallery: gallery
    Route::get('/admin/gallery/{galleryTypeId}',                    __APP__.'\Admin\Gallery\GalleryController@index');   //List
    Route::get('/admin/gallery/{galleryTypeId}/create',             __APP__.'\Admin\Gallery\GalleryController@create');  //Create
    Route::get('/admin/gallery/{galleryTypeId}/edit/{galleryId}',   __APP__.'\Admin\Gallery\GalleryController@edit');    //Edit
    //gallery: gallery api
    Route::post('/admin/api/gallery/showAll/{galleryTypeId}',       __APP__.'\Api\Gallery\GalleryApiController@showAll');            //show gallery List
    Route::put('/admin/api/gallery/status/multiple',                __APP__.'\Api\Gallery\GalleryApiController@changeMultiStatus');  //Update gallery multi-status
    Route::put('/admin/api/gallery/delete',                         __APP__.'\Api\Gallery\GalleryApiController@deleteGallery');      //Delelte gallery
    Route::get('/admin/api/gallery/{galleryId}',                    __APP__.'\Api\Gallery\GalleryApiController@show');               //Show
    Route::post('/admin/api/gallery/{galleryTypeId}',               __APP__.'\Api\Gallery\GalleryApiController@create');             //Create
    Route::post('/admin/api/gallery/update/{galleryId}',            __APP__.'\Api\Gallery\GalleryApiController@update');             //Update
    Route::delete('/admin/api/gallery/{galleryTypeId}/{galleryId}', __APP__.'\Api\Gallery\GalleryApiController@destroy');            //delete


    //contact: contact
    Route::get('/admin/contact/{contaTypeId}',                  __APP__.'\Admin\Contact\ContactController@index');   //List
    Route::get('/admin/contact/edit/{contaTypeId}/{contaId}',   __APP__.'\Admin\Contact\ContactController@edit');    //Edit
    //contact: contact api
    Route::get('/admin/api/contact/new/check',              __APP__.'\Api\Contact\ContactApiController@checkNew');               //Get Edit One Contact
    Route::post('/admin/api/contact/show/get/all',          __APP__.'\Api\Contact\ContactApiController@show');                   //Show Contact
    Route::put('/admin/api/contact/remove',                 __APP__.'\Api\Contact\ContactApiController@remove');                 //Batch Remove Contact
    Route::put('/admin/api/contact/delete',                 __APP__.'\Api\Contact\ContactApiController@destroy');                //Batch Delete Contact
    Route::get('/admin/api/contact/edit/{contaId}',         __APP__.'\Api\Contact\ContactApiController@getOneContact');          //Get Edit One Contact
    Route::put('/admin/api/contact/{contaId}',              __APP__.'\Api\Contact\ContactApiController@update');                 //Update One Contact
    Route::post('/admin/api/contact/item/add',              __APP__.'\Api\Contact\ContactApiController@addContactItem');         //Create Contact Item
    Route::put('/admin/api/contact/item/update',            __APP__.'\Api\Contact\ContactApiController@updateContactItem');      //Editor Contact Item
    Route::put('/admin/api/contact/item/updateItemName',    __APP__.'\Api\Contact\ContactApiController@updateContactItemName');  //Editor Contact Item
    Route::put('/admin/api/contact/item/delete',            __APP__.'\Api\Contact\ContactApiController@deleteContactItem');      //Batch Remove Contact Item


    //mailbox
    Route::get('/admin/mailbox', __APP__.'\Admin\MailboxController@index'); //List
    Route::get('/admin/mailbox/create', __APP__.'\Admin\MailboxController@create'); //Create
    Route::get('/admin/mailbox/edit/{mbId}', __APP__.'\Admin\MailboxController@edit'); //Editor
    //mailbox api
    Route::get('/admin/api/mailbox', __APP__.'\Api\MailboxApiController@index'); //List
    Route::get('/admin/api/mailbox/{mailboxId}', __APP__.'\Api\MailboxApiController@show'); //Show
    Route::post('/admin/api/mailbox', __APP__.'\Api\MailboxApiController@create'); //Create
    Route::put('/admin/api/mailbox', __APP__.'\Api\MailboxApiController@update'); //Batch Update
    Route::put('/admin/api/mailbox/{mbId}', __APP__.'\Api\MailboxApiController@update'); //Update
    Route::delete('/admin/api/mailbox', __APP__.'\Api\MailboxApiController@destroy'); //Batch Delete
    Route::delete('/admin/api/mailbox/{mbId}', __APP__.'\Api\MailboxApiController@destroy'); //delete

    //lang
    Route::get('/admin/lang', __APP__.'\Admin\LangController@index'); //List
    //lang api
    Route::get('/admin/api/lang', __APP__.'\Api\LangApiController@index'); //List
    Route::post('/admin/api/lang', __APP__.'\Api\LangApiController@add'); //Create
    Route::put('/admin/api/lang', __APP__.'\Api\LangApiController@update'); //Update

    //seo
    Route::get('/admin/seo', __APP__.'\Admin\SeoController@index');
    Route::get('/admin/seoMarketing', __APP__.'\Admin\SeoController@marketing');
    Route::get('/admin/seoAdvanced', __APP__.'\Admin\SeoController@advanced');
    //seo api
    Route::post('/admin/api/seo', __APP__.'\Api\SeoApiController@getOne'); //List
    Route::put('/admin/api/seo', __APP__.'\Api\SeoApiController@update'); //Update

    //system
    Route::get('/admin/development/team', __APP__.'\Admin\SystemController@development');
    Route::get('/admin/system/intro', __APP__.'\Admin\SystemController@system');
    //system api
    Route::post('/admin/development/team/save', __APP__.'\Api\SystemApiController@devTeamSave');
    Route::get('/admin/development/team/show', __APP__.'\Api\SystemApiController@devTeamShow');
    Route::post('/admin/system/intro/save', __APP__.'\Api\SystemApiController@sysIntroSave');
    Route::get('/admin/system/intro/show', __APP__.'\Api\SystemApiController@sysIntroShow');


    //category_tag
    Route::get('/admin/categoryTag/{propertyTagId}', __APP__.'\Admin\CategoryTagController@index');
    //category_tag api
    Route::post('/admin/api/categoryTag', __APP__.'\Api\CategoryTagApiController@show'); //List
    Route::post('/admin/api/categoryTag/add', __APP__.'\Api\CategoryTagApiController@add'); //Create
    Route::put('/admin/api/categoryTag/save', __APP__.'\Api\CategoryTagApiController@save'); //Update
    Route::put('/admin/api/categoryTag/save/order', __APP__.'\Api\CategoryTagApiController@save_order'); //Update order
    Route::put('/admin/api/categoryTag/delete', __APP__.'\Api\CategoryTagApiController@delete'); //Delelte
    Route::put('/admin/api/categoryTag/setStatus', __APP__.'\Api\CategoryTagApiController@setStatus'); //Update status

    Route::post('/admin/api/categoryTag/layer/find', __APP__.'\Api\CategoryTagApiController@adminShowLayerId'); //List
    Route::post('/admin/api/categoryTag/tree/json/{cate_id}', __APP__.'\Api\CategoryTagApiController@treeJson');

    Route::post('/admin/api/categoryTag/hierarchy/show', __APP__.'\Api\CategoryTagApiController@hierarchy_show'); //show trees class
    Route::post('/admin/api/categoryTag/hierarchy/judgeHasChild', __APP__.'\Api\CategoryTagApiController@judgeHasChild'); //judgeHasChild
    Route::post('/admin/api/categoryTag/delete/check', __APP__.'\Api\CategoryTagApiController@DeleteCheck'); //delete tags


    //property_tag
    Route::get('/admin/propertyTag/{propertyTagId}', __APP__.'\Admin\PropertyTagController@index');
    //property_tag api
    Route::post('/admin/api/propertyTag', __APP__.'\Api\PropertyTagApiController@show'); //List
    Route::post('/admin/api/propertyTag/add', __APP__.'\Api\PropertyTagApiController@add'); //Create
    Route::put('/admin/api/propertyTag/save', __APP__.'\Api\PropertyTagApiController@save'); //Update
    Route::put('/admin/api/propertyTag/delete', __APP__.'\Api\PropertyTagApiController@delete'); //Delelte
    Route::put('/admin/api/propertyTag/setStatus', __APP__.'\Api\PropertyTagApiController@setStatus'); //Delelte
    Route::post('/admin/api/propertyTag/{propertyTagId}', __APP__.'\Api\PropertyTagApiController@showId'); //List show product



    //product
    Route::get('/admin/product/{productNum}',               __APP__.'\Admin\ProductController@index');                   //prodcut list
    Route::get('/admin/product/{productNum}/add',           __APP__.'\Admin\ProductController@add');                     //add product(main+detail)
    Route::get('/admin/product/edit/detail/{productNum}/{productId}', __APP__.'\Admin\ProductController@editDetail');    //create complete pro content modify
    // Route::get('/admin/product/{productNum}/edit/detail/{productId}', __APP__.'\Admin\ProductController@editDetail');    //edit product

    //product api
    Route::post('/admin/api/tag/buliding/product', __APP__.'\Api\ProductApiController@tag_add_pord');                        //tag add product
    Route::post('/admin/api/tag/delete/buliding/product', __APP__.'\Api\ProductApiController@tag_del_add_pord');             //delete not finish product than tag add product
    Route::get('/admin/api/product/{productNum}/preadd', __APP__.'\Api\ProductApiController@getLastProductlNotFinish');      //Check if product is being builded

    Route::post('/admin/api/product/find/{productNum}',         __APP__.'\Api\ProductApiController@showProductsAdmin');  //search product(admin)
    Route::put('/admin/api/product/status',                     __APP__.'\Api\ProductApiController@changeStatus');       //Update one product status
    Route::put('/admin/api/product/status/multiple',            __APP__.'\Api\ProductApiController@changeMultiStatus');  //Update multi-product status
    Route::put('/admin/api/product/delete',                     __APP__.'\Api\ProductApiController@deleteProduct');      //Delelte product
    Route::put('/admin/api/product/{prodId}',                   __APP__.'\Api\ProductApiController@updateMainOrder');    //Update product order
    Route::put('/admin/api/product/category/order/{prodId}',    __APP__.'\Api\ProductApiController@updateClassOrder');   //Update product class order
    
    Route::post('/admin/api/product/owner', __APP__.'\Api\ProductApiController@setOwner');      //set one product owner
    Route::post('/admin/api/product/setlayout', __APP__.'\Api\ProductApiController@setLayout');      //set one product style layout
    Route::post('/admin/api/product/detail/edit', __APP__.'\Api\ProductApiController@getDetailToEdit');      //get one product data to edit
    Route::put('/admin/api/product/main/edit', __APP__.'\Api\ProductApiController@editMain');                //Update product main
    Route::put('/admin/api/product/category/tag', __APP__.'\Api\ProductApiController@editProdCategoryTag');  //Update product category tag
    Route::put('/admin/api/product_describe', __APP__.'\Api\ProductApiController@editProductDescribe');      //Update product describe
    Route::put('/admin/api/product_property', __APP__.'\Api\ProductApiController@editProductProperty');      //Update product property

    Route::post('/admin/api/product_type', __APP__.'\Api\ProductApiController@addProductType');              //add product type
    Route::put('/admin/api/product_type', __APP__.'\Api\ProductApiController@editProductType');              //Update product type
    Route::put('/admin/api/product_type/remove', __APP__.'\Api\ProductApiController@deleteProductType');     //Delete product type

    Route::post('/admin/api/product_specification', __APP__.'\Api\ProductApiController@addProductSpec');         //add product specification
    Route::put('/admin/api/product_specification', __APP__.'\Api\ProductApiController@editProductSpec');         //Update product specification
    Route::put('/admin/api/product_specification/remove', __APP__.'\Api\ProductApiController@deleteProductSpec');//Delete product specification

    Route::post('/admin/api/product/img', __APP__.'\Api\ProductApiController@addProductImg');                        //Create product img
    Route::put('/admin/api/product/img/modify/{productId}', __APP__.'\Api\ProductApiController@modifyProductImg');   //Modify product img
    Route::put('/admin/api/product_img', __APP__.'\Api\ProductApiController@deleteProductImg');                      //Delete product img

    Route::post('/admin/api/product/file/{productId}', __APP__.'\Api\ProductApiController@addProductFile');          //Create product file
    Route::put('/admin/api/product/file/modify/{productId}', __APP__.'\Api\ProductApiController@modifyProductFile'); //Modify product file
    Route::put('/admin/api/product_file', __APP__.'\Api\ProductApiController@deleteProductFile');                    //Delete product file
    

    // product seo
    Route::get('/admin/product/seo/{productNum}', __APP__.'\Admin\ProductSeoTagController@index');
    // product seo api
    Route::post('/admin/api/prod_seo/seoTag/{productNum}', __APP__.'\Api\ProdSeoTagApiController@show')->where('productNum', '[0-9]+'); //List show
    Route::post('/admin/api/prod_seo/seoTag/add', __APP__.'\Api\ProdSeoTagApiController@add'); //Create
    Route::put('/admin/api/prod_seo/seoTag/save', __APP__.'\Api\ProdSeoTagApiController@save'); //Update
    Route::put('/admin/api/prod_seo/seoTag/delete', __APP__.'\Api\ProdSeoTagApiController@delete'); //Delelte
    Route::put('/admin/api/prod_seo/seoTag/setStatus', __APP__.'\Api\ProdSeoTagApiController@setStatus'); //Delelte
    Route::post('/admin/api/product/prod_seo/edit', __APP__.'\Api\ProductApiController@getSeoProperty'); //
    Route::put('/admin/api/product/prod_seo/property/edit', __APP__.'\Api\ProductApiController@editProductSeoProperty'); //Update product seo property

    // product label
    Route::get('/admin/product/label/{productNum}', __APP__.'\Admin\ProductLabelTagController@index');
    // product label api
    Route::post('/admin/api/prod_label/labelTag/{productNum}', __APP__.'\Api\ProdLabelTagApiController@show')->where('productNum', '[0-9]+'); //List show 
    Route::post('/admin/api/prod_label/labelTag/add', __APP__.'\Api\ProdLabelTagApiController@add'); //Create
    Route::put('/admin/api/prod_label/labelTag/save', __APP__.'\Api\ProdLabelTagApiController@save'); //Update
    Route::put('/admin/api/prod_label/labelTag/delete', __APP__.'\Api\ProdLabelTagApiController@delete'); //Delelte
    Route::put('/admin/api/prod_label/labelTag/setStatus', __APP__.'\Api\ProdLabelTagApiController@setStatus'); //Delelte
    Route::post('/admin/api/prod_label/show', __APP__.'\Api\ProductApiController@showLabel'); //
    Route::put('/admin/api/prod_label/edit', __APP__.'\Api\ProductApiController@editLabel'); //

    // product tabs
    Route::get('/admin/product/tabs/{productNum}', __APP__.'\Admin\ProductTabsController@index');
    // product tabs api
    Route::post('/admin/api/prod_tabs/tabsTag/{productNum}', __APP__.'\Api\ProdTabsApiController@show')->where('productNum', '[0-9]+'); //List show
    Route::post('/admin/api/prod_tabs/tabsTag/add', __APP__.'\Api\ProdTabsApiController@add'); //Create
    Route::put('/admin/api/prod_tabs/tabsTag/save', __APP__.'\Api\ProdTabsApiController@save'); //Update
    Route::put('/admin/api/prod_tabs/tabsTag/delete', __APP__.'\Api\ProdTabsApiController@delete'); //Delelte
    Route::put('/admin/api/prod_tabs/tabsTag/setStatus', __APP__.'\Api\ProdTabsApiController@setStatus'); //Delelte
    Route::post('/admin/api/prod_tabs/show', __APP__.'\Api\ProductApiController@showTabs'); //
    Route::put('/admin/api/prod_tabs/edit', __APP__.'\Api\ProductApiController@editTabs'); //


    //fare
    Route::get('/admin/fare', __APP__.'\Admin\FareController@index');
    //fare api
    Route::post('/admin/api/fare', __APP__.'\Api\FareApiController@show'); //List
    Route::post('/admin/api/fare/add', __APP__.'\Api\FareApiController@add'); //Create
    Route::put('/admin/api/fare/save', __APP__.'\Api\FareApiController@save'); //Update
    Route::put('/admin/api/fare/delete', __APP__.'\Api\FareApiController@delete'); //Delelte
    Route::put('/admin/api/fare/status', __APP__.'\Api\FareApiController@setStatus'); //Update status
    Route::put('/admin/api/fare/status/multiple', __APP__.'\Api\FareApiController@changeMultiStatus'); //Update multi-status


    //order
    Route::get('/admin/product/{prodNum}/order', __APP__.'\Admin\OrderController@index'); // Order list
    Route::get('/admin/product/{prodNum}/order/{orderId}/edit', __APP__.'\Admin\OrderController@edit'); // Order edit
    //order api
    Route::post('/admin/api/getPageOrder', __APP__.'\Api\OrderApiController@page'); //list
    Route::get('/admin/api/order/{orderId}', __APP__.'\Api\OrderApiController@show'); //show
    Route::put('/admin/api/order/{orderId}/payStatus', __APP__.'\Api\OrderApiController@updatePayStatus'); //update pay status
    Route::put('/admin/api/order/{orderId}/shippingStatus', __APP__.'\Api\OrderApiController@updateShippingStatus'); //update shipping status
    Route::post('/admin/api/order/trash', __APP__.'\Api\OrderApiController@trash');


    //journal(order)
    Route::get('/admin/journal/order', __APP__.'\Admin\JournalOrderController@index'); // Order list
    Route::get('/admin/journal/order/{orderId}/edit', __APP__.'\Admin\JournalOrderController@edit'); // Order edit
    //journal(order) api
    Route::post('/admin/api/getJournalPageOrder', __APP__.'\Api\JournalOrderApiController@page'); //list
    Route::get('/admin/api/journalOrder/{orderId}', __APP__.'\Api\JournalOrderApiController@show'); //show
    Route::put('/admin/api/journalOrder/{orderId}/payStatus', __APP__.'\Api\JournalOrderApiController@updatePayStatus'); //update pay status
    Route::put('/admin/api/journalOrder/{orderId}/shippingStatus', __APP__.'\Api\JournalOrderApiController@updateShippingStatus'); //update shipping status

    //miscellaneous
    Route::get('/admin/miscellaneous/{miscId}', __APP__.'\Admin\MiscellaneousController@index');
    //miscellaneous api
    Route::post('/admin/api/miscellaneous', __APP__.'\Api\MiscellaneousApiController@show');  //Show
    Route::put('/admin/api/miscellaneous', __APP__.'\Api\MiscellaneousApiController@update');//Update

    //member
    Route::get('/admin/member',             __APP__.'\Admin\MemberController@index');
    Route::get('/admin/member/{acct_id}',   __APP__.'\Admin\MemberController@edit');
    //member:member api
    Route::post('/admin/api/member/page/get',           __APP__.'\Api\Member\MemberApiController@adminShowPage');        //get user list(admin)
    Route::post('/admin/api/member/page/export',        __APP__.'\Api\Member\MemberApiController@adminExportPage');      //export user list(admin)
    Route::get('/admin/api/member/Info/{memberId}',     __APP__.'\Api\Member\MemberApiController@adminShowMemberInfo');  //get user info by id(admin)
    Route::post('/admin/api/member/updateUserStatus',   __APP__.'\Api\Member\MemberApiController@adminUpdateUserStatus');
    Route::put('/admin/api/member/Info/{memberId}',     __APP__.'\Api\Member\MemberApiController@adminUpdateMemberInfo');
    Route::post('/admin/api/member/sendActiveCode',     __APP__.'\Api\Member\MemberApiController@sendActiveCode');

    Route::get('/admin/api/member/Types/{memberId}',    __APP__.'\Api\Member\MemberApiController@getMemberTypes');
    Route::post('/admin/api/member/Types',              __APP__.'\Api\Member\MemberApiController@addMemberTypes');
    Route::put('/admin/api/member/Types',               __APP__.'\Api\Member\MemberApiController@updateMemberTypes');
    Route::post('/admin/api/member/Types/delete',       __APP__.'\Api\Member\MemberApiController@deleteMemberTypes');

    // Route::post('/admin/api/memberInfo/findUser', __APP__.'\Api\Member\MemberApiController@findUser');
    // Route::put('/admin/api/member/{id}/role', __APP__.'\Api\Member\MemberApiController@updateRole');
    // Route::put('/admin/api/member/{id}/pw', __APP__.'\Api\Member\MemberApiController@updatePassword');
    // Route::post('/admin/api/member/manager', __APP__.'\Api\Member\MemberApiController@storeManager');

    //customer
    Route::get('/admin/customer',             __APP__.'\Admin\CustomerController@index');
    Route::get('/admin/customer/{acct_id}',   __APP__.'\Admin\CustomerController@edit');
    //member:customer api
    Route::post('/admin/api/customer/page/get',         __APP__.'\Api\Customer\MemberApiController@adminShowPage');          //get user list(admin)
    Route::post('/admin/api/customer/page/export',      __APP__.'\Api\Customer\MemberApiController@adminExportPage');        //export user list(admin)
    Route::get('/admin/api/customer/Info/{memberId}',   __APP__.'\Api\Customer\MemberApiController@adminShowMemberInfo');    //get user info by id(admin)
    Route::post('/admin/api/customer/updateUserStatus', __APP__.'\Api\Customer\MemberApiController@adminUpdateUserStatus');
    Route::put('/admin/api/customer/Info/{memberId}',   __APP__.'\Api\Customer\MemberApiController@adminUpdateMemberInfo');


    //qa record
    Route::get('/admin/qa_record/index',            __APP__.'\Admin\Record\QaRecordController@index');
    //qa record api
    Route::post('/admin/api/qa_record/get_record',  __APP__.'\Api\Record\QaRecordApiController@getRecord');
    Route::post('/admin/api/qa_record/update',      __APP__.'\Api\Record\QaRecordApiController@UpdateRecord');
    Route::post('/admin/api/qa_record/multi_updat', __APP__.'\Api\Record\QaRecordApiController@multiUpdat');


    // //menu_lang
    // Route::get('/admin/api/menu/lang/test', 'Api\MenuLangApiController@test'); //Create
    // //debug
    // Route::get('/admin/debug', 'Api\DebugController@index');
    // Route::post('/admin/api/debug', 'Api\DebugApiController@debug');
});