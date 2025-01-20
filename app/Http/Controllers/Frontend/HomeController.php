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

class HomeController extends Controller
{
    //
    public function index(){        
        
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
                    }else{
                        $amount = 0;
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
                'u_usdt' => $customer->u_usdt,
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

        $total = round($total_sports, 2);
        $net = round($net_money_value, 2);
        $irc = $irc_money_value;
        $customer = $customer_json_data;
        
        // $yearlyData = [
        //     'labels' => ['2023', '2024', '2025'], // Years
        //     'data' => [1500, 1800, 2000],         // Sample yearly data
        // ];
        
        // $monthlyData = [
        //     'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'], // Months
        //     'data' => [120, 130, 140, 150, 160, 170, 180, 190, 200, 210, 220, 230], // Sample monthly data
        // ];
        
        // $dailyData = [
        //     'labels' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'], // Days of the week
        //     'data' => [50, 60, 70, 80, 90, 100, 110],                     // Sample daily data
        // ];
        
        // Generate yearly data
        // 1. Generate Yearly Data (with empty years if not found)
        $yearlyData = NetIRC::selectRaw('YEAR(created_at) as year, SUM(net) as total_net')
        ->groupBy('year')
        ->orderBy('year')
        ->get()
            ->pluck('total_net', 'year');

        $years = range(now()->year - 2, now()->year); // Show 3 years: current year, previous, and one before that
        $yearlyDataFormatted = [
            'labels' => $years,
            'data' => array_map(function ($year) use ($yearlyData) {
                return $yearlyData[$year] ?? 0; // Provide 0 if the year data does not exist
            }, $years),
        ];

        // 2. Generate Monthly Data (with empty months if not found)
        $currentYear = now()->year;
        $monthlyData = NetIRC::selectRaw('MONTH(created_at) as month, SUM(net) as total_net')
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('total_net', 'month');

        $months = range(1, 12); // 1 to 12 for all months of the year
        $monthlyDataFormatted = [
            'labels' => array_map(function ($month) {
                return date('M', mktime(0, 0, 0, $month, 10)); // Convert month number to string
            }, $months),
            'data' => array_map(function ($month) use ($monthlyData) {
                return $monthlyData[$month] ?? 0; // Provide 0 if the month data does not exist
            }, $months),
        ];

        // 3. Generate Daily Data (with empty days if not found)
        $dailyData = NetIRC::selectRaw('DAYOFWEEK(created_at) as day, SUM(net) as total_net')
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->groupBy('day')
            ->orderBy('day')
            ->get()
            ->pluck('total_net', 'day');

        $daysOfWeek = [1, 2, 3, 4, 5, 6, 7]; // Days of the week (1 = Sunday, 7 = Saturday)
        $dailyDataFormatted = [
            'labels' => array_map(function ($day) {
                return date('D', strtotime("Sunday +{$day} days")); // Get weekday name
            }, $daysOfWeek),
            'data' => array_map(function ($day) use ($dailyData) {
                return $dailyData[$day] ?? 0; // Provide 0 if the day data does not exist
            }, $daysOfWeek),
        ];

        //return view('dashboard', compact('customer', 'total', 'net', 'irc', 'yearlyData', 'monthlyData', 'dailyData'));
        return view('dashboard', compact('customer', 'total', 'net', 'irc', 'yearlyDataFormatted', 'monthlyDataFormatted', 'dailyDataFormatted'));
    }
}
