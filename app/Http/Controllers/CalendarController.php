<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Carbon\CarbonPeriod as CarbonCarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\CarbonPeriod;
use Illuminate\View\View;

class CalendarController extends Controller
{
    public function index(Request $request): View
    {
        $month = $request->string('month')->toString();

        try {
            $currentMonth = $month !== ''
                ? Carbon::createFromFormat('Y-m', $month)->startOfMonth()
                : now()->startOfMonth();
        } catch (\Throwable) {
            $currentMonth = now()->startOfMonth();
        }

        $start = $currentMonth->copy()->startOfWeek();
        $end = $currentMonth->copy()->endOfMonth()->endOfWeek();
        $campaigns = Campaign::query()
            ->with('creator')
            ->whereBetween('scheduled_at', [$start, $end])
            ->orderBy('scheduled_at')
            ->get()
            ->groupBy(fn (Campaign $campaign): string => optional($campaign->scheduled_at)->toDateString());

        $weeks = collect(CarbonCarbonPeriod::create($start, $end))
            ->chunk(7)
            ->map(fn ($week) => collect($week)->values());

        return view('calendar.index', [
            'currentMonth' => $currentMonth,
            'weeks' => $weeks,
            'campaignsByDate' => $campaigns,
        ]);
    }
}
