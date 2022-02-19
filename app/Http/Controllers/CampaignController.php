<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Campaign;
use App\Models\CampaignImage;

use Illuminate\Support\Facades\DB;

class CampaignController extends Controller
{
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
 	* List the campaigns.
 	*/
    public function index()
    {
    	$campaigns = cache()->remember('campaign-lists', 60, function(){
            return Campaign::with('users', 'images')->get();
        });
    	return view('campaigns.index', compact('campaigns'));
    }

    /*
    * Campaign Create Form
    */
    public function create()
    {
    	$users = User::get();
    	return view('campaigns.form', compact('users'));
    }

    /*
    * New Campaign Save
    */
    public function saveCampaign(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'user_id' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'total_budget' => 'required|numeric',
            'daily_budget' => 'required|numeric',
            'images' => 'required'
        ]);

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
	        return redirect('campaigns')->with('success', 'campaign create successful');
        } catch (Exception $e) {
        	DB::rollBack();
        	return redirect()->back()->with('fail', $e->getMessage());
        }
    }

    public function updateCampaign(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'user_id' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'total_budget' => 'required|numeric',
            'daily_budget' => 'required|numeric',
        ]);

        DB::beginTransaction();

        try {

            if(!file_exists(public_path().'/images/')){
                mkdir(public_path().'/images/', 0777, true);
            }

            if (!empty($request->deleted_images)) {
                $deleted_images = explode(',', $request->deleted_images);
                foreach ($deleted_images as $key => $value) {
                    $campaign_image = CampaignImage::where('id', $value)->first();
                    if(!empty($campaign_image)){
                        if(file_exists(public_path().'/images/'.$campaign_image->image)){
                            unlink(public_path().'/images/'.$campaign_image->image);
                        }
                        CampaignImage::where('id', $campaign_image->id)->delete();
                    }
                }
            }

            Campaign::where('id', $request->id)
                ->update([
                    'name' => $request->name,
                    'user_id' => $request->user_id,
                    'start_date' => date('Y-m-d H:i:s', strtotime($request->start_date)),
                    'end_date' => date('Y-m-d H:i:s', strtotime($request->end_date)),
                    'total_budget' => $request->total_budget,
                    'daily_budget' => $request->daily_budget,
                    'status' => $request->status,
                ]);
            
            $images=array();
            if($files=$request->file('images')){
                foreach($files as $file){
                    $name= time() . '_' . $file->getClientOriginalName();
                    $file->move('images',$name);
                    $campaign_image = new CampaignImage();
                    $campaign_image->campaign_id = $request->id;
                    $campaign_image->image = $name;
                    $campaign_image->save();
                }
            }
            DB::commit();
            return redirect('campaigns')->with('success', 'campaign update successful');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('fail', $e->getMessage());
        }
    }

    public function editCampaign($id)
    {
        $campaign = Campaign::with('images')->where('id', $id)->first();
        $users = User::get();
        return view('campaigns.form', compact('campaign', 'users'));
    }

    public function deleteCampaign($id)
    {
        try{
            DB::beginTransaction();

            $campaign_images = CampaignImage::where('campaign_id', $id)->get();
            if(!empty($campaign_images)){
                foreach ($campaign_images as $campaign_image) {
                    if(file_exists(public_path().'/images/'.$campaign_image->image)){
                        unlink(public_path().'/images/'.$campaign_image->image);
                    }
                    CampaignImage::where('id', $campaign_image->id)->delete();
                }
            }
            Campaign::where('id', $id)->delete();
            DB::commit();
            return redirect()->back()->with('success', 'campaign delete successful');
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('fail', $e->getMessage());
        }
    }
}
