<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Campaign extends Model
{
    use HasFactory;

    public const TYPE_MARKETING = 'marketing';
    public const TYPE_SOCIAL = 'social';

    public const CHANNEL_EMAIL = 'email';
    public const CHANNEL_SMS = 'sms';
    public const CHANNEL_FACEBOOK = 'facebook';
    public const CHANNEL_INSTAGRAM = 'instagram';

    public const STATUS_DRAFT = 'draft';
    public const STATUS_SCHEDULED = 'scheduled';
    public const STATUS_PROCESSING = 'processing';
    public const STATUS_SENT = 'sent';
    public const STATUS_FAILED = 'failed';

    public const TRIGGER_CUSTOMER_REGISTERED = 'customer_registered';
    public const TRIGGER_ORDER_PLACED = 'order_placed';
    public const TRIGGER_RFQ_CREATED = 'rfq_created';
    public const TRIGGER_CAMPAIGN_SCHEDULED = 'campaign_scheduled';

    protected $fillable = [
        'name',
        'type',
        'channel',
        'audience',
        'subject',
        'content',
        'media_path',
        'scheduled_at',
        'status',
        'trigger_event',
        'is_active',
        'created_by',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function logs(): HasMany
    {
        return $this->hasMany(CampaignLog::class);
    }

    public function scopeScheduled(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_SCHEDULED);
    }

    public function scopeDue(Builder $query): Builder
    {
        return $query->scheduled()
            ->whereNotNull('scheduled_at')
            ->where('scheduled_at', '<=', now());
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeForType(Builder $query, ?string $type): Builder
    {
        return $query->when($type, fn (Builder $query, string $type): Builder => $query->where('type', $type));
    }

    public static function types(): array
    {
        return [
            self::TYPE_MARKETING,
            self::TYPE_SOCIAL,
        ];
    }

    public static function channels(): array
    {
        return [
            self::CHANNEL_EMAIL,
            self::CHANNEL_SMS,
            self::CHANNEL_FACEBOOK,
            self::CHANNEL_INSTAGRAM,
        ];
    }

    public static function statuses(): array
    {
        return [
            self::STATUS_DRAFT,
            self::STATUS_SCHEDULED,
            self::STATUS_PROCESSING,
            self::STATUS_SENT,
            self::STATUS_FAILED,
        ];
    }

    public static function triggerEvents(): array
    {
        return [
            self::TRIGGER_CUSTOMER_REGISTERED,
            self::TRIGGER_ORDER_PLACED,
            self::TRIGGER_RFQ_CREATED,
            self::TRIGGER_CAMPAIGN_SCHEDULED,
        ];
    }
}
