<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignFilter extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_id',
        'allowed_countries',
        'allowed_os',
        'allowed_browsers',
        'blocked_ips',
        'allowed_timezones',
        'block_no_language',
        'match_browser_tz',
        'required_utm'
    ];

    protected $casts = [
        'allowed_countries' => 'array',
        'allowed_os' => 'array',
        'allowed_browsers' => 'array',
        'blocked_ips' => 'array',
        'allowed_timezones' => 'array',
        'required_utm' => 'array',
        'block_no_language' => 'boolean',
        'match_browser_tz' => 'boolean'
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}
