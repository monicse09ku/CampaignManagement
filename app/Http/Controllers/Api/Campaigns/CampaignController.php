<?php

namespace App\Http\Controllers\Api\Campaigns;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Campaign;
use App\Models\CampaignImage;

use Illuminate\Support\Facades\DB;

class CampaignController extends Controller
{
    /**
 	* List the campaigns.
 	*/
    public function campaigns()
    {
    	$campaigns = Campaign::with('users', 'images')->get();
        if(!empty($campaigns)){
    		return respondSuccess($campaigns);
    	}
    	return respondError('No Campaign Found!!!');
    }

    /**
 	* Get the campaigns.
 	*/
    public function getCampaign($id)
    {
    	$campaign = Campaign::with('users', 'images')->where('id', $id)->get();
        if(!empty($campaign)){
    		return respondSuccess($campaign);
    	}
    	return respondError('No Campaign Found!!!');
    }

    /*
    * New Campaign Save
    */
    public function createCampaign(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'user_id' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'total_budget' => 'required|numeric',
            'daily_budget' => 'required|numeric',
            'images' => 'required'
        ]);

        if ($validator->fails()) {
            $failedRules = $validator->failed();
            return respondError('Parameters failed validation');
        }

        DB::beginTransaction();

        try {
        	
            if(!file_exists(public_path().'/images/')){
                mkdir(public_path().'/images/', 0777, true);
            }
	        
	        $campaign = new Campaign();
	        $campaign->name = $request->name;
	        $campaign->user_id = $request->user_id;
	        $campaign->start_date = date('Y-m-d H:i:s', strtotime($request->start_date));
	        $campaign->end_date = date('Y-m-d H:i:s', strtotime($request->end_date));
	        $campaign->total_budget = $request->total_budget;
	        $campaign->daily_budget = $request->daily_budget;
	        $campaign->status = $request->status;
	        $campaign->save();

			$images=array();
		    if($files=$request->file('images')){
		        foreach($files as $file){
		            $name= time() . '_' . $file->getClientOriginalName();
		            $file->move('images',$name);
		            $campaign_image = new CampaignImage();
		            $campaign_image->campaign_id = $campaign->id;
		            $campaign_image->image = $name;
		            $campaign_image->save();
		        }
		    }
		    DB::commit();
	        return respondSuccess($campaign);
        } catch (Exception $e) {
        	DB::rollBack();
        	return respondError('Campaign Creation Failed!!!');
        }
    }
}
