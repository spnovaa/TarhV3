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

Route::get('/', function () {
    return redirect('home');
});
Route::get('/logout', 'Auth\LoginController@logout');
Route::post('/checkUserType', 'Auth\AjaxController@checkUserType');
Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home', 'LandingController@index')->name('home');
Route::post('/register', 'Auth\AjaxController@register')->name('safir.register');
Route::get('/terms1', 'TermsController@showTerms1')->name('terms1');
Route::get('/terms2', 'TermsController@showTerms2')->name('terms2');
Route::post('/getBaseInfo', 'HomeController@BaseInfo')->name('baseInfo');
Route::post('/getProfile', 'HomeController@getProfile')->name('getProfile');
Route::post('/sendProfile', 'HomeController@sendProfile')->name('sendProfile');
Route::post('/getAllShops', 'Safir\OrderController@getAllShops')->name('safir.get.all.shops');
Route::post('/getAllBooks', 'Safir\OrderController@getAllBooks')->name('safir.get.all.books');
Route::post('/sendOrder', 'Safir\OrderController@receiveOrder')->name('safir.send.order');
Route::post('/getOrder', 'Safir\OrderController@sendOrder')->name('safir.get.order');
Route::post('/getCustomerOrder', 'Safir\OrderController@sendCustomerOrder')->name('safir.get.customer.order');
Route::post('/getAllSafirShopOrders', 'Safir\OrderController@getAllSafirShopOrders')->name('get.all.safir.shop.orders');
Route::post('/getAllSafirCustomerOrders', 'Safir\OrderController@getAllSafirCustomerOrders')->name('get.all.safir.customer.orders');
Route::post('/confirmOrders', 'Safir\OrderController@confirmOrder')->name('safir.confirm.orders');
Route::post('/getInventory', 'Safir\OrderController@getInventory')->name('safir.get.inventory');
Route::post('/inquire', 'Safir\OrderController@inquire')->name('safir.inquire.nationalID');
Route::post('/sendInvoice', 'Safir\OrderController@receiveInvoice')->name('safir.receive.invoice');
Route::get('/resetPassword', 'Auth\ForgotPasswordController@index')->name('password.reset');
Route::post('/resetPassword', 'Auth\ForgotPasswordController@resetPassword')->name('password.reset.final');
Route::post('/resetPasswordAskCode', 'Auth\ForgotPasswordController@sendCode')->name('password.reset.send.code');
Route::post('/resetPasswordConfirmCode', 'Auth\ForgotPasswordController@confirmCode')->name('password.reset.confirm.code');

Route::prefix('admin')->group(function () {
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    Route::get('/', 'AdminController@index')->name('admin.dashboard');
    Route::post('/getNewResumes', 'Admin\ResumeController@getData')->name('admin.get.newResumes');
    Route::post('/getActiveResumes', 'Admin\ResumeController@getActiveData')->name('admin.get.activeResumes');
    Route::post('/getRejectedResumes', 'Admin\ResumeController@getRejectedData')->name('admin.get.rejected.resumes');
    Route::get('/getAllSafirResumesExcel', 'Admin\ResumeController@getAllSafirResumesExcel')->name('admin.get.all.safirs.excel');
    Route::get('/getActiveSafirResumesExcel', 'Admin\ResumeController@getActiveSafirResumesExcel')->name('admin.get.active.safirs.excel');
    Route::get('/getActiveSafirResumesExcel', 'Admin\ResumeController@getActiveSafirResumesExcel')->name('admin.get.active.safirs.excel');
    Route::get('/getNewSafirResumesExcel', 'Admin\ResumeController@getNewSafirResumesExcel')->name('admin.get.new.resumes.excel');

    Route::post('/getAllResumes', 'Admin\ResumeController@getAllData')->name('admin.get.allResumes');
    Route::post('/getResume', 'Admin\ResumeController@getResume')->name('admin.get.Resume');
    Route::post('/resumeVote', 'Admin\ResumeController@voteResume')->name('admin.vote.Resume');
    Route::post('/getAllBooks', 'Admin\BookController@getAllData')->name('admin.get.allBooks');
    Route::post('/updateBooksList', 'Admin\BookController@updateList')->name('admin.update.booksList');
    Route::post('/deleteBook', 'Admin\BookController@deleteBook')->name('admin.delete.book');

    Route::post('/getNewShopResumes', 'Admin\ResumeController@getShopData')->name('admin.get.newShopResumes');
    Route::post('/getAllShopResumes', 'Admin\ResumeController@getAllShopData')->name('admin.get.allShopResumes');
    Route::post('/getActiveShopResumes', 'Admin\ResumeController@getActiveShopData')->name('admin.get.active.shops');
    Route::post('/getRejectedShopResumes', 'Admin\ResumeController@getRejectedShopData')->name('admin.get.rejected.shops');
    Route::post('/getShopResume', 'Admin\ResumeController@getShopResume')->name('admin.get.ShopResume');
    Route::post('/shopResumeVote', 'Admin\ResumeController@voteShopResume')->name('admin.vote.ShopResume');

    Route::get('/getAllShopResumesExcel', 'Admin\ResumeController@getAllShopResumesExcel')->name('admin.get.all.shops.excel');
    Route::get('/getActiveShopResumesExcel', 'Admin\ResumeController@getActiveShopResumesExcel')->name('admin.get.active.shops.excel');
    Route::get('/getRejectedShopResumesExcel', 'Admin\ResumeController@getRejectedShopResumesExcel')->name('admin.get.rejected.shops.excel');
    Route::get('/getNewShopResumesExcel', 'Admin\ResumeController@getNewShopResumesExcel')->name('admin.get.new.shops.resumes.excel');

    Route::post('/getNewDistResumes', 'Admin\ResumeController@getDistData')->name('admin.get.newDistResumes');
    Route::post('/getDistResume', 'Admin\ResumeController@getDistResume')->name('admin.get.DistResume');
    Route::post('/distResumeVote', 'Admin\ResumeController@voteDistResume')->name('admin.vote.DistResume');

    Route::post('/getAllDistInvoices', 'Admin\OrderController@getAllOrders')->name('admin.get.all.dist.invoices');
    Route::post('/getAllSafirShopOrders', 'Admin\OrderController@getAllSafirShopOrders')->name('admin.get.all.safir.shop.orders');
    Route::post('/getAllCustomerOrders', 'Admin\OrderController@getAllCustomerOrders')->name('admin.get.all.customer.orders');
    Route::post('/getSafirShopOrder', 'Admin\OrderController@getSafirShopOrder')->name('admin.get.safir.shop.order');
    Route::post('/adminCustomerOrderShow', 'Admin\OrderController@sendCustomerOrder')->name('admin.get.customer.order');
    Route::post('/getCustomerAndSeller', 'Admin\OrderController@sendCustomerAndSeller')->name('admin.get.customer.seller');

    Route::post('/getSettings', 'Admin\SettingsController@getSettings')->name('admin.get.settings');
    Route::post('/saveSettings', 'Admin\SettingsController@saveSettings')->name('admin.save.settings');
    Route::post('/getDistributorOrder', 'Admin\OrderController@getDistributorOrder')->name('admin.get.distributor.order');

    Route::post('/getsafirStats', 'Admin\BookController@getUserStats')->name('admin.get.safir.stats');
    Route::get('/getShopDirectSellStatsExcel', 'Admin\StatsController@getShopDirectSellStatsExcel')->name('admin.shop.get.direct.sell.stats.excel');
    Route::post('/getShopDirectSellStats', 'Admin\StatsController@getShopDirectSellStats')->name('admin.shop.get.direct.sell.stats');

    Route::post('/getShopTotalSell', 'Admin\StatsController@getShopTotalSell');
    Route::get('/getShopsBooksSellStats', 'Admin\StatsController@getShopsBooksSellExcel');
    Route::get('/getShopsTotalSellStats', 'Admin\StatsController@getShopsTotalSellExcel');


});

