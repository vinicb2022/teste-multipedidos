<?php

namespace App\Services;

use App\Models\DataRecord;
use Illuminate\Support\Facades\DB;

class AnalysisService
{
    private const VALUE_ADJUSTMENT_FACTOR = 1.07;

    public function calculateAdjustedTotalForLastTenYears(): float
    {
        $tenYearsAgo = now()->subYears(10);

        $total = DataRecord::where('date', '>=', $tenYearsAgo)->sum(DB::raw('value * ' . self::VALUE_ADJUSTMENT_FACTOR));

        return (float) $total;
    }
}