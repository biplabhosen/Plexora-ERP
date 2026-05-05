<?php

namespace App\Services;

class SupportBotService
{
    public function generateReply(string $message): array
    {
        $normalized = str($message)->lower()->toString();

        if (str_contains($normalized, 'order')) {
            return ['reply' => 'Please share your order number.'];
        }

        if (str_contains($normalized, 'refund')) {
            return ['reply' => 'Our support team will assist with refund requests.'];
        }

        return ['reply' => 'Support team will contact you soon.'];
    }
}
