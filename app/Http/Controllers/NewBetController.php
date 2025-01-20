<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\NewBet;
use App\Models\Splitter;
use App\Models\User;
use App\Models\NetIRC;
use App\Models\Currency;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Validator;
use DB;

class NewBetController extends Controller
{
    protected $mValue, $rValue;
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
    //
    public function getBets(Request $request, $active)
    {        
        // Fetch bets with related data using eager loading
        if($active == 3) // active bet
            $all_active_Bets = NewBet::where('status', $active)->orderBy('updated_at', 'desc')->get();
        else  // win, lose, void status: 0, 1, 2
            $all_active_Bets = NewBet::whereIn('status', [0,1])->orderBy('updated_at', 'desc')->get();

        $active_json_data = [];

        foreach ($all_active_Bets as $key => $active_bet) {
            // Calculate total amount for all splitters of the bet
            $splitter_amount_total = $active_bet->bet_splitters->sum('amount');
            $real_money = (float)$active_bet->amount - $splitter_amount_total;

            // Determine currency multiplier based on the currency type
            // $multiplier = match ($active_bet->currency) {
            //     'm-(OSRS)' => $this->mValue,
            //     'r-(RS3)' => $this->rValue,
            //     'c-(CAD)' => 0.75,
            //     default => 1
            // };
            $multiplier = $active_bet->rate;
            // Calculate net profit based on the bet's status and live state
            $netProfit = match (true) {
                $active_bet->live == 1 && $active_bet->status == 1 => round($real_money * $multiplier, 2),
                // $active_bet->live == 1 && $active_bet->status == 0 => round((($real_money * $active_bet->odds * 0.95 - $real_money) * $multiplier) * -1, 2),
                $active_bet->live == 1 && $active_bet->status == 0 => round(($real_money * ($active_bet->odds - 1) * -1) * $multiplier, 2),
                $active_bet->live == 0 && $active_bet->status == 1 => round($real_money * $multiplier, 2),
                $active_bet->live == 0 && $active_bet->status == 0 => round(($real_money * ($active_bet->odds - 1) * -1) * $multiplier, 2),
                default => 0,
            };

            // Prepare splitter data
             $splitter_data = $active_bet->bet_splitters->map(fn($splitter) => [
                'name' => optional($splitter->customer)->name ?? 'unknown',
                'amount' => $splitter->amount,
            ]);

            // Build the active bet data
            $active_json_data[$key] = [
                'id' => $active_bet->id,
                'slip' => $active_bet->slip,
                'odds' => round($active_bet->odds, 2),
                'live' => (int)$active_bet->live,
                'amount' => $active_bet->amount,
                'customer_name' => optional($active_bet->customer)->name ?? 'unknown customer',
                'currency' => $active_bet->currency,
                'created_at' => $active_bet->created_at,
                'netProfit' => $netProfit,
                'arrSplitters' => $splitter_data
            ];
        }

        return response()->json([$active_json_data]);
    }

