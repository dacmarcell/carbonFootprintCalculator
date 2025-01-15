<?php

namespace App\Http\Controllers;

use App\Services\CarbonFootprintService;
use Illuminate\Http\Request;

class CarbonFootprintController extends Controller
{
    private $carbonFootprintService;

    public function __construct(CarbonFootprintService $carbonFootprintService)
    {
        $this->carbonFootprintService = $carbonFootprintService;
    }

    public function calculate(Request $request)
    {
        $validated = $request->validate([
            'transport' => 'required|array',
            'transport.*.type' => 'required|string|in:car,bus,plane',
            'transport.*.distance' => 'required|numeric|min:0',
            'transport.*.efficiency' => 'required|numeric|min:0',
            'transport.*.factor' => 'required|numeric|min:0',
            'electricity' => 'required|numeric|min:0',
            'electricity_factor' => 'required|numeric|min:0',
            'diet' => 'required|string|in:vegan,vegetarian,omnivorous',
            'consumption' => 'required|numeric|min:0',
            'waste' => 'required|numeric|min:0',
        ]);

        $result = $this->carbonFootprintService->calculateTotalEmissions($validated);

        return response()->json($result);
    }
}
