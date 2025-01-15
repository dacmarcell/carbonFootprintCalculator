<?php

namespace App\Services;

class CarbonFootprintService
{
    public function calculateTransportEmissions(array $transports): float
    {
        $total = 0;

        foreach ($transports as $transport) {
            $distance = $transport['distance'];
            $factor = $transport['factor'];
            $efficiency = $transport['efficiency'];

            $total += ($distance / $efficiency) * $factor;
        }

        return $total;
    }

    public function calculateElectricityEmissions(float $electricity, float $factor): float
    {
        return $electricity * $factor;
    }

    public function calculateDietEmissions(string $diet): float
    {
        $dietFactors = [
            "vegan" => 1500,
            "vegetarian" => 2000,
            "omnivorous" => 3300
        ];

        return $dietFactors[$diet];
    }

    public function calculateConsumptionEmissions(float $comsumption): float
    {
        return $comsumption * 0.15;
    }

    public function calculateWasteEmissions(float $waste): float
    {
        return $waste * 0.6;
    }

    public function calculateTotalEmissions(array $data): array
    {
        $transportEmissions = $this->calculateTransportEmissions($data['transport']);
        $electricityEmissions = $this->calculateElectricityEmissions($data['electricity'], $data['electricity_factor']);
        $dietEmissions = $this->calculateDietEmissions($data['diet']);
        $consumptionEmissions = $this->calculateConsumptionEmissions($data['consumption']);
        $wasteEmissions = $this->calculateWasteEmissions($data['waste']);

        $total = $transportEmissions + $electricityEmissions + $dietEmissions + $consumptionEmissions + $wasteEmissions;

        return [
            'transport_emissions' => $transportEmissions,
            'electricity_emissions' => $electricityEmissions,
            'diet_emissions' => $dietEmissions,
            'consumption_emissions' => $consumptionEmissions,
            'waste_emissions' => $wasteEmissions,
            'total_emissions' => $total,
        ];
    }
}

