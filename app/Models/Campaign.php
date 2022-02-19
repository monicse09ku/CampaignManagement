<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = array('user_id', 'name', 'start_date', 'end_date', 'status', 'total_budget', 'daily_budget');

    /**
     * Get the comments for the blog post.
     */
    public function images()
    {
        return $this->hasMany(CampaignImage::class);
    }

    /**
     * Get the comments for the blog post.
     */
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
