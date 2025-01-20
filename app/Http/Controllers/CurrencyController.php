<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Currency;

class CurrencyController extends Controller
{
    public function __construct()
    {        
    }

    //Get the current currency rate
    public function getCurrencyRate()
    {
        $currency = Currency::first();        
            
        return response()->json([
            'status'=>true,
            'message'=>'Ok',
            'm_rate' => $currency->m_rate,
            'r_rate' => $currency->r_rate,
        ]);
    }

    /**
     * Update the currency rate in storage.     
     * @param  \Illuminate\Http\Request  $request     
     */
    public function update_rate(Request $request, $type)
    {        
        Log::info($type);            
        
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
        ]);
    }
}
