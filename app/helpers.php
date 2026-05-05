<?php

use App\Services\ModuleService;

if (! function_exists('module_enabled')) {
    function module_enabled(string $key): bool
    {
        return app(ModuleService::class)->enabled($key);
    }
}
