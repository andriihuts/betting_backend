<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Website;

use Illuminate\Support\Facades\Validator;

class WebsiteController extends Controller
{    
    //show the new bet page.
    public function index(){
        $all_websites = Website::orderBy('name', 'ASC')->get();
        return view('websites', compact('all_websites'));
    }

     /**
     * Store a newly created website in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:websites|max:255',
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
        $newWebsite = new Website;
        $newWebsite->name = $request->name;
        $newWebsite->website_url = '';
        $newWebsite->icon_url = '';
        $fWebsite = $newWebsite->save();

        if($fWebsite){
            return response()->json([
                'status'=>true,
                'website'=>$newWebsite,
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
     * Remove the specified website from storage.
     *
     * @param  \App\Models\Website  $website
     * @return \Illuminate\Http\Response
     */
    public function destory(Request $request)
    {
        $name = $request->name; 
        $delete_Website = Website::where('name', $name)->delete();
        if($delete_Website == 1){
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
     * Update the specified website in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Website  $website
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Retrieve website by ID
        $id = $request->id;
        $update_Website = Website::find($id);

        // Check if website exists
        if (!$update_Website) {
            return response()->json([
                'status' => 'fail',
                'message' => "Website with ID $id can't be updated.",
            ]);
        }

        // Update website fields with default values if null
        $update_Website->name = $request->name ?? '';
        $update_Website->website_url = $request->website_url ?? '';
        if($request->icon_url != ''){
            $update_Website->icon_url = $request->icon_url ?? '';
        }
        $update_Website->save();

        return response()->json([
            'status' => true,
            'message' => 'Ok',
            'website' => $update_Website
        ]);
    }

    /**
     * Display the specified website.
     *
     * @param  \App\Models\Website  $website
     * @return \Illuminate\Http\Response
     */    
    public function singleWebsite($website_id)
    {
        // Retrieve website by ID, or return default values if not found
        $website = Website::find($website_id);

        return response()->json([
            'status' => true,
            'message' => 'Ok',
            'single' => $website
        ]);
    }


}
