<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\CustomerController;
use App\Http\Controllers\Frontend\CurrencyController;
use App\Http\Controllers\Frontend\NewBetController;
use App\Http\Controllers\Frontend\SplitterController;

use App\Http\Controllers\Frontend\TabController;
use App\Http\Controllers\Frontend\PaymentController;
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


Route::group(['namespace' => 'Frontend'], function () {
    Route::get('/', [HomeController::class, 'index'])->name('dashboard');    
    Route::get('dashboard', [HomeController::class, 'index'])->name('dashboard');                                       // get the home page's all data
    
    // Bet Routes
    Route::get('new_bet', [NewBetController::class, 'index'])->name('bet_new');                                         // show new bet page
    Route::post('new_bet/store', [NewBetController::class, 'store'])->name('bet_store');                                // create new bet    
    Route::get('all_bets/active_bet/{bet_type}', [NewBetController::class, 'getBets'])->name('bet_list');               // get the active bet' data
    //Route::get('all_bets/settled', [NewBetController::class, 'showSettledBets'])->name('bet_settled');                // get the settled bet' data
    Route::get('all_bets/singleBet/{bet_id}/{bet_type}', [NewBetController::class, 'singleBet'])->name('bet_single');                //diplay single bet
    Route::get('all_bets/{bet_id}/singleBet/show', [NewBetController::class, 'showActiveBet'])->name('bet_edit');              // Show Edit bet page        
    Route::post('all_bets/{bet_id}/singleBet/update', [NewBetController::class, 'updateActiveBet'])->name('bet_update_active');    // update Edit bet page    
    Route::post('all_bets/{bet_id}/singleBet/destory', [NewBetController::class, 'destory'])->name('bet_destory');               // delete the the bet    
    Route::post('all_bets/{bet_id}/singleBet/updateStatus/', [NewBetController::class, 'updateStatus'])->name('bet_update_status');// update the the bet--game status 1: win, 0: lose, 2: void        

    // Tabs Routes
    Route::get('tabs', [TabController::class, 'index'])->name('tabs');                                                  // show the tabs page.
    Route::post('tabs/{tab_id}/update', [TabController::class, 'update'])->name('tab_update');                          // update the tab
    Route::delete('settled_bet', [TabController::class, 'destory'])->name('tab_destory');                               // remove the tab

    // Customer Routes    
    Route::get('customers', [CustomerController::class, 'index'])->name('customers_all');                               // show the customer page
    Route::post('customer/store', [CustomerController::class, 'store'])->name('customer_store');                        // register new customer    
    Route::post('/customer/update', [CustomerController::class, 'update'])->name('customer_update');                    // update the customer
    Route::post('customer/destory', [CustomerController::class, 'destory'])->name('customer_destory');                  // remove the customer
    Route::post('customer/updateCustomerMoney', [CustomerController::class, 'update'])->name('customer_update_money');  // update the customer money data        
    Route::get('customers/{customer_id}', [CustomerController::class, 'singleCustomer'])->name('customer_show_single'); //diplay single customer    

    
    // Routes related to the Payment
    Route::get('payment/storeIRCMoney', [PaymentController::class, 'showIRCMoney'])->name('payment_get_irc');           // show new new IRC money
    Route::post('payment/storeIRCMoney', [PaymentController::class, 'storeIRCMoney'])->name('payment_store_irc');       // set new new IRC money
    Route::get('payment/storeMisc', [PaymentController::class, 'showMisc'])->name('payment_get_misc');                  // show new Misc
    Route::post('payment/storeMisc', [PaymentController::class, 'storeMisc'])->name('payment_store_misc');              // set new Misc
    Route::get('transaction', [PaymentController::class, 'showTransaction'])->name('payment_transaction');              // show the transaction page  

    // splitters routes
    Route::get('all_splitters', [SplitterController::class, 'getSplitters'])->name('misc');                             // get the all splitters' data
    Route::get('all_customer_splitters', [SplitterController::class, 'getCustomerAndSplitterData'])->name('customer_splitter_data');      // get the all customer' data and splitters

    // Currency routes
    Route::get('currency/rate', [CurrencyController::class, 'getCurrencyRate'])->name('currency_all');                  // show currency rate page
    Route::post('currency_rate/{type}', [CurrencyController::class, 'update_rate'])->name('currency_store_type');        // update the currency rate
    Route::get('currencies', [CurrencyController::class, 'showCurrencies'])->name('currency_get_data');                 // get the currency data
});
