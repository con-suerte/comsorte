<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_id', 'ip', 'country', 'user_agent', 'browser', 'os', 'language', 'utm_source', 'utm_medium', 'referrer', 'is_filtered'
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}
