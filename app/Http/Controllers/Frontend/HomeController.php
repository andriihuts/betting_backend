<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\NetIRC;
use App\Models\Coin;
use App\Models\Website;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    //
    public function index(){
        
        // Fetch customers with necessary relationships
        $all_Customers = Customer::with(['new_bets.bet_splitters'])->orderBy('name', 'ASC')->get();
        $all_coins = Coin::orderBy('name', 'ASC')->get();
        $all_websites = Website::orderBy('name', 'ASC')->get();
        
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

        $yearlyData = NetIRC::from(DB::raw("
            (
                    SELECT 
                        *,
                        YEAR(created_at) AS year,
                        ROW_NUMBER() OVER (
                            PARTITION BY YEAR(created_at)
                            ORDER BY created_at DESC
                        ) AS rn
                    FROM net_i_r_c_s
                ) AS ranked_years
            "))
            ->select('year', 'net as latest_net')
            ->where('rn', 1)
            ->orderBy('year')
            ->get()
            ->pluck('latest_net', 'year');

        $years = range(now()->year - 2, now()->year); // Show 3 years: current year, previous, and one before that
        $yearlyDataFormatted = [
            'labels' => $years,
            'data' => array_map(function ($year) use ($yearlyData) {
                return $yearlyData[$year] ?? 0; // Provide 0 if the year data does not exist
            }, $years),
        ];

        // 2. Generate Monthly Data (with empty months if not found)
        $currentYear = now()->year;
        $monthlyData = NetIRC::from(DB::raw("
            (
                    SELECT 
                        *,
                        MONTH(created_at) AS month,
                        ROW_NUMBER() OVER (
                            PARTITION BY MONTH(created_at)
                            ORDER BY created_at DESC
                        ) AS rn
                    FROM net_i_r_c_s
                    WHERE YEAR(created_at) = $currentYear
                ) AS ranked_months
            "))
            ->select('month', 'net as latest_net')
            ->where('rn', 1)
            ->orderBy('month')
            ->get()
            ->pluck('latest_net', 'month');

        $months = range(1, 12); // 1 to 12 for all months of the year
        $monthlyDataFormatted = [
            'labels' => array_map(function ($month) {
                return date('M', mktime(0, 0, 0, $month, 10)); // Convert month number to string
            }, $months),
            'data' => array_map(function ($month) use ($monthlyData) {
                return $monthlyData[$month] ?? 0; // Provide 0 if the month data does not exist
            }, $months),
        ];

        // 3. Generate Weekly Data (with empty weeks if not found)
        $start = now()->startOfMonth()->format('Y-m-d H:i:s');
        $end = now()->endOfMonth()->format('Y-m-d H:i:s');
        $weeklyData = NetIRC::from(DB::raw("
            (
                    SELECT 
                        *,
                        (WEEK(created_at, 1) - WEEK(DATE_SUB(created_at, INTERVAL DAY(created_at) - 1 DAY), 1) + 1) AS week_number,
                        ROW_NUMBER() OVER (
                            PARTITION BY (WEEK(created_at, 1) - WEEK(DATE_SUB(created_at, INTERVAL DAY(created_at) - 1 DAY), 1) + 1)
                            ORDER BY created_at DESC
                        ) AS rn
                    FROM net_i_r_c_s
                    WHERE created_at BETWEEN '$start' AND '$end'
                ) AS ranked_weeks
            "))
            ->select('week_number as week', 'net as latest_net')
            ->where('rn', 1)
            ->orderBy('week')
            ->get()
            ->pluck('latest_net', 'week');

        $weeksInMonth = now()->endOfMonth()->format('W') - now()->startOfMonth()->format('W') + 1;
        $weeksOfMonth = range(1, $weeksInMonth);

        $weeklyDataFormatted = [
            'labels' => $weeksOfMonth,
            'data' => array_map(function ($week) use ($weeklyData) {
                return $weeklyData[$week] ?? 0; // Provide 0 if missing
            }, $weeksOfMonth),
        ];

        // 4. Generate Daily Data (with empty days if not found)
        $start = now()->subDays(6)->startOfDay()->format('Y-m-d H:i:s'); // 6 days ago + today = 7 days
        $end = now()->endOfDay()->format('Y-m-d H:i:s'); // till now

        $dailyData = NetIRC::from(DB::raw("
                (
                    SELECT 
                        id,
                        created_at,
                        net,
                        ROW_NUMBER() OVER (
                            PARTITION BY DATE(created_at)
                            ORDER BY created_at DESC
                        ) AS rn
                    FROM net_i_r_c_s
                    WHERE created_at BETWEEN '$start' AND '$end'
                ) AS ranked_days
            "))
            ->selectRaw('
                DATE(created_at) as day_date,
                net as latest_net
            ')
            ->where('rn', 1)
            ->orderBy('day_date')
            ->get()
            ->pluck('latest_net', 'day_date');

        // Build last 7 days
        $days = collect();
        for ($i = 6; $i >= 0; $i--) {
            $days->push(now()->subDays($i)->format('Y-m-d'));
        }

        $lastNet = 0;
        $dailyDataFormatted = [
            'labels' => [],
            'data' => [],
        ];

        foreach ($days as $day) {
            $dailyDataFormatted['labels'][] = date('D', strtotime($day)); // Mon, Tue, etc.

            if (isset($dailyData[$day])) {
                $lastNet = $dailyData[$day];
            }

            $dailyDataFormatted['data'][] = $lastNet;
        }


        return view('dashboard', compact('customer', 'total', 'net', 'irc', 'all_coins', 'all_websites', 'yearlyDataFormatted', 'monthlyDataFormatted', 'dailyDataFormatted', 'weeklyDataFormatted'));
    }
}
