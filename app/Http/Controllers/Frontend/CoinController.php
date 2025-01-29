<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coin;

use Illuminate\Support\Facades\Validator;

class CoinController extends Controller
{    
    //show the new bet page.
    public function index(){
        $all_coins = Coin::orderBy('name', 'ASC')->get();
        return view('coins', compact('all_coins'));
    }

     /**
     * Store a newly created coin in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:coins|max:255',
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
        $newCoin = new Coin;
        $newCoin->name = $request->name;
        $newCoin->address = '';
        $newCoin->background_classname = 'bg-gradient-primary';
        $fCoin = $newCoin->save();

        if($fCoin){
            return response()->json([
                'status'=>true,
                'coin'=>$newCoin,
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
     * Remove the specified coin from storage.
     *
     * @param  \App\Models\Coin  $coin
     * @return \Illuminate\Http\Response
     */
    public function destory(Request $request)
    {
        $name = $request->name; 
        $delete_Coin = Coin::where('name', $name)->delete();
        if($delete_Coin == 1){
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

    }

    /**
     * Update the specified coin in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Coin  $coin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Retrieve coin by ID
        $id = $request->id;
        $update_Coin = Coin::find($id);

        // Check if coin exists
        if (!$update_Coin) {
            return response()->json([
                'status' => 'fail',
                'message' => "Coin with ID $id can't be updated.",
            ]);
        }

        // Update coin fields with default values if null
        $update_Coin->name = $request->name ?? '';
        $update_Coin->address = $request->address ?? '';
        $update_Coin->background_classname = $request->background_classname ?? 'bg-gradient-primary';
        $update_Coin->save();

        return response()->json([
            'status' => true,
            'message' => 'Ok',
            'coin' => $update_Coin
        ]);
    }

    /**
     * Display the specified coin.
     *
     * @param  \App\Models\Coin  $coin
     * @return \Illuminate\Http\Response
     */    
    public function singleCoin($coin_id)
    {
        // Retrieve coin by ID, or return default values if not found
        $coin = Coin::find($coin_id);

        return response()->json([
            'status' => true,
            'message' => 'Ok',
            'single' => $coin
        ]);
    }

}
