<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
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

Route::get('/', function () {
    return Redirect::to('https://resolutecontracts.com/');
    // return view('welcome');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/change-notification-status/{id}', [App\Http\Controllers\UserController::class, 'change_notification_status'])->name('change-notification-status');
    
});

// comment vendor performance
Route::get('/user/comment/{id}', [App\Http\Controllers\UserController::class, 'comment'])->name('user-comment');
Route::post('/user/store-comment', [App\Http\Controllers\UserController::class, 'store_comment'])->name('user-store-comment');
    
//comment email
Route::get('get-pcv-email-data', [App\Http\Controllers\UserController::class, 'get_pcv_email_data'])->name('get-pcv-email-data');

// /user/update-and-check-document-status

Route::get('/user/update-and-check-document-status/{ownermsaid}', [App\Http\Controllers\ContractController::class, 'update_and_check_document_status'])->name('user-update-and-check-document-status');

Route::get('/vendor/update-and-check-document-status/{ownermsaid}', [App\Http\Controllers\VendorController::class, 'update_and_check_document_status'])->name('vendor-update-and-check-document-status');


Route::get('/user/update-and-check-document-status-vendormsa/{vendormsaid}', [App\Http\Controllers\ContractController::class, 'update_and_check_document_status_vendormsa'])->name('user-update-and-check-document-status-vendormsa');

Route::get('/vendor/update-and-check-document-status-vendormsa/{vendormsaid}', [App\Http\Controllers\VendorController::class, 'update_and_check_document_status_vendormsa'])->name('vendor-update-and-check-document-status-vendormsa');


Route::get('/user/update-and-check-document-status-pco/{pcoid}', [App\Http\Controllers\ContractController::class, 'update_and_check_document_status_pco'])->name('user-update-and-check-document-status-pco');

Route::get('/vendor/update-and-check-document-status-pco/{pcoid}', [App\Http\Controllers\VendorController::class, 'update_and_check_document_status_pco'])->name('vendor-update-and-check-document-status-pco');

Route::get('/user/update-and-check-document-status-pcv/{pcvid}', [App\Http\Controllers\ContractController::class, 'update_and_check_document_status_pcv'])->name('user-update-and-check-document-status-pcv');

Route::get('/vendor/update-and-check-document-status-pcv/{pcvid}', [App\Http\Controllers\VendorController::class, 'update_and_check_document_status_pcv'])->name('vendor-update-and-check-document-status-pcv');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::middleware(['auth','admin'])->group(function () {
    Route::get('/admin/dashboard', [App\Http\Controllers\AdminController::class, 'index'])->name('admin-dashboard');
    
    // profile update
    Route::get('/admin/edit/profile/{id}', [App\Http\Controllers\AdminController::class, 'edit_profile'])->name('admin-editprofile');
    Route::post('/admin/update-profile', [App\Http\Controllers\AdminController::class, 'update_profile'])->name('admin-updateprofile');
         
    Route::get('/admin/demo-request', [App\Http\Controllers\AdminController::class, 'demo_request'])->name('admin-demo-request');
    Route::get('/admin/registered-users', [App\Http\Controllers\AdminController::class, 'registered_users'])->name('admin-registered-users');
    Route::get('/admin/create-user', [App\Http\Controllers\AdminController::class, 'create_user'])->name('admin-create-user');
    Route::post('/admin/store-user', [App\Http\Controllers\AdminController::class, 'store_user'])->name('admin-store-user');
    Route::get('/admin/edit-user/{id}', [App\Http\Controllers\AdminController::class, 'edit_user'])->name('admin-edit-user');
    Route::post('/admin/update-user', [App\Http\Controllers\AdminController::class, 'update_user'])->name('admin-update-user');
    Route::get('/admin/delete-user/{id}', [App\Http\Controllers\AdminController::class, 'delete_user'])->name('admin-delete-user');
    
});




