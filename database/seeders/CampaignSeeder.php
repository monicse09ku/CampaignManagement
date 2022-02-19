<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Campaign;
use App\Models\CampaignImage;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Faker\Generator as Faker; 

class CampaignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $users = User::take(2)->get();

        foreach ($users as $user) {
        	for ($i=0; $i < 3; $i++) {
	        	$campaign = new Campaign();
		        $campaign->name = $faker->word;
		        $campaign->user_id = $user->id;
		        $campaign->start_date = date("Y-m-d 10:00:00", strtotime("+1 day"));
		        $campaign->end_date = date("Y-m-d 10:00:00", strtotime("+16 day"));
		        $campaign->total_budget = $faker->randomFloat(2, 0, 150);
		        $campaign->daily_budget = $faker->randomFloat(2, 0, 10);
		        $campaign->status = 'active';
		        $campaign->save();

		        for ($i=0; $i < 3; $i++) { 
		        	$campaign_image = new CampaignImage();
		            $campaign_image->campaign_id = $campaign->id;
		            $campaign_image->image = $faker->image('public/images',640,480, null, false);
		            $campaign_image->save();
		        }
	        }
        }
    }
}
