<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Splitter;

class SplitterController extends Controller
{
    //
    /**
     * Store a newly created Splitter in storage.
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
                'status'=>'fail',
                'message'=>$validator->errors()->all(),                  
            ]);
        }

        Splitter::create($request->all());
        
        return response()->json([
            'status'=>'success',
            'message'=>'Ok'
        ]);
    }
}
