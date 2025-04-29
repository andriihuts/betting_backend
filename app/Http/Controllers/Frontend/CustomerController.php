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

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{       
    // show the customer page
    public function index(){              
        // Eager load relationships to minimize queries
        $customers = Customer::with(['new_bets.bet_splitters'])
            ->whereIn('flag', [0, 1]) // Fetch both customers and splitters in one query
            ->orderBy('name', 'ASC')
            ->get();

        // Separate customers and splitters
        $customer_data = [];
        $host_data = [];
        $total_sports = 0;

        foreach ($customers as $customer) {
            // Customer (flag = 1)            
            if ($customer->flag == 1) {
                $totals = [
                    'perfect' => 0,
                    'game' => 0,
                    'cad' => 0,
                    'rs' => 0,
                ];
    
                foreach ($customer->new_bets as $bet) {
                    if ($bet->status == 2) continue; // Skip bets with status 2
    
                    $splitter_sum = $bet->bet_splitters->sum('amount');
                    $real_money = (float)$bet->amount - $splitter_sum;
                    $multiplier = $bet->rate;
                    $amount = 0;
    
                    if ($bet->status == 1) {
                        $amount = round($real_money * $multiplier, 2);
                    } elseif ($bet->status == 0) {
                        $amount = round($real_money * ($bet->odds - 1) * (-1) * $multiplier, 2);
                    }

                    // Assign to appropriate currency total
                    switch ($bet->currency) {
                        case 'm-(OSRS)':
                            $totals['game'] += $amount;
                            break;
                        case 'c-(CAD)':
                            $totals['cad'] += $amount;
                            break;
                        case 'r-(RS3)':
                            $totals['rs'] += $amount;
                            break;
                        default:
                            $totals['perfect'] += $amount;
                            break;
                    }
                }
                
                $total_sports += array_sum($totals);
                Log::info('total_sports', ['total_sports' => $total_sports]);
                $customer_data[] = [
                    'id' => $customer->id,
                    'name' => $customer->name,
                    'total_perfect' => round($totals['perfect'], 2),
                    'total_game' => round($totals['game'], 2),
                    'total_cad' => round($totals['cad'], 2),
                    'total_rs3' => round($totals['rs'], 2),
                    'a_apply_pay' => $customer->a_apply_pay,
                    'b_bitcoin' => $customer->b_bitcoin,
                    'e_ethereum' => $customer->e_ethereum,
                    'c_card' => $customer->c_card,
                    'u_ukbt' => $customer->u_ukbt,
                    'r_rs3' => $customer->r_rs3,
                    'm_game_currency' => $customer->m_game_currency,
                ];
            }
            // Splitter/Host (flag = 0)
            if ($customer->flag == 0) {
                $host_data[] = [
                    'id' => $customer->id,
                    'name' => $customer->name,
                    'total_perfect' => round(
                        (float)$customer->a_apply_pay +
                            (float)$customer->b_bitcoin +
                            (float)$customer->e_ethereum +
                            (float)$customer->u_ukbt * 1.33,
                        2
                    ),
                    'total_game' => round((float)$customer->m_game_currency, 2),
                    'total_cad' => round((float)$customer->c_card, 2),
                    'total_rs3' => round((float)$customer->r_rs3, 2),
                    'a_apply_pay' => $customer->a_apply_pay,
                    'b_bitcoin' => $customer->b_bitcoin,
                    'e_ethereum' => $customer->e_ethereum,
                    'c_card' => $customer->c_card,
                    'u_ukbt' => $customer->u_ukbt,
                    'r_rs3' => $customer->r_rs3,
                    'm_game_currency' => $customer->m_game_currency,
                ];
            }
        }

        // Fetch or initialize net and IRC values
        $net_money = NetIRC::orderBy('created_at', 'desc')->first();
        $net_money_value = $net_money->net ?? $total_sports;
        $irc_money_value = $net_money->irc ?? 0;

        if (!$net_money) {
            NetIRC::create(['net' => $total_sports, 'irc' => 0]);
        }

        $customers = $customer_data;
        $hosts = $host_data;
        $total = round($total_sports, 2);
        $net = $net_money_value;
        $irc = $irc_money_value;

        return view('customers', compact('customers', 'hosts', 'total', 'net', 'irc'));
    }

     /**
     * Store a newly created customer in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:customers|max:255',
        ], $messages = [
            'required' => 'The :attribute field is required.',
            'unique' => 'The :attribute field should be unique.',
            'max' => 'The :attribute field should be maximum 255.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'=>'Fail',
                'message'=>$validator->errors()->all(),
            ]);
        }
        $newCustomer = new Customer;
        $newCustomer->name = $request->name;
        $newCustomer->flag = $request->flag;
        $fCustomer = $newCustomer->save();

        //Customer::create($request->all());
        if($fCustomer){
            return response()->json([
                'status'=>true,
                'customer'=>$newCustomer,
                'message'=>'saved successfuly!!'
            ]);
        }else{
            return response()->json([
                'status'=>false,
                'message'=>'Failed'
            ]);        
        }
    }

    /**
     * Remove the specified customer from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destory(Request $request)
    {
        $name = $request->name;
        $flag = $request->flag;          
        $customer_no = Customer::where('name', $name)->first();      
        $delete_Customer = Customer::where('name', $name)->where('flag', $flag)->delete();                                            
        $delete_bet = NewBet::where('customer_id', $customer_no->id)->delete();                                            
        $delete_splitter = Splitter::where('customer_id', $customer_no->id)->delete();
        Log::info('customer data', ['name' => $name, '$flag' => $flag]);
        Log::info('customer destory heere', ['customer' => $delete_Customer, '$delete_bet' => $delete_bet, '$delete_splitter'=>$delete_splitter]);
        if($delete_Customer == 1){
            return response()->json([
                'status'=>true,
                'message'=>'Successfully removed'
            ]);
        }else{
            return response()->json([
                'status'=>false,
                'message'=>'didn\'t removed'
            ]);
        }

        $name = $request->name;
        $flag = $request->flag; 

        $customer = Customer::where('name', $name)
                    ->where('flag', $flag)
                    ->first();
                    
        // Return early if the customer doesn't exist
        if (!$customer) {
            return response()->json([
                'status' => 'herererer',
                'message' => 'Customer not found',
            ], 404);
        }

        // Use a transaction to ensure all related deletions are atomic
        \DB::transaction(function () use ($customer) {
            // Delete related bets and splitters
            $customer->new_bets()->delete();
            $customer->getSplitters()->delete();

            // Delete the customer
            $customer->delete();
        });

        return response()->json([
            'status' => true,
            'message' => 'Successfully removed',
        ]);

    }

    /**
     * Update the specified customer in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Retrieve customer by ID
        $id = $request->id;
        $update_Customer = Customer::find($id);

        // Check if customer exists
        if (!$update_Customer) {
            return response()->json([
                'status' => 'fail',
                'message' => "Customer with ID $id can't be updated.",
            ]);
        }

        // Update customer fields with default values if null
        $update_Customer->a_apply_pay = $request->a_apply_pay ?? 0;
        $update_Customer->b_bitcoin = $request->b_bitcoin ?? 0;
        $update_Customer->e_ethereum = $request->e_ethereum ?? 0;
        $update_Customer->c_card = $request->c_card ?? 0;
        $update_Customer->u_ukbt = $request->u_ukbt ?? 0;
        $update_Customer->r_rs3 = $request->r_rs3 ?? 0;
        $update_Customer->m_game_currency = $request->m_game_currency ?? 0;
        $update_Customer->save();

        // Define money type and symbols for transaction history
        $money_type = [
            'a_apply_pay_history' => 'ApplePay',
            'b_bitcoin_history' => 'Bitcoin',
            'e_ethereum_history' => 'Ethereum',
            'c_card_history' => 'CAD',
            'u_ukbt_history' => 'UKBT',
            'm_game_currency_history' => 'm',
            'r_rs3_history' => 'RS3'
        ];

        // Prepare transactions in a batch for insertion
        $transactions = [];
        foreach ($request->all() as $key => $item) {
            // Skip non-transaction keys
            if (in_array($key, ['id', 'a_apply_pay', 'b_bitcoin', 'e_ethereum', 'c_card', 'u_ukbt', 'm_game_currency', 'r_rs3'])) {
                continue;
            }

            // Process only non-zero and non-null entries
            if ($item != null && $item != 0) {
                $money_sign = ($key == 'm_game_currency_history') ? 'm' : ('$ ' . ($money_type[$key] ?? ''));
                $money_sign = ($key == 'r_rs3_history') ? 'RS3' : $money_sign;

                $description = abs($item) . $money_sign . (floatval($item) > 0
                    ? ' has been added to ' . $update_Customer->name . "'s tab"
                    : ' has been subtracted from ' . $update_Customer->name . "'s tab");

                $transactions[] = [
                    'customer_name' => $update_Customer->name,
                    'amount' => $item,
                    'type_money' => $key,
                    'description' => $description,
                    'type_net' => 2,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
        }

        // Batch insert transactions if there are any
        if (!empty($transactions)) {
            Transaction::insert($transactions);
        }

        return response()->json([
            'status' => true,
            'message' => 'Ok',
            'customer' => $update_Customer
        ]);
    }

    /**
     * Display the specified customer.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */    
    public function singleCustomer($customer_id)
    {
        // Retrieve customer by ID, or return default values if not found
        $customer = Customer::find($customer_id);

        $singData = [
            'a_apply_pay1' => $customer->a_apply_pay ?? 0,
            'b_bitcoin1' => $customer->b_bitcoin ?? 0,
            'e_ethereum1' => $customer->e_ethereum ?? 0,
            'c_card1' => $customer->c_card ?? 0,
            'u_ukbt1' => $customer->u_ukbt ?? 0,
            'r_rs3_1' => $customer->r_rs3 ?? 0,
            'm_game_currency1' => $customer->m_game_currency ?? 0,

            'a_apply_pay2' => 0,
            'b_bitcoin2' => 0,
            'e_ethereum2' => 0,
            'c_card2' => 0,
            'u_ukbt2' => 0,
            'r_rs3_2' => 0,
            'm_game_currency2' => 0,

            'name' => $customer->name ?? 'unknown'
        ];

        return response()->json([
            'status' => true,
            'message' => 'Ok',
            'single' => $singData
        ]);
    }
}
