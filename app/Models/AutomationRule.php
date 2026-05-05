<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AutomationRule extends Model
{
    use HasFactory;

    public const EVENT_ORDER_PLACED = 'order_placed';
    public const EVENT_RFQ_CREATED = 'rfq_created';
    public const EVENT_STOCK_LOW = 'stock_low';

    public const ACTION_SEND_EMAIL = 'send_email';
    public const ACTION_NOTIFY_SUPPLIER = 'notify_supplier';
    public const ACTION_NOTIFY_ADMIN = 'notify_admin';
    public const ACTION_LOG_ONLY = 'log_only';

    protected $fillable = [
        'name',
        'event',
        'condition',
        'action',
        'target',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function logs(): HasMany
    {
        return $this->hasMany(WorkflowLog::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
