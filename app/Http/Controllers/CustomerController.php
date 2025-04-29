<?php

namespace App\Http\Controllers;

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
    /**
     * Create a new controller instance.
     *
     * The constructor can include middleware that apply to all functions in this controller,
     * or selectively apply middleware to certain methods.
     */
    // protected $mValue, $rValue;
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
    public function getTest(Request $request)
    {
        $currency = Currency::first();
        return response()->json([
            'currency' => $currency,            
        ]);
    }

    public function index(){               
        return view('dashboard');
    }
    //Get the all data for Home page
    public function getHome(Request $request)
    {
        // Fetch customers with necessary relationships
        $all_Customers = Customer::with(['new_bets.bet_splitters'])->orderBy('name', 'ASC')->get();
        
        // Initialize totals and response data arrays
        $customer_json_data = [];
        $total_sports = 0;

        foreach ($all_Customers as $key => $customer) {
            $total_perfect_money = 0;
            $total_game_money = 0;
            $total_cad_money = 0;
            $total_rs_money = 0;
            $sel_new_bets = $customer->new_bets;  
            
            if(sizeof($sel_new_bets)){
                foreach ($sel_new_bets as $key1=>$sel_new_bet) {                   
                    if($sel_new_bet->status ==2 ) continue;
                    $each_splitter_money = $sel_new_bet->bet_splitters->sum('amount');                    
                    $real_money = (float)$sel_new_bet->amount - $each_splitter_money;                   
                    $multiplier = $sel_new_bet->rate;

                    if (!empty($sel_new_bet) && $sel_new_bet->live==1) { // live bet conditions                                            
                        if($sel_new_bet->status == 1){
                            $amount =  round($real_money * $multiplier, 2);
                        }else if($sel_new_bet->status == 0){
                            // $amount =  round(($real_money * $sel_new_bet->odds * 0.95 - $real_money) * (-1)*$multiplier, 2);
                            $amount =  round($real_money * ($sel_new_bet->odds - 1) * (-1)*$multiplier, 2);
                        }else{
                            $amount = 0;
                        }
                    } else if(!empty($sel_new_bet) && $sel_new_bet->live==0) { // non-live bet conditions
                        if($sel_new_bet->status == 1){
                            $amount =  round($real_money * $multiplier, 2);
                        }else if($sel_new_bet->status == 0){
                            $amount =  round($real_money * ($sel_new_bet->odds - 1) * (-1)*$multiplier, 2);
                        }
                    }
                    switch ($sel_new_bet->currency) {
                        case 'm-(OSRS)':
                            $total_game_money += $amount;
                            break;
                        case 'c-(CAD)':
                            $total_cad_money += $amount;
                            break;
                        case 'r-(RS3)':
                            $total_rs_money += $amount;
                            break;
                        default:
                            $total_perfect_money += $amount;
                            break;
                    }
                    $amount = 0;
                }
            }else{
                $total_perfect_money = 0;
                $total_game_money = 0;
            }

            // Store customer data for JSON response
            $customer_json_data[$key] = [
                'id' => $customer->id,
                'name' => $customer->name,
                'total_perfect' => round($total_perfect_money, 2),
                'total_game' => round($total_game_money, 2),
                'total_cad' => round($total_cad_money, 2),
                'total_rs3' => round($total_rs_money, 2),
                'a_apply_pay' => $customer->a_apply_pay,
                'b_bitcoin' => $customer->b_bitcoin,
                'e_ethereum' => $customer->e_ethereum,
                'c_card' => $customer->c_card,
                'u_ukbt' => $customer->u_ukbt,
                'r_rs3' => $customer->r_rs3,
                'm_game_currency' => $customer->m_game_currency,
            ];

            // Update total sports
            $total_sports += $customer_json_data[$key]['total_perfect'] + 
                            $customer_json_data[$key]['total_game'] + 
                            $customer_json_data[$key]['total_cad'] +
                            $customer_json_data[$key]['total_rs3'];                            
        }

        // Retrieve or initialize net_money and irc_money values
        $net_money = NetIRC::orderBy('created_at', 'desc')->first();
        $net_money_value = $net_money->net ?? $total_sports;
        $irc_money_value = $net_money->irc ?? 0;

        // If no net_money record exists, save a new one
        if (!$net_money) {
            NetIRC::create(['net' => $total_sports, 'irc' => 0]);
        }

        // Return response with calculated data
        return response()->json([
            'customer' => $customer_json_data,
            'total' => round($total_sports, 2),
            'net' => round($net_money_value, 2),
            'irc' => $irc_money_value,
        ]);
    }
    //Get the all customers for customer page
    public function getCustomers(Request $request)
    {
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
                        
            // Splitter/Host (flag = 0)
            if ($customer->flag == 1) {
                // Customer (flag = 1)
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
            if ($customer->flag == 0) {
            $host_data[] = [
                'id' => $customer->id,
                'name' => $customer->name,
                'total_perfect' => round(
                    (float)$customer->a_apply_pay +
                        (float)$customer->b_bitcoin +
                        (float)$customer->e_ethereum +
                        (float)$customer->u_ukbt,
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


        // Return combined response
        return response()->json([
            'customers' => $customer_data,
            'hosts' => $host_data,
            'total' => round($total_sports, 2),
            'net' => $net_money_value,
            'irc' => $irc_money_value,
        ]);
    }

    //Get the all customers for customer page
    public function getCustomerNames(Request $request)
    {
        $all_Customers = Customer::orderBy('name', 'ASC')->get();

        foreach($all_Customers as $key=>$all_Customer){
            $host_json_data[$key]['id'] = $all_Customer->id;
            $host_json_data[$key]['name'] = $all_Customer->name;
        }
        return response()->json(
            [
                $host_json_data
            ]
        );
    }
    //Get the all hosts's list and profit
    public function getSplitters(Request $request)
    {
        $all_hosts = Customer::where('flag', 0)->orderBy('name', 'ASC')->get();
        $host_json_data = [];        

        foreach($all_hosts as $key_splitter=>$customer){       
            $customer_current = (float)$customer->a_apply_pay + (float)$customer->b_bitcoin 
                          + (float)$customer->e_ethereum + (float)$customer->u_ukbt * 1.33;     
            //$sel_new_bets = $customer->new_bets;            
            $host_json_data[$key_splitter] = [
                'id' => $customer->id,
                'name' => $customer->name,
                'total_perfect' => round($customer_current, 2),
                'total_game' => round((float)$customer->m_game_currency, 2),
                'total_cad' => round((float)$customer->c_card, 2),
                'total_rs3' => round((float)$customer->r_rs3, 2),
                'a_apply_pay' => $customer->a_apply_pay,
                'b_bitcoin' => $customer->b_bitcoin,
                'e_ethereum' => $customer->e_ethereum,
                'c_card' => $customer->c_card,
                'u_ukbt' => $customer->u_ukbt,
                'r_rs3' => $customer->r_rs3,
                'm_game_currency' => $customer->m_game_currency
            ];
        }

        return response()->json(['hosts' => $host_json_data]);        
    }

    //get Customers and splitter Data
    public function getCustomerAndSplitterData(Request $request)
    {
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
            $totals = [
                'perfect' => 0,
                'game' => 0,
                'cad' => 0,
                'rs' => 0,
            ];

            if ($customer->flag == 1) {
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
            }

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

            if ($customer->flag == 0) {
                $host_data[] = [
                    'id' => $customer->id,
                    'name' => $customer->name,
                    'total_perfect' => round(
                        (float)$customer->a_apply_pay +
                            (float)$customer->b_bitcoin +
                            (float)$customer->e_ethereum +
                            (float)$customer->u_ukbt,
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


        // Return combined response
        return response()->json([
            'customers' => $customer_data,
            'hosts' => $host_data,
            'total' => round($total_sports, 2),
            'net' => $net_money_value,
            'irc' => $irc_money_value,
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


    /**
     * Store a newly created new net money in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeMisc(Request $request)
    {
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
     * Update the transaction history of tab detail
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update_newMoney(Request $request)
    {
        $id = $request->id;
        $update_Customer = Customer::where('id', $id)->first();
        $type = 'a_apply_pay';
        $money_type = ["a_apply_pay"=>'applepay', 'b_bitcoin'=>'bitcoin', 'e_ethereum'=>'ethereum', 
        'c_card'=>'CAD', 'u_ukbt'=>'ukbt', 'm_game_currency'=>'m', 'r_rs3'=>'RS3'];        
        
        foreach($request->all() as $key=>$item){
            if($key == 'id') continue;
            if($item!=null && $item!=0){
                $new_transaction = new Transaction();
                $new_transaction->customer_name = $update_Customer->name;
                $new_transaction->amount = $item;
                $new_transaction->type_money = $key;
                $money_sign = '';
                if(floatval($item) > 0){
                    if($key=='m_game_currency') $money_sign = 'm'; else $money_sign = '$ '.$money_type[$key];
                    $new_transaction->description = abs($item).$money_sign.' has been added to '.$update_Customer->name.'\'s tab';
                }else{
                    $new_transaction->description = abs($item).$money_sign.' has been subtracted to '.$update_Customer->name + '\'s tab';
                }
                $new_transaction->type_net = 2;
                $new_transaction->save();                                  
            }
        }        
    }
    /**
     * Remove the specified customer from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $name = $request->name;
        $flag = $request->flag;          
        $customer_no = Customer::where('name', $name)->first();      
        $delete_Customer = Customer::where('name', $name)->where('flag', $flag)->delete();                                            
        $delete_bet = NewBet::where('customer_id', $customer_no->id)->delete();                                            
        $delete_splitter = Splitter::where('customer_id', $customer_no->id)->delete();

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
                'status' => 'failed',
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

    //Get the all Transaction data
    public function getTransactions(Request $request)
    {
        $latest_transactions = Transaction::latest()->take(20)->get();
        return response()->json(
            [                 
                $latest_transactions
            ]
        );
    }    
}
