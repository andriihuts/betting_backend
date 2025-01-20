<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\Currency;

class CurrencyController extends Controller
{
    // get the currency data
    public function showCurrencies(){               
        return view('newBet');
    }
    
    //Get the current currency rate
    public function getCurrencyRate()
    {
        $currency = Currency::first();                            
        $m_rate = $currency->m_rate;
        $r_rate = $currency->r_rate;
        return view('currencies', compact('m_rate', 'r_rate'));
    }

    /**
     * Update the currency rate in storage.     
     * @param  \Illuminate\Http\Request  $request     
     */
    public function update_rate(Request $request, $type)
    {        
        Log::info($type);            
        
        $rules = $type == 1 
        ? ['m_rate' => 'required|numeric|min:0']
        : ['r_rate' => 'required|numeric|min:0'];

        $request->validate($rules);

        $currency_setup = Currency::first();       
        if($currency_setup==null && empty($currency_setup)){
            return response()->json([
                'status'=>'fail',
                'message'=>'it can\'t be updated.',
            ]);
        }

        if($type == 1){// m_rate change
            $currency_setup->m_rate = $request->m_rate;
        }else{//r_rs3 change
            $currency_setup->r_rate = $request->r_rate;
        }

        $currency_setup->save();

        return response()->json([
            'status'=>'success',
            'message'=>'Ok'
        ], 200);
    }
}
