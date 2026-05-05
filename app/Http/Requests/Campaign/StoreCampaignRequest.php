<?php

namespace App\Http\Requests\Campaign;

use App\Models\Campaign;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class StoreCampaignRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasRole('admin') ?? false;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', Rule::in(Campaign::types())],
            'channel' => ['required', Rule::in(Campaign::channels())],
            'audience' => ['nullable', 'string', 'max:255'],
            'subject' => ['nullable', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'media' => ['nullable', 'file', 'mimetypes:image/jpeg,image/png,image/webp,video/mp4,video/quicktime'],
            'scheduled_at' => ['nullable', 'date'],
            'status' => ['required', Rule::in(Campaign::statuses())],
            'trigger_event' => ['nullable', Rule::in(Campaign::triggerEvents())],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator): void {
                $type = $this->input('type');
                $channel = $this->input('channel');
                $status = $this->input('status');
                $triggerEvent = $this->input('trigger_event');
                $scheduledAt = $this->input('scheduled_at');

                if ($type === Campaign::TYPE_MARKETING && ! in_array($channel, [Campaign::CHANNEL_EMAIL, Campaign::CHANNEL_SMS], true)) {
                    $validator->errors()->add('channel', 'Marketing campaigns support only email or SMS.');
                }

                if ($type === Campaign::TYPE_SOCIAL && ! in_array($channel, [Campaign::CHANNEL_FACEBOOK, Campaign::CHANNEL_INSTAGRAM], true)) {
                    $validator->errors()->add('channel', 'Social campaigns support only Facebook or Instagram.');
                }

                if ($channel === Campaign::CHANNEL_EMAIL && blank($this->input('subject'))) {
                    $validator->errors()->add('subject', 'An email subject is required for email campaigns.');
                }

                if ($status === Campaign::STATUS_SCHEDULED && blank($scheduledAt) && blank($triggerEvent)) {
                    $validator->errors()->add('scheduled_at', 'Provide a schedule time or a trigger event when a campaign is marked as scheduled.');
                }

                if ($triggerEvent && $type !== Campaign::TYPE_MARKETING) {
                    $validator->errors()->add('trigger_event', 'Trigger-based automation is available only for marketing campaigns.');
                }
            },
        ];
    }
}
