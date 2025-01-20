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

class TabController extends Controller
{    
    //show the new bet page.
    public function index(){       
        $all_hosts = Customer::where('flag', 0)->orderBy('name', 'ASC')->get();
        $host_json_data = [];        
        

        foreach($all_hosts as $key_splitter=>$customer){       
            $customer_current = (float)$customer->a_apply_pay + (float)$customer->b_bitcoin 
                          + (float)$customer->e_ethereum + (float)$customer->u_usdt;     
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
                'u_usdt' => $customer->u_usdt,
                'r_rs3' => $customer->r_rs3,
                'm_game_currency' => $customer->m_game_currency
            ];
        }
        $hosts = $host_json_data;
        //return response()->json(['hosts' => $host_json_data]);              
        return view('tabs', compact('hosts'));
    }

    // update tab.
    public function update(){
        return response()->json([
            'status' => true,
            'message' =>'Ok',
        ]);
    }

    // destory tab.
    public function destory(){
        return response()->json([
            'status' => true,
            'message' =>'Ok',
        ]);
    }
}