Route::middleware(['auth','user'])->group(function () {
    // dashboard
    Route::get('/user/dashboard', [App\Http\Controllers\UserController::class, 'index'])->name('user-dashboard');


    // vendor
    Route::post('/user/create_vendor', [App\Http\Controllers\UserController::class, 'create_vendor'])->name('user-create-vendor');
    Route::get('/user/create_vendor', [App\Http\Controllers\UserController::class, 'create_vendor'])->name('user-create-vendor');

    
   
    

    // external contract
    Route::get('/user/external-contract', [App\Http\Controllers\ContractController::class, 'external_contract'])->name('user-external-contract');
    Route::post('/user/store-external-contract', [App\Http\Controllers\ContractController::class, 'store_external_contract'])->name('user-store-external-contract');


    // all contract
    Route::get('/user/all-contracts', [App\Http\Controllers\ContractController::class, 'all_contracts'])->name('user-all-contracts');
    Route::get('/user/create-owner-msa', [App\Http\Controllers\ContractController::class, 'create_owner_msa'])->name('user-create-owner-msa');
    Route::post('/user/store-owner-msa', [App\Http\Controllers\ContractController::class, 'store_owner_msa'])->name('user-store-owner-msa');

    Route::get('/user/create-vendor-msa', [App\Http\Controllers\ContractController::class, 'create_vendor_msa'])->name('user-create-vendor-msa');
    Route::post('/user/store-vendor-msa', [App\Http\Controllers\ContractController::class, 'store_vendor_msa'])->name('user-store-vendor-msa');

    Route::get('/user/create-project-contract-owner', [App\Http\Controllers\ContractController::class, 'create_project_contract_owner'])->name('user-create-project-contract-owner');
    Route::post('/user/store-project-contract-owner', [App\Http\Controllers\ContractController::class, 'store_project_contract_owner'])->name('user-store-project-contract-owner');

    Route::get('/user/create-project-contract-vendor', [App\Http\Controllers\ContractController::class, 'create_project_contract_vendor'])->name('user-create-project-contract-vendor');
    Route::post('/user/store-project-contract-vendor', [App\Http\Controllers\ContractController::class, 'store_project_contract_vendor'])->name('user-store-project-contract-vendor');

    Route::get('/user/get-vendor-msa/{id}', [App\Http\Controllers\ContractController::class, 'get_vendor_msa'])->name('user-get-vendor-msa');

    Route::get('/user/get-project-details/{id}', [App\Http\Controllers\ContractController::class, 'get_project_details'])->name('user-get-project-details');



    // workflow vendor
    Route::get('/user/start-workflow/vendor-msa/{vendormsaid}', [App\Http\Controllers\ContractController::class, 'vendor_msa_start_workflow'])->name('user-vendor-msa-start-workflow');

     Route::post('/user/save-workflow/vendor-msa', [App\Http\Controllers\ContractController::class, 'vendor_msa_save_workflow'])->name('user-vendor-msa-save-workflow');


    //  signature vendor
    Route::post('/user/request/signature/vendor-msa', [App\Http\Controllers\ContractController::class, 'vendor_msa_request_signature'])->name('user-vendor-msa-request-signature');

    Route::post('/user/send/next/teammember/vendor-msa', [App\Http\Controllers\ContractController::class, 'vendor_msa_sent_next_teammember'])->name('user-vendor-msa-sent-next-teammember');

    // workflow owner
     Route::get('/user/start-workflow/owner-msa/{ownermsaid}', [App\Http\Controllers\ContractController::class, 'owner_msa_start_workflow'])->name('user-owner-msa-start-workflow');
     Route::post('/user/save-workflow/owner-msa', [App\Http\Controllers\ContractController::class, 'owner_msa_save_workflow'])->name('user-owner-msa-save-workflow');
     
    //  signature owner
    Route::post('/user/request/signature/owner-msa', [App\Http\Controllers\ContractController::class, 'owner_msa_request_signature'])->name('user-owner-msa-request-signature');
    
    
    // workflow project-contract-owner
     Route::get('/user/start-workflow/project-contract-owner/{pcoid}', [App\Http\Controllers\ContractController::class, 'project_contract_owner_start_workflow'])->name('user-project-contract-owner-start-workflow');
     Route::post('/user/save-workflow/project-contract-owner', [App\Http\Controllers\ContractController::class, 'project_contract_owner_save_workflow'])->name('user-project-contract-owner-save-workflow');
     
    //  signature project-contract-owner
    Route::post('/user/request/signature/project-contract-owner', [App\Http\Controllers\ContractController::class, 'project_contract_owner_request_signature'])->name('user-project-contract-owner-request-signature');
    


// workflow project owner vendor
    Route::get('/user/start-workflow/project-contract-vendor/{pcvid}', [App\Http\Controllers\ContractController::class, 'project_contract_vendor_start_workflow'])->name('user-project-contract-vendor-start-workflow');

     Route::post('/user/save-workflow/project-contract-vendor', [App\Http\Controllers\ContractController::class, 'project_contract_vendor_save_workflow'])->name('user-project-contract-vendor-save-workflow');


    //  signature vendor
    Route::post('/user/request/signature/project-contract-vendor', [App\Http\Controllers\ContractController::class, 'project_contract_vendor_request_signature'])->name('user-project-contract-vendor-request-signature');

    
    
    // template
    Route::get('/user/template-repository', [App\Http\Controllers\TemplateController::class, 'template_repository'])->name('user-template-repository');

    Route::get('/user/get-template/{id}', [App\Http\Controllers\TemplateController::class, 'get_template'])->name('user-get-template');

                        Route::group(['middleware' => 'permission'],function(){  
                    
                            // template update/delete/create   ---- msa template
                            Route::get('/user/create-msa-template', [App\Http\Controllers\TemplateController::class, 'create_msa_template'])->name('user-create-msa-template');
                            Route::post('/user/store-msa-template', [App\Http\Controllers\TemplateController::class, 'store_msa_template'])->name('user-store-msa-template');
                             Route::get('/user/edit-msa-template/{id}', [App\Http\Controllers\TemplateController::class, 'edit_msa_template'])->name('user-edit-msa-template');
                            Route::post('/user/update-msa-template', [App\Http\Controllers\TemplateController::class, 'update_msa_template'])->name('user-update-msa-template');
                            Route::get('/user/delete-msa-template/{id}', [App\Http\Controllers\TemplateController::class, 'delete_msa_template'])->name('user-delete-msa-template');
                           
                              // template update/delete/create   ---- project contract template
                            Route::get('/user/create-project-contract-template', [App\Http\Controllers\TemplateController::class, 'create_project_contract_template'])->name('user-create-project-contract-template');
                            Route::post('/user/store-project-contract-template', [App\Http\Controllers\TemplateController::class, 'store_project_contract_template'])->name('user-store-project-contract-template');
                            Route::get('/user/edit-project-contract-template/{id}', [App\Http\Controllers\TemplateController::class, 'edit_project_contract_template'])->name('user-edit-project-contract-template');
                            Route::post('/user/update-project-contract-template', [App\Http\Controllers\TemplateController::class, 'update_project_contract_template'])->name('user-update-project-contract-template');
                            Route::get('/user/delete-project-contract-template/{id}', [App\Http\Controllers\TemplateController::class, 'delete_project_contract_template'])->name('user-delete-project-contract-template');
                    
                          // add member of team  
                            Route::get('/user/team', [App\Http\Controllers\UserController::class, 'team'])->name('user-team');
                            Route::get('/user/create-member', [App\Http\Controllers\UserController::class, 'create_member'])->name('user-create-member');
                            Route::post('/user/store-member', [App\Http\Controllers\UserController::class, 'store_member'])->name('user-store-member');
                            Route::get('/user/edit-member/{id}', [App\Http\Controllers\UserController::class, 'edit_member'])->name('user-edit-member');
                            Route::post('/user/update-member', [App\Http\Controllers\UserController::class, 'update_member'])->name('user-update-member');
                            Route::get('/user/delete-member/{id}', [App\Http\Controllers\UserController::class, 'delete_member'])->name('user-delete-member');
                           
                        });

    
     // profile update
    Route::get('/user/edit/profile/{id}', [App\Http\Controllers\UserController::class, 'edit_profile'])->name('user-editprofile');
    Route::post('/user/update-profile', [App\Http\Controllers\UserController::class, 'update_profile'])->name('user-updateprofile');
         
    Route::get('/user/vendor-performance', [App\Http\Controllers\UserController::class, 'vendor_performance'])->name('user-vendor-performance');
});




