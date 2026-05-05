<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class ModuleService
{
    private const CACHE_KEY = 'settings.modules';

    public const MODULES = [
        'products' => [
            'label' => 'Products',
            'description' => 'Catalog, pricing, and product publishing controls.',
            'icon' => 'fa-box',
        ],
        'inventory' => [
            'label' => 'Inventory',
            'description' => 'Stock visibility, adjustments, and low-stock monitoring.',
            'icon' => 'fa-warehouse',
        ],
        'orders' => [
            'label' => 'Orders',
            'description' => 'Order intake, review, and fulfillment workflows.',
            'icon' => 'fa-shopping-cart',
        ],
        'crm' => [
            'label' => 'CRM',
            'description' => 'Customers, leads, and engagement tracking.',
            'icon' => 'fa-address-book',
        ],
        'rfq' => [
            'label' => 'RFQ',
            'description' => 'Buyer sourcing requests and supplier quotations.',
            'icon' => 'fa-file-signature',
        ],
        'workflow' => [
            'label' => 'Workflow',
            'description' => 'Automation rules, execution logs, and event triggers.',
            'icon' => 'fa-bolt',
        ],
        'marketing' => [
            'label' => 'Marketing',
            'description' => 'Campaign planning, templates, and outbound automation.',
            'icon' => 'fa-bullhorn',
        ],
        'social' => [
            'label' => 'Social',
            'description' => 'Scheduled posts, content calendar, and account publishing.',
            'icon' => 'fa-share-nodes',
        ],
        'support' => [
            'label' => 'Support',
            'description' => 'Support tickets, replies, and service operations.',
            'icon' => 'fa-headset',
        ],
        'suppliers' => [
            'label' => 'Suppliers',
            'description' => 'Supplier onboarding, approvals, and collaboration.',
            'icon' => 'fa-truck',
        ],
    ];

    public function all(): array
    {
        $states = $this->cachedStates();

        return collect(self::MODULES)
            ->map(function (array $module, string $key) use ($states): array {
                return [
                    'key' => $key,
                    'setting_key' => $this->settingKey($key),
                    'label' => $module['label'],
                    'description' => $module['description'],
                    'icon' => $module['icon'],
                    'enabled' => (bool) ($states[$this->settingKey($key)] ?? true),
                ];
            })
            ->values()
            ->all();
    }

    public function enabled(string $key): bool
    {
        $states = $this->cachedStates();

        return (bool) ($states[$this->settingKey($key)] ?? true);
    }

    public function enabledAny(array $keys): bool
    {
        foreach ($keys as $key) {
            if ($this->enabled($key)) {
                return true;
            }
        }

        return false;
    }

    public function update(array $payload): void
    {
        foreach (array_keys(self::MODULES) as $module) {
            Setting::query()->updateOrCreate(
                ['key' => $this->settingKey($module)],
                ['value' => (string) (int) ($payload[$module] ?? false)]
            );
        }

        Cache::forget(self::CACHE_KEY);
    }

    public function settingKey(string $key): string
    {
        $normalized = $this->normalizeKey($key);

        return str_starts_with($normalized, 'module_')
            ? $normalized
            : 'module_'.$normalized;
    }

    private function cachedStates(): array
    {
        return Cache::rememberForever(self::CACHE_KEY, function (): array {
            return Setting::query()
                ->whereIn('key', collect(array_keys(self::MODULES))->map(
                    fn (string $module): string => $this->settingKey($module)
                )->all())
                ->pluck('value', 'key')
                ->map(fn (mixed $value): bool => filter_var($value, FILTER_VALIDATE_BOOL) || (string) $value === '1')
                ->all();
        });
    }

    private function normalizeKey(string $key): string
    {
        return str($key)
            ->lower()
            ->replace([' ', '-'], '_')
            ->toString();
    }
}
