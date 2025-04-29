<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\CustomerController;
use App\Http\Controllers\Frontend\CurrencyController;
use App\Http\Controllers\Frontend\NewBetController;
use App\Http\Controllers\Frontend\SplitterController;
use App\Http\Controllers\Frontend\CoinController;
use App\Http\Controllers\Frontend\WebsiteController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\Frontend\TabController;
use App\Http\Controllers\Frontend\PaymentController;
use App\Http\Controllers\AuthController;
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
// Auth routes (without auth middleware)
Route::controller(AuthController::class)->group(function() {
    // Route::get('/register', 'register')->name('register');
    Route::post('/store', 'store')->name('store');
    Route::get('/login', 'login')->name('login');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
    Route::post('/logout', 'logout')->name('logout');
});

// Group all protected routes inside the auth middleware
Route::middleware(['auth'])->group(function () {
    Route::group(['namespace' => 'Frontend'], function () {
        Route::get('/', [HomeController::class, 'index'])->name('dashboard');    
        Route::get('dashboard', [HomeController::class, 'index'])->name('dashboard');

        // Bet Routes
        Route::get('new_bet', [NewBetController::class, 'index'])->name('bet_new');
        Route::post('new_bet/store', [NewBetController::class, 'store'])->name('bet_store');
        Route::get('all_bets/active_bet/{bet_type}', [NewBetController::class, 'getBets'])->name('bet_list');
        Route::get('all_bets/singleBet/{bet_id}/{bet_type}', [NewBetController::class, 'singleBet'])->name('bet_single');
        Route::get('all_bets/{bet_id}/singleBet/show', [NewBetController::class, 'showActiveBet'])->name('bet_edit');
        Route::post('all_bets/{bet_id}/singleBet/update', [NewBetController::class, 'updateActiveBet'])->name('bet_update_active');
        Route::post('all_bets/{bet_id}/singleBet/destory', [NewBetController::class, 'destory'])->name('bet_destory');
        Route::post('all_bets/{bet_id}/singleBet/updateStatus/', [NewBetController::class, 'updateStatus'])->name('bet_update_status');

        // Tabs Routes
        Route::get('tabs', [TabController::class, 'index'])->name('tabs');
        Route::post('tabs/{tab_id}/update', [TabController::class, 'update'])->name('tab_update');
        Route::delete('settled_bet', [TabController::class, 'destory'])->name('tab_destory');

        // Customer Routes    
        Route::get('customers', [CustomerController::class, 'index'])->name('customers_all');
        Route::post('customer/store', [CustomerController::class, 'store'])->name('customer_store');
        Route::post('/customer/update', [CustomerController::class, 'update'])->name('customer_update');
        Route::post('customer/destory', [CustomerController::class, 'destory'])->name('customer_destory');
        Route::post('customer/updateCustomerMoney', [CustomerController::class, 'update'])->name('customer_update_money');
        Route::get('customers/{customer_id}', [CustomerController::class, 'singleCustomer'])->name('customer_show_single');

        // Payment Routes
        Route::get('payment/storeIRCMoney', [PaymentController::class, 'showIRCMoney'])->name('payment_get_irc');
        Route::post('payment/storeIRCMoney', [PaymentController::class, 'storeIRCMoney'])->name('payment_store_irc');
        Route::get('payment/storeMisc', [PaymentController::class, 'showMisc'])->name('payment_get_misc');
        Route::post('payment/storeMisc', [PaymentController::class, 'storeMisc'])->name('payment_store_misc');
        Route::get('transaction', [PaymentController::class, 'showTransaction'])->name('payment_transaction');

        // Splitters Routes
        Route::get('all_customer_splitters', [SplitterController::class, 'getCustomerAndSplitterData'])->name('customer_splitter_data');

        // Currency Routes
        Route::get('currency/rate', [CurrencyController::class, 'getCurrencyRate'])->name('currency_all');
        Route::post('currency_rate/{type}', [CurrencyController::class, 'update_rate'])->name('currency_store_type');
        Route::get('currencies', [CurrencyController::class, 'showCurrencies'])->name('currency_get_data');

        // Coins Routes    
        Route::get('coins', [CoinController::class, 'index'])->name('coins');
        Route::post('coins/store', [CoinController::class, 'store'])->name('coin_store');
        Route::post('coins/update', [CoinController::class, 'update'])->name('coin_update');
        Route::post('coins/destory', [CoinController::class, 'destory'])->name('coin_destory');
        Route::get('coins/{coin_id}', [CoinController::class, 'singleCoin'])->name('coin_show_single');

        // Websites Routes  
        Route::get('websites', [WebsiteController::class, 'index'])->name('websites');
        Route::post('websites/store', [WebsiteController::class, 'store'])->name('website_store');
        Route::post('websites/update', [WebsiteController::class, 'update'])->name('website_update');
        Route::post('websites/destory', [WebsiteController::class, 'destory'])->name('website_destory');
        Route::get('websites/{website_id}', [WebsiteController::class, 'singleWebsite'])->name('website_show_single');

        // File Upload
        Route::post('/upload', [FileController::class, 'upload'])->name('upload');
    });
});