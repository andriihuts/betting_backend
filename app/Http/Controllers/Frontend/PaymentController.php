<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Splitter;
use App\Models\NewBet;
use App\Models\NetIRC;
use App\Models\Transaction;
use App\Models\Currency;
use Carbon\Carbon;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function __construct()
    {
        // Applying middleware to all actions within the controller
        // $this->mValue = config('cors.m_value');        
        // $this->rValue = config('cors.r_value');
        $currency = Currency::first();

        if ($currency) {
            // Set the m_value and r_value from the database
            $this->mValue = $currency->m_rate;
            $this->rValue = $currency->r_rate;
        } else {            
            $this->mValue = 0.2;
            $this->rValue = 0.015;
        }
    }
    // show new new IRC money
    public function showIRCMoney(){               
        return view('irc');
    }

    // show new Misc
    public function showMisc(){               
        return view('misc');
    }

    // set new Misc
    public function storeMisc(Request $request){
        // Validate request data
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric',
        ], [
            'required' => 'The :attribute field is required.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'Fail',
                'message' => $validator->errors()->all(),
            ]);
        }

        // Retrieve the latest NetIRC record or initialize values if none exists
        $prev_netMoney = NetIRC::latest('id')->first();
        $temp_val_net = $prev_netMoney->net ?? 0;
        $temp_val_irc = $prev_netMoney->irc ?? 0;

        // Determine multiplier and currency symbol based on money type
        $amount = (float)$request->amount;
        $multiplier = match ((int)$request->money_type) {
            2 => $this->mValue, // Game money
            3 => $this->rValue, // RS3 money
            default => 1,       // Default (perfect money)
        };
        $money_symbol = match ((int)$request->money_type) {
            2 => 'm',
            3 => 'r',
            default => '$',
        };

        // Calculate new net value, leaving IRC unchanged
        $new_net = round($temp_val_net + $amount * $multiplier, 2);

        // Save the new NetIRC record
        $newMoneySaved = NetIRC::create([
            'net' => $new_net,
            'irc' => round($temp_val_irc, 2),
        ]);

        // Determine transaction description based on amount
        $description_action = $amount > 0 ? 'added to' : 'subtracted from';
        $description = abs($amount) . $money_symbol . " $description_action NET";

        // Create and save the transaction record
        $transaction_saved = Transaction::create([
            'customer_name' => 'empty',
            'amount' => round($amount, 2),
            'type_money' => 0,
            'type_net' => 1, // Misc
            'description' => $description,
        ]);

        // Return JSON response based on save success
        return response()->json([
            'status' => $transaction_saved && $newMoneySaved ? true : false,
            'message' => $transaction_saved && $newMoneySaved ? 'Ok' : 'failed',
        ]);       
    }

    /**
     * Store a newly created new net money and IRC in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeIRCMoney(Request $request)
    {
        // Validate request data
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric',
        ], [
            'required' => 'The :attribute field is required.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->all(),
            ]);
        }

        // Retrieve the latest NetIRC record or initialize values
        $prev_netMoney = NetIRC::latest('id')->first();
        $temp_val_net = $prev_netMoney->net ?? 0;
        $temp_val_irc = $prev_netMoney->irc ?? 0;

        // Calculate the new net and IRC values based on money type
        $amount = (float)$request->amount;
        $multiplier = match ((int)$request->money_type) {
            2 => $this->mValue, // OSRS money
            3 => $this->rValue, // RS3 money
            default => 1,       // Default multiplier
        };

        $new_net = round($temp_val_net + $amount * $multiplier, 2);
        $new_irc = round($temp_val_irc + $amount * $multiplier, 2);

        // Create and save the new NetIRC record
        $newMoney = NetIRC::create([
            'net' => $new_net,
            'irc' => $new_irc,
        ]);

        // Prepare transaction data based on money type
        $symbols = [1 => '$', 2 => 'm', 3 => 'r'];
        $money_symbol = $symbols[$request->money_type] ?? '$';
        $description_action = $amount > 0 ? 'added to' : 'subtracted from';

        // Create and save the transaction record
        $transaction_saved = Transaction::create([
            'customer_name' => 'empty',
            'amount' => round($amount, 2),
            'type_money' => 0,
            'type_net' => 0,
            'description' => abs($amount) . $money_symbol . " $description_action NET and IRC",
        ]);

        // Return success response if transaction saved, otherwise fail
        return response()->json([
            'status' => $transaction_saved ? true : false,
            'message' => $transaction_saved ? 'Ok' : 'failed',
        ]);
    }
    
    // show transaction history
    public function showTransaction(){          
        $today = Carbon::today();

        // 1. Fetch today's transactions or at least the newest 10 from today
        $todayTransactions = Transaction::whereDate('created_at', $today)
            ->latest()
            ->take(10)
            ->get();
    
        // Format the 'created_at' for each transaction
        $todayTransactions->each(function ($transaction) {
            $transaction->formatted_created_at = Carbon::parse($transaction->created_at)->format('d F Y, \a\t h:i A');
        });
    
        // If less than 10 transactions exist today, fill with the newest transactions until the total is 10
        if ($todayTransactions->count() < 10) {
            $additionalTransactions = Transaction::where('created_at', '<', $today->endOfDay())
                ->latest()
                ->take(10 - $todayTransactions->count())
                ->get();
    
            $additionalTransactions->each(function ($transaction) {
                $transaction->formatted_created_at = Carbon::parse($transaction->created_at)->format('d F Y, \a\t h:i A');
            });
    
            $todayTransactions = $additionalTransactions;
        }

        // 2. Fetch yesterday's transaction history
        $yesterday = Carbon::yesterday();
        $yesterdayTransactions = Transaction::whereDate('created_at', $yesterday)
            ->latest()
            ->take(10)
            ->get();

        // Format the 'created_at' for each transaction
        $yesterdayTransactions->each(function ($transaction) {
            $transaction->formatted_created_at = Carbon::parse($transaction->created_at)->format('d F Y, \a\t h:i A');
        });

        // If less than 10 transactions exist yesterday, fill with the newest transactions from before yesterday
        if ($yesterdayTransactions->count() < 10) {
            $additionalYesterdayTransactions = Transaction::where('created_at', '<', $yesterday->endOfDay())
                ->latest()
                ->take(10 - $yesterdayTransactions->count())
                ->get();

            $additionalYesterdayTransactions->each(function ($transaction) {
                $transaction->formatted_created_at = Carbon::parse($transaction->created_at)->format('d F Y, \a\t h:i A');
            });

            $yesterdayTransactions = $additionalYesterdayTransactions;
        }

        // 3. Count total transaction history
        $totalTransactionsCount = Transaction::count();
        $totalTransactions = Transaction::latest()->take(20)->get();

        // Format the 'created_at' for each transaction
        $totalTransactions->each(function ($transaction) {
            $transaction->formatted_created_at = Carbon::parse($transaction->created_at)->format('d F Y, \a\t h:i A');
        });

        // Return data
        return view('transaction', compact('todayTransactions', 'yesterdayTransactions', 'totalTransactions'));
    }    
}
