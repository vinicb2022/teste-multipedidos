<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessAnalysis;
use Illuminate\Http\Request;

class AnalysisController extends Controller
{
    public function start(Request $request)
    {
        $user = $request->user();
        $analysisId = rand(1000, 9999);

        ProcessAnalysis::dispatch($user, $analysisId);

        return response()->json([
            'message' => 'Análise iniciada com sucesso.',
            'analysisId' => $analysisId,
        ]);
    }
}