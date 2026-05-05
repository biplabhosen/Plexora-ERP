<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\SupportBotService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SupportBotController extends Controller
{
    public function __invoke(Request $request, SupportBotService $supportBotService): JsonResponse
    {
        $validated = $request->validate([
            'message' => ['required', 'string'],
        ]);

        return response()->json(
            $supportBotService->generateReply($validated['message'])
        );
    }
}