    /**
     * Store a newly created bet in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'slip' => 'required|max:255',
    //         'odds' => 'required|max:255',
    //         'amount' => 'required',
    //         'currency' => 'required'
    //     ], $messages = [
    //         'required' => 'The :attribute field is required.',
    //         'unique' => 'The :attribute field should be unique.',
    //         'max' => 'The :attribute field should be maximum 255.'
    //     ]);
    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status'=>false,
    //             'message'=>$validator->errors()->all(),
    //         ]);
    //     }
    //     $requestData = $request->all();
        
    //     switch ($requestData['currency']) {
    //         case 'm-(OSRS)':
    //             $multiplier = $this->mValue;
    //             break;
    //         case 'c-(CAD)':
    //             $multiplier = 0.75;
    //             break;
    //         case 'r-(RS3)':
    //             $multiplier = $this->rValue;
    //             break;
    //         default:
    //             $multiplier = 1;
    //             break;
    //     }
        
    //     $requestData['rate'] = $multiplier; // Add the multiplier as the rate
    //     $temp = NewBet::create($requestData);
    //     Log::info('new bet request data>>>>>', ['requestData' => $requestData, 'create status' => $temp]);

    //     if ($request->has('splitters1') && is_array($request->splitters1)) {
    //         $splits = $request->splitters1;

    //         foreach($splits as $split){
    //             $splitter = new Splitter;
    //             $splitter->customer_id = $split['customer_id'];
    //             $splitter->amount = $split['amount'];
    //             $splitter->new_bets_id = NewBet::latest()->first()->id;
    //             $splitter->save();
    //         }
    //     }
    //     return response()->json([
    //         'status'=>true,
    //         'message'=>'Ok'
    //     ]);
    // }
    
    public function store(Request $request)
    {
        // Define validation rules and custom messages
        $validator = Validator::make($request->all(), [
            'slip' => 'required|max:255',
            'odds' => 'required|max:255',
            'amount' => 'required',
            'currency' => 'required'
        ], $messages = [
            'required' => 'The :attribute field is required.',
            'unique' => 'The :attribute field should be unique.',
            'max' => 'The :attribute field should be maximum 255.'
        ]);

        // Return validation errors if validation fails
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->all(),
            ], 422);
        }

        // Start a database transaction
        DB::beginTransaction();
        try {
            $requestData = $request->all();

            // Determine multiplier based on currency
            $multiplier = match ($requestData['currency']) {
                'm-(OSRS)' => $this->mValue,
                'c-(CAD)' => 0.75,
                'r-(RS3)' => $this->rValue,
                default => 1,
            };

            $requestData['rate'] = $multiplier;

            // Create the new bet
            $newBet = NewBet::create($requestData);

            // If splitters exist, validate and save them
            if ($request->has('splitters1') && is_array($request->splitters1)) {
                $splitters = collect($request->splitters1);

                // Map through each splitter and save it
                $splitters->each(function ($split) use ($newBet) {
                    Splitter::create([
                        'customer_id' => $split['customer_id'],
                        'amount' => $split['amount'],
                        'new_bets_id' => $newBet->id,
                    ]);
                });
            }

            // Commit the transaction
            DB::commit();

            // Log successful creation
            Log::info('New bet created successfully', ['bet' => $newBet]);

            return response()->json([
                'status' => true,
                'message' => 'New bet created successfully.',
            ]);
        } catch (\Exception $e) {
            // Rollback transaction in case of an error
            DB::rollBack();

            // Log the error
            Log::error('Failed to create new bet', ['error' => $e->getMessage()]);

            return response()->json([
                'status' => false,
                'message' => 'An error occurred while processing your request.',
            ], 500);            
        }
    }

    /**
     * Update the specified bet in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\NewBet  $newBet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->id;
        $update_bet = NewBet::where('id', $id)->first();

        if($update_bet==null && empty($update_bet)){
            return response()->json([
                'status'=>false,
                'message'=>'it can\'t be updated.',
            ]);
        }

        $update_bet->update($request->all());

        return response()->json([
            'status'=>true,
            'message'=>'Ok'
        ]);
    }
    
    public function updateStatus(Request $request, $bet_id)
    {
        $status = $request->status;

        // Retrieve the active bet with related data
        $update_active_bet = NewBet::with(['bet_splitters', 'customer'])->find($bet_id);

        // Check if the bet exists
        if (!$update_active_bet) {
            return response()->json([
                'status' => false,
                'message' => "Bet with ID $bet_id can't be updated.",
            ]);
        }

        // Update bet status
        $update_active_bet->update(['status' => $status]);

        $betSplitters = $update_active_bet->bet_splitters;
        $profitAmount = 0;        
        // Update each splitter's customer balance based on profit/loss
        $betSplitters->each(function ($betSplitter) use ($update_active_bet, &$profitAmount) {
            $update_customer = Customer::find($betSplitter->customer_id);            
            // Determine profit/loss amount based on live status and bet result
            $profitAmount = match (true) {
                $update_active_bet->live && $update_active_bet->status == 1 => -1 * $betSplitter->amount, // win
                //$update_active_bet->live && $update_active_bet->status == 0 => round($betSplitter->amount * $update_active_bet->odds * 0.95 - $betSplitter->amount, 2), // lose
                $update_active_bet->live && $update_active_bet->status == 0 => round($betSplitter->amount * ($update_active_bet->odds - 1), 2), // lose
                !$update_active_bet->live && $update_active_bet->status == 1 => -1 * $betSplitter->amount, // win
                !$update_active_bet->live && $update_active_bet->status == 0 => round($betSplitter->amount * ($update_active_bet->odds - 1), 2), // lose
                default => 0,
            };            
            // Update customer's balance based on currency type
            $currencyField = match ($update_active_bet->currency) {
                'a-(applepay)' => 'a_apply_pay',
                'b-(bitcoin)' => 'b_bitcoin',
                'e-(ethereum)' => 'e_ethereum',
                'c-(CAD)' => 'c_card',
                'u-(usdt)' => 'u_usdt',
                'm-(OSRS)' => 'm_game_currency',
                'r-(RS3)' => 'r_rs3',
                default => null,
            };
            
            if ($currencyField && $update_customer) {
                $update_customer->increment($currencyField, $profitAmount);
            }
        });

        // Calculate total splitter money and real amount
        $splitter_amount_total = $betSplitters->sum('amount');
        $real_amount = $update_active_bet->amount - $splitter_amount_total;

        // Calculate single_perfect_money based on currency and status
        // $multiplier = match ($update_active_bet->currency) {
        //     'm-(OSRS)' => $this->mValue,
        //     'r-(RS3)' => $this->rValue,
        //     'c-(CAD)' => 0.75,
        //     default => 1,
        // };
        $multiplier = $update_active_bet->rate;

        $single_perfect_money = match (true) {
            // $update_active_bet->live && $update_active_bet->status == 1 => round($real_amount * $multiplier, 2), // win
            // //$update_active_bet->live && $update_active_bet->status == 0 => round(($real_amount * $update_active_bet->odds * 0.95 - $real_amount) * -1 * $multiplier, 2), // lose
            // $update_active_bet->live && $update_active_bet->status == 0 => round(($real_amount * ($update_active_bet->odds - 1)) * -1 * $multiplier, 2), // lose
            // !$update_active_bet->live && $update_active_bet->status == 1 => round($real_amount * $multiplier, 2), // win
            // !$update_active_bet->live && $update_active_bet->status == 0 => round(($real_amount * ($update_active_bet->odds - 1)) * -1 * $multiplier, 2), // lose

            $update_active_bet->live && $update_active_bet->status == 1 => round($real_amount, 2), // win
            //$update_active_bet->live && $update_active_bet->status == 0 => round(($real_amount * $update_active_bet->odds * 0.95 - $real_amount) * -1 * $multiplier, 2), // lose
            $update_active_bet->live && $update_active_bet->status == 0 => round(($real_amount * ($update_active_bet->odds - 1)) * -1, 2), // lose
            !$update_active_bet->live && $update_active_bet->status == 1 => round($real_amount, 2), // win
            !$update_active_bet->live && $update_active_bet->status == 0 => round(($real_amount * ($update_active_bet->odds - 1)) * -1, 2), // lose

            default => 0,
        };
         
        // Update the main customer's balance with the single_perfect_money
        $cur_customer = $update_active_bet->customer;                
        if ($cur_customer) {
            $main_currency_field = match ($update_active_bet->currency) {
                'a-(applepay)' => 'a_apply_pay',
                'b-(bitcoin)' => 'b_bitcoin',
                'e-(ethereum)' => 'e_ethereum',
                'c-(CAD)' => 'c_card',
                'u-(usdt)' => 'u_usdt',
                'm-(OSRS)' => 'm_game_currency',
                'r-(RS3)' => 'r_rs3',
                default => null,
            };            
            if ($main_currency_field) {
                $cur_customer->increment($main_currency_field, $single_perfect_money);
            }
        }

        
        // Update net IRC values
        $latest_net_money = NetIRC::latest('created_at')->first();        
        NetIRC::create([
            'net' => round($single_perfect_money * $multiplier  + ($latest_net_money->net ?? 0), 2),
            'irc' => $latest_net_money->irc ?? 0,
        ]);
        $latest_net_money = NetIRC::latest('created_at')->first();        
        return response()->json([
            'status' => true,
            'message' => 'Ok',
            'profitAmount' => $profitAmount,
            'currency' => $update_active_bet->currency,
            'single_perfect_money' => $single_perfect_money,
        ]);
    }

    public function singleBet($bet_id)
    {
        // Load the bet with related data        
        $singBet = NewBet::where('id', $bet_id)->first();        
        // Check if bet exists
        if (!$singBet) {
            return response()->json([
                'status' => false,
                'message' => "Bet with ID $bet_id can't be found.",
            ]);
        }

        // Calculate total amount for all splitters
        $splitter_amount_total = $singBet->bet_splitters->sum('amount');
        $real_amount = $singBet->amount - $splitter_amount_total;

        // Determine currency multiplier based on type
        // $multiplier = match ($singBet->currency) {
        //     'm-(OSRS)' => $this->mValue,
        //     'r-(RS3)' => $this->rValue,
        //     'c-(CAD)' => 0.75,
        //     default => 1,
        // };
        $multiplier = $singBet->rate;
        // Calculate net profit based on status and live status
        $netProfit = match (true) {
            $singBet->live && $singBet->status == 1 => round($real_amount * $multiplier, 2), // win
            //$singBet->live && $singBet->status == 0 => round(($real_amount * $singBet->odds * 0.95 - $real_amount) * -1 * $multiplier, 2), // lose
            $singBet->live && $singBet->status == 0 => round(($real_amount * ($singBet->odds - 1)) * -1 * $multiplier, 2), // lose
            !$singBet->live && $singBet->status == 1 => round($real_amount * $multiplier, 2), // win
            !$singBet->live && $singBet->status == 0 => round(($real_amount * ($singBet->odds - 1)) * -1 * $multiplier, 2), // lose
            default => 0,
        };
        $splitter_data = $singBet->bet_splitters->map(function($splitter) {
            $customer = \App\Models\Customer::find($splitter->customer_id);
            
            return [
                'name' => $customer ? $customer->name : 'unknown',
                'amount' => $splitter->amount,
                'customer_id' => $splitter->customer_id,
            ];
        });

        // Build response data
        $active_json_data = [
            'id' => $singBet->id,
            'slip' => $singBet->slip,
            'odds' => round($singBet->odds, 2),
            'live' => (int)$singBet->live,
            'status' => (int)$singBet->status,
            'amount' => $singBet->amount,
            'customer_name' => optional($singBet->customer)->name ?? 'unknown customer',
            'currency' => $singBet->currency,
            'notes' => $singBet->notes,
            'created_at' => $singBet->created_at,
            'netProfit' => $netProfit,
            'arrSplitters' => $splitter_data,
        ];

        return response()->json([
            'status' => true,
            'message' => 'Ok',
            'netProfit' => $netProfit,
            'customerName' => optional($singBet->customer)->name ?? 'unknown customer',
            'customerId' => optional($singBet->customer)->id ?? 0,
            $active_json_data
        ]);
    }
    
    //Get the each customer's net
    public function getEachCustomerNetList($customer_id)
    {
        $sel_new_bets = Customer::where('id', $customer_id)->first()->new_bets;
        return response()->json([
            'status'=>true,
            'message'=>'Ok',
            $cus_total_money
        ]);
    }

    /**
     * Save the updated bet details.
     * This function updates the odds, amount, and splitters for a specific bet.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateActiveBet(Request $request, $id)
    {
        $editedBet = $request->input('editedBet');
        $customerId = $request->input('customerID');
        $updatedArrSplitters = $request->input('updatedArrSplitters');        
        Log::info('customer id here>>>>>', ['validator' => $customerId]);   
        // Validate incoming request

        $validator = Validator::make($editedBet, [            
            'slip' => 'required|string',
            'odds' => 'required|numeric',
            'amount' => 'required|numeric'            
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->all(),
            ], 400);
        }

        // Find the bet by ID
        $bet = NewBet::find($id);

        if (!$bet) {
            return response()->json([
                'status' => false,
                'message' => 'Bet not found.',
            ], 404);
        }

        // Update odds and amount
        $bet->odds = $editedBet['odds'];
        $bet->customer_id = $customerId;
        $bet->amount = $editedBet['amount'];
        $bet->slip = $editedBet['slip'];
        $bet->notes = $editedBet['notes'];
        $bet->save();

        // Remove old splitters
        $bet->bet_splitters()->delete();
        
        // Add new splitters        
        if (!empty($updatedArrSplitters)) {
            foreach ($updatedArrSplitters as $splitterData) {
                $splitter = new Splitter();
                $splitter->customer_id = $splitterData['customer_id'];
                $splitter->amount = $splitterData['amount'];
                $splitter->new_bets_id = $bet->id;
                $splitter->save();
            }
        }        

        return response()->json([
            'status' => true,       
            'editedBet' =>  $editedBet,
            'updatedArrSplitters' => $updatedArrSplitters,
            'message' => 'Bet updated successfully.',
            'bet' => $bet,
        ]);
    }

    //Get the all customer's total net
    public function getSumNet()
    {
        $all_new_bets = NewBet::all();

        $perfect_win_money = $all_new_bets->where('currency', '<>', 'm-(OSRS)')->where('currency', '<>', 'c-(CAD)')->where('currency', '<>', 'r-(RS3)')->where('status', 1)->sum('amount');
        $game_win_money = $all_new_bets->where('currency', '=', 'm-(OSRS)')->where('status', 1)->sum('amount');
        $cad_win_money = $all_new_bets->where('currency', '=', 'c-(CAD)')->where('status', 1)->sum('amount');
        $rs3_win_money = $all_new_bets->where('currency', '=', 'r-(RS3)')->where('status', 1)->sum('amount');

        $perfect_lose_moneys = 0.95*$all_new_bets->where('currency', '<>', 'm-(OSRS)')->where('currency', '<>', 'c-(CAD)')->where('currency', '<>', 'r-(RS3)')->where('status', 0)->sum('amount');
        $game_lose_moneys = 0.95*$all_new_bets->where('currency', '=', 'm-(OSRS)')->where('status', 0)->sum('amount');
        $cad_lose_moneys = 0.95*$all_new_bets->where('currency', '=', 'c-(CAD)')->where('status', 0)->sum('amount');
        $rs3_lose_moneys = 0.95*$all_new_bets->where('currency', '=', 'r-(RS3)')->where('status', 0)->sum('amount');

        $cus_total_money = 0;

        $cus_total_money = $perfect_win_money - $perfect_lose_moneys  + 
                        round($game_win_money*$this->mValue, 2) - 
                        round($game_lose_moneys*$this->mValue, 2) + 
                        round($rs3_win_money*$this->rValue, 2) - 
                        round($rs3_lose_moneys*$this->rValue, 2) + 
                        round($cad_win_money*0.75, 2) - 
                        round($cad_lose_moneys*0.75, 2);

        return response()->json([
            'status'=>true,
            'message'=>'Ok',
            $cus_total_money
        ]);
    }
    /**
     * Remove the specified bet from storage.
     *
     * @param  \App\Models\NewBet  $bet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;

        $delete_Customer = NewBet::where('id', $id)->delete();
        if($delete_Customer == 1){
            return response()->json([
                'status'=>true,
                'message'=>'Successfully removed'
            ]);
        }else{
            return response()->json([
                'status'=>true,
                'message'=>'didn\'t removed'
            ]);
        }

    }
}
