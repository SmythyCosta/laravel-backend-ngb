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
*/

// ====================== User ======================
Route::post('user-create', 'UserController@userCreate');
Route::post('user-login', 'UserController@login');
// route middleware jwt
Route::group(['middleware' => 'jwt.auth'], function () {
    Route::post('get-user', 'UserController@getAuthUser');
});
Route::post('user-passwordUpdate', 'UserController@passwordUpdate');
Route::post('user-profileUpdate', 'UserController@profileUpdate');
Route::get('all-user', 'UserController@allUser'); 
Route::post('get-user-data', 'UserController@getUserData'); 
Route::post('user-update', 'UserController@userUpdate');
Route::post('user-delete', 'UserController@userDelete');
Route::get('user-list-pdf','UserController@exportpdf');
Route::get('user-list-excel','UserController@downloadExcel'); 
Route::post('user-assing-role-data','UserController@getUserAssingRoleData'); 
Route::get('user-role-data','UserController@getAllMenu'); 
Route::post('add-user-role','UserController@addUserRole');


// ====================== Dashboard ======================
Route::get('get-all-total-count','DashboardController@getAllTotalCount');
Route::get('get-all-dashboard-data','DashboardController@getAllDashboardData');
Route::get('get-chart-data','DashboardController@getChartData');
Route::get('get-latestOrder','DashboardController@latestOrder');
Route::get('get-latestProduct','DashboardController@latestProduct');


// ====================== Customer ======================
Route::post('customer-save','CustomerControllers@customerSave');
Route::get('all-customer', 'CustomerControllers@allCustomer');
Route::post('get-customer','CustomerControllers@getCustomer');
Route::post('customer-update','CustomerControllers@update');
Route::post('get-customer-by-discount','CustomerControllers@getCustomerByDiscount');
Route::post('get-customer-info','CustomerControllers@getCustomerInfo');
Route::get('customer-list-pdf','CustomerControllers@exportpdf');
Route::get('customer-list-excel','CustomerControllers@downloadExcel');
Route::get('all-customer-list', 'CustomerControllers@allCustomerList');


// ====================== Category ======================
Route::get('get-all-category','CategoryController@getAllCategory');
Route::post('category-save','CategoryController@categorySave');
Route::post('get-category','CategoryController@getCategory');
Route::post('category-update','CategoryController@categoryUpdate');
Route::post('category-delete','CategoryController@categoryDelete');
Route::get('get-all-category-by-grid','CategoryController@getAllCategoryByGrid');
Route::post('get-cat-by-subCategory','CategoryController@getCatBySubCategory');
Route::post('subCategory-save','CategoryController@subCategorySave');
Route::post('get-subCategory','CategoryController@getSubCategory');
Route::post('subCategory-update','CategoryController@subCategoryUpdate');
Route::post('subCategory-delete','CategoryController@subCategoryDelete');
Route::get('get-subCategoryGridData','CategoryController@subCategoryGridData');


// ====================== Product ======================
Route::post('product-save','ProductController@productSave');
Route::get('all-product','ProductController@allProduct');
Route::post('get-product-details','ProductController@getProduct');
Route::post('product-update','ProductController@productUpdate');
Route::post('get-product-info','ProductController@getProductInfo');
Route::get('product-list-pdf','ProductController@exportpdf');
Route::get('product-list-excel','ProductController@downloadExcel');


// ====================== Supplier ======================
Route::get('get-all-supplier', 'SupplierController@getAllSupplier'); 
Route::post('supplier-save', 'SupplierController@supplierSave'); 
Route::post('get-supplier', 'SupplierController@getSupplier'); 
Route::post('supplier-update', 'SupplierController@supplierUpdate'); 
Route::post('get-supplier-info', 'SupplierController@getSupplierInfo'); 
Route::get('supplier-list-pdf','SupplierController@exportpdf');
Route::get('supplier-list-excel','SupplierController@downloadExcel'); 


// ====================== Purchase ======================
Route::get('get-all-purchasesProduct', 'PurchaseController@getAllPurchasesProduct'); 
Route::get('get-all-supplier-by-purchases', 'PurchaseController@getAllSupplier'); 
Route::post('get-productForPurchases', 'PurchaseController@getProductForPurchases'); 
Route::post('create-new-purchase', 'PurchaseController@createNewPurchase'); 
Route::get('get-all-purchases', 'PurchaseController@getAllPurchases'); 
Route::post('get-purchases-details', 'PurchaseController@getPurchasesDetails'); 
Route::post('get-purchases-invoice-details', 'PurchaseController@purchasesInvoiceDetails');
Route::post('purchases-payment-update', 'PurchaseController@purchasesPaymentUpdate');
Route::get('purchases-history-list-pdf','PurchaseController@exportpdf');
Route::get('purchases-history-list-excel','PurchaseController@downloadExcel'); 


// ====================== Damaged ======================
Route::post('damaged-product-save','DamagedProductController@productSave');
Route::get('all-damaged-product','DamagedProductController@allDamagedProduct');
Route::post('get-all-product-by-damaged','DamagedProductController@allProduct');
Route::post('get-damaged-product','DamagedProductController@getDamagedProduct');
Route::post('damaged-product-update','DamagedProductController@productUpdate');
Route::get('damaged-product-list-pdf','DamagedProductController@exportpdf');
Route::get('damaged-product-list-excel','DamagedProductController@downloadExcel');


// ====================== Sales ======================
Route::post('get-categoryByProduct','SalesController@getCategoryByProduct');
Route::post('create-new-sales', 'SalesController@createNewSales');
Route::get('get-all-sales', 'SalesController@getAllSales');
Route::post('get-invoice-details', 'SalesController@getInvoiceDetails');
Route::post('sales-take-payment', 'SalesController@salesTakePayment');
Route::get('sales-history-list-pdf','SalesController@exportpdf');
Route::get('sales-history-list-excel','SalesController@downloadExcel'); 


// ====================== Order ======================
Route::get('get-all-product-by-order', 'OrderController@getAllProductByOrder');
Route::post('create-new-order', 'OrderController@createNewOrder');
Route::post('get-all-order', 'OrderController@getAllOrder');
Route::post('get-order-invoice-details', 'OrderController@getInvoiceDetails');
Route::post('order-invoice-update', 'OrderController@invoiceUpdate');
Route::get('order-history-list-pdf','OrderController@exportpdf');
Route::get('order-history-list-excel','OrderController@downloadExcel'); 


// ====================== Setting ======================
Route::get('get-setting-data', 'SettingController@getSetting');
Route::post('setting-data-update', 'SettingController@settingUpdate');
Route::get('get-all-menu', 'SettingController@getMenu');
Route::post('check-user-permission', 'SettingController@checkPermission');


// ====================== Report ======================
Route::post('get-sales-report-data', 'ReportController@getSalesReportData');
Route::get('sales-report-excel', 'ReportController@salesReportDownloadExcel');
Route::get('sales-report-pdf', 'ReportController@salesReportExportPdf');
Route::post('get-purchase-report-data', 'ReportController@getPurchaseReportData');
Route::get('purchase-report-excel', 'ReportController@purchaseReportDownloadExcel');
Route::get('purchase-report-pdf', 'ReportController@purchaseReportExportPdf');
Route::post('get-order-report-data', 'ReportController@getOrderReportData');
Route::get('order-report-excel', 'ReportController@orderReportDownloadExcel');
Route::get('order-report-pdf', 'ReportController@orderReportExportPdf');


// ====================== Passport ======================
Route::post('oauth/token', '\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken');
