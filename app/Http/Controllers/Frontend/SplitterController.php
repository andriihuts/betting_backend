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

class SplitterController extends Controller
{
    //
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

        // Merge the arrays
        $merged_data = array_merge($customer_data, $host_data);

        // Sort the merged array by the 'name' field
        usort($merged_data, function ($a, $b) {
            return strcmp($a['name'], $b['name']);
        });

        // Return combined response
        return response()->json([
            'customers' => $merged_data,
            'hosts' => $host_data,
            'total' => round($total_sports, 2),
            'net' => $net_money_value,
            'irc' => $irc_money_value,
        ]);
    }
}
