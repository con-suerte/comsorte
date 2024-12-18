<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'token', 'mode', 'money_page_action', 'money_page_url',
        'safe_page_action', 'safe_page_url', 'filter_level', 'active'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function filters()
    {
        return $this->hasOne(CampaignFilter::class);
    }

    public function logs()
    {
        return $this->hasMany(CampaignLog::class);
    }
}
