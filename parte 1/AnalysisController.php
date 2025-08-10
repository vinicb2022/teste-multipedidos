<?php

namespace App\Http\Controllers;

use App\Services\AnalysisService;
use Illuminate\Http\JsonResponse;

class AnalysisController extends Controller
{
    protected AnalysisService $analysisService;

    public function __construct(AnalysisService $analysisService)
    {
        $this->analysisService = $analysisService;
    }

    public function getAnalysis(): JsonResponse
    {
        $total = $this->analysisService->calculateAdjustedTotalForLastTenYears();

        return response()->json(['result' => $total]);
    }
}