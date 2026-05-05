<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CampaignLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_id',
        'channel',
        'status',
        'message',
        'executed_at',
    ];

    protected $casts = [
        'executed_at' => 'datetime',
    ];

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }
}
