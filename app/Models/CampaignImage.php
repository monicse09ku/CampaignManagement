<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignImage extends Model
{
    use HasFactory;

    protected $fillable = array('campaign_id', 'image');

    /**
     * Get the comments for the blog post.
     */
    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}
