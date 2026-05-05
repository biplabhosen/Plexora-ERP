<?php

namespace App\Http\Middleware;

use App\Services\ModuleService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureModuleEnabled
{
    public function __construct(
        private readonly ModuleService $moduleService,
    ) {
    }

    public function handle(Request $request, Closure $next, string ...$modules): Response
    {
        abort_unless(
            $this->moduleService->enabledAny($modules),
            Response::HTTP_FORBIDDEN,
            'Module disabled'
        );

        return $next($request);
    }
}