Route::middleware(['auth','vendor'])->group(function () {
    Route::get('/vendor/dashboard', [App\Http\Controllers\VendorController::class, 'index'])->name('vendor-dashboard');
    
    
    // profile update
    Route::get('/vendor/edit/profile/{id}', [App\Http\Controllers\VendorController::class, 'edit_profile'])->name('vendor-editprofile');
    Route::post('/vendor/update-profile', [App\Http\Controllers\VendorController::class, 'update_profile'])->name('vendor-updateprofile');
         
         
    // all contract
    Route::get('/vendor/all-contracts', [App\Http\Controllers\VendorController::class, 'all_contracts'])->name('vendor-all-contracts');


     // workflow owner msa
     Route::get('/vendor/start-workflow/owner-msa/{ownermsaid}', [App\Http\Controllers\VendorController::class, 'owner_msa_start_workflow'])->name('vendor-owner-msa-start-workflow');
     Route::post('/vendor/save-workflow/owner-msa', [App\Http\Controllers\VendorController::class, 'owner_msa_save_workflow'])->name('vendor-owner-msa-save-workflow');


      // workflow vendor msa
     Route::get('/vendor/start-workflow/vendor-msa/{vendormsaid}', [App\Http\Controllers\VendorController::class, 'vendor_msa_start_workflow'])->name('vendor-vendormsa-start-workflow');
     Route::post('/vendor/save-workflow/vendor-msa', [App\Http\Controllers\VendorController::class, 'vendor_vendormsa_save_workflow'])->name('vendor-vendormsa-save-workflow');
     
     
      // workflow project contract owner
     Route::get('/vendor/start-workflow/project-contract-owner/{pcoid}', [App\Http\Controllers\VendorController::class, 'project_contract_owner_start_workflow'])->name('vendor-project-contract-owner-start-workflow');
     Route::post('/vendor/save-workflow/project-contract-owner', [App\Http\Controllers\VendorController::class, 'project_contract_owner_save_workflow'])->name('vendor-project-contract-owner-save-workflow');
     
     // workflow project contract vendor
     Route::get('/vendor/start-workflow/project-contract-vendor/{pcvid}', [App\Http\Controllers\VendorController::class, 'project_contract_vendor_start_workflow'])->name('vendor-project-contract-vendor-start-workflow');
     Route::post('/vendor/save-workflow/project-contract-vendor', [App\Http\Controllers\VendorController::class, 'project_contract_vendor_save_workflow'])->name('vendor-project-contract-vendor-save-workflow');
     
     
       // negotiation
     Route::post('/vendor/request/negotiation/vendor-msa', [App\Http\Controllers\VendorController::class, 'vendor_msa_request_negotiation'])->name('user-vendor-msa-request-negotiation');
     
     Route::post('/vendor/sendback/team/vendor-msa', [App\Http\Controllers\VendorController::class, 'vendor_msa_sendback_to_team'])->name('vendor-vendormsa-sendback-to -team');
     
    
    
});