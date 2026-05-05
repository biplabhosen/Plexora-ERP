<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageTemplate extends Model
{
    use HasFactory;

    public const CHANNEL_EMAIL = 'email';
    public const CHANNEL_SMS = 'sms';

    protected $fillable = [
        'name',
        'channel',
        'subject',
        'body',
    ];

    public static function channels(): array
    {
        return [
            self::CHANNEL_EMAIL,
            self::CHANNEL_SMS,
        ];
    }
}