Route::prefix('shop')->group(function () {
    Route::post('/register', 'Auth\AjaxController@shopRegister')->name('shop.register');
    Route::get('/login', 'Auth\ShopLoginController@showLoginForm')->name('shop.login');
    Route::post('/login', 'Auth\ShopLoginController@login')->name('shop.login.submit');
    Route::post('/getAllBooks', 'Shop\BookController@getAllData')->name('shop.get.allBooks');
    Route::post('/getDistInventory', 'Shop\BookController@getDistInventory')->name('shop.get.inventory');
    Route::post('/updateBooksList', 'Shop\BookController@updateList')->name('shop.update.booksList');
    Route::get('/', 'ShopController@index')->name('shop.dashboard');
    Route::post('/getShopBaseInfo', 'ShopController@ShopBaseInfo')->name('shop.baseInfo');
    Route::post('/getShopProfile', 'ShopController@getShopProfile')->name('get.shop.profile');
    Route::post('/sendShopProfile', 'ShopController@SendShopProfile')->name('send.shop.profile');
    Route::post('/getAllDists', 'ShopController@getAllDists')->name('safir.get.all.dists');

    Route::post('/sendOrders', 'ShopController@receiveOrders')->name('send.shop.orders');
    Route::post('/getAllOrders', 'Shop\OrderController@getAllOrders')->name('shop.get.all.orders');
    Route::post('/getAllSafirOrders', 'Shop\OrderController@getAllSafirOrders')->name('shop.get.all.safir.orders');
    Route::post('/getAllShopCustomerOrders', 'Shop\OrderController@getAllShopCustomerOrders')->name('get.all.shop.customer.orders');
    Route::post('/getCustomerOrder', 'Shop\OrderController@sendCustomerOrder')->name('shop.get.customer.order');
    Route::post('/getCustomerAndSeller', 'Shop\OrderController@sendCustomerAndSeller')->name('shop.get.customer.seller');
    Route::post('/getOrder', 'Shop\OrderController@getOrder')->name('shop.get.order');
    Route::post('/getSafirOrder', 'Shop\OrderController@getSafirOrder')->name('shop.get.safir.order');
    Route::post('/confirmOrders', 'Shop\OrderController@confirmOrder')->name('shop.confirm.order');
    Route::post('/confirmSafirOrders', 'Shop\OrderController@confirmSafirOrder')->name('shop.confirm.safir.order');

    Route::post('/getInventory', 'Shop\InventoryController@getInventory')->name('shop.get.inventory');
    Route::post('/updateInventory', 'Shop\InventoryController@updateList')->name('shop.update.inventory');

    Route::post('/inquire', 'Shop\OrderController@inquire')->name('shop.inquire.nationalID');

    Route::post('/sendInvoice', 'Shop\OrderController@receiveInvoice')->name('shop.receive.invoice');
    Route::post('/getShopAddNewBookSettings', 'Shop\OrderController@getShopAddNewBookSettings')->name('shop.get.add.book.settings');
    Route::post('/getShopDirectSellStats', 'Shop\InventoryController@getShopDirectSellStats')->name('shop.get.direct.sell.stats');
    Route::get('/getShopDirectSellStatsExcel', 'Shop\InventoryController@getShopDirectSellStatsExcel')->name('shop.get.direct.sell.stats.excel');


});

Route::prefix('distributor')->group(function () {
    Route::post('/register', 'Auth\AjaxController@distributorRegister')->name('distributor.register');
    Route::get('/login', 'Auth\DistributorLoginController@showLoginForm')->name('distributor.login');
    Route::post('/login', 'Auth\DistributorLoginController@login')->name('distributor.login.submit');
    Route::get('/', 'DistributorController@index')->name('distributor.dashboard');
    Route::post('/sendDistributorProfile', 'DistributorController@SendDistributorProfile')->name('send.dist.profile');
    Route::post('/getDistributorProfile', 'DistributorController@getDistributorProfile')->name('distributor.get.profile');
    Route::post('/getAllBooks', 'Distributor\BookController@getAllData')->name('distributor.get.allBooks');
    Route::post('/updateBooksList', 'Distributor\BookController@updateList')->name('distributor.update.booksList');
    Route::post('/getAllShops', 'Distributor\BookController@getAllShopData')->name('distributor.get.allShops');
    Route::post('/getAllOrders', 'Distributor\OrderController@getAllOrders')->name('distributor.get.allOrders');
    Route::post('/getOrder', 'Distributor\OrderController@getOrder')->name('distributor.get.order');
    Route::post('/confirmOrders', 'Distributor\OrderController@confirmOrder')->name('distributor.confirm.order');

});

