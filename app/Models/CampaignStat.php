<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampaignStat extends Model
{
    protected $fillable = ['utm_term_id','campaign_id'];
    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function utmTerm()
    {
        return $this->belongsTo(UtmTerm::class);
    }

    protected function casts()
    {
        return [
            'monetization_timestamp' => 'datetime',
        ];
    }
}
