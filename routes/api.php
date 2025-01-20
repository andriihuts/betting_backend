<?php

use App\Http\Controllers\DataController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\NewBetController;
use App\Http\Controllers\SplitterController;
use App\Http\Controllers\CurrencyController;

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

Route::group(['middleware' => 'set.database'], function () {
    Route::get('/test', [CustomerController::class, 'getTest']);    
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/home', [CustomerController::class, 'getHome']);  // get the all customers' data
Route::get('/hometest', [CustomerController::class, 'getTestHome']);  

//new customers
Route::get('/all_customers', [CustomerController::class, 'getCustomers']);  // get the all customers' data
Route::get('/getCustomers', [CustomerController::class, 'getCustomerNames']);  // get the all customers' names data

//Get splitters
Route::get('/all_splitters', [CustomerController::class, 'getSplitters']);  // get the all splitters' data
Route::get('/all_customer_splitters', [CustomerController::class, 'getCustomerAndSplitterData']);  // get the all customer' data and splitters

Route::post('/customer/store', [CustomerController::class, 'store']);  // register new customers  
Route::post('/customer/update', [CustomerController::class, 'update']);  // update the customer
Route::post('/customer/update_newMoney', [CustomerController::class, 'update_newMoney']);  // update the transaction history of tab detail.

Route::post('/customer/destroy', [CustomerController::class, 'destroy']);  // remove the customer
Route::get('customers/{bet_customer}', [CustomerController::class, 'singleCustomer']);//diplay single customer

//Get all transaction history
Route::get('/all_transactions', [CustomerController::class, 'getTransactions']);  // get the all transactions' data

//IRC set
Route::post('/customers/storeIRCMoney', [CustomerController::class, 'storeIRCMoney']);  // set new new IRC money
Route::post('/customers/storeMisc', [CustomerController::class, 'storeMisc']);  // set new GiveAways

//new bets
Route::get('/all_bets/{active}', [NewBetController::class, 'getBets']);  // get the all bet' data
Route::get('new_bets/all_bets/{bet_customer}', [NewBetController::class, 'singleBet']);//diplay single bet

//game status 1: win, 0: lose, 2: void
Route::post('/new_bets/{active_user}/updateStatus/', [NewBetController::class, 'updateStatus']);  // update the the bet
Route::post('/new_bets/{bet_id}/updateActiveBet', [NewBetController::class, 'updateActiveBet']);  // update the the active bet

Route::post('/new_bets/store', [NewBetController::class, 'store'])->middleware('throttle:200,1'); ;  // register new new bet
Route::post('/new_bets/update', [NewBetController::class, 'update']);  // update the the bet
Route::delete('/new_bets/destroy', [NewBetController::class, 'destroy']);  // remove the the bet

Route::get('/customer_sum_net', [NewBetController::class, 'getSumNet']);  // get total net amount

//splitters 
Route::post('/splitters/store', [SplitterController::class, 'store']);  // register new splitters

//currency rate
Route::get('/currency/rate', [CurrencyController::class, 'getCurrencyRate']);  // get currency rate
Route::post('/currency_rate/{type}', [CurrencyController::class, 'update_rate']);  // update the currency rate