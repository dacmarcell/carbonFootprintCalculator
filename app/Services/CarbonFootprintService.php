<?php

namespace App\Services;

class CarbonFootprintService
{
    /**
     * Calculates carbon emissions for transportation.
     *
     * The formula for transportation is based on the distance traveled, fuel efficiency (km/l), and emission factor (g CO2/km).
     * The emission factor varies depending on the type of transport and the fuel used.
     *
     * @param array $transports
     * @return float
     */
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

    /**
     * Calculates carbon emissions based on electricity consumption.
     *
     * The carbon footprint of electricity is calculated by multiplying the energy consumption (kWh) by the emission factor
     * of the electric grid, which depends on the energy mix of each country.
     * A typical value for the emission factor is 0.5 kg CO2/kWh, but it varies depending on whether the energy is renewable or not.
     *
     * @param float $electricity
     * @param float $factor
     * @return float
     */
    public function calculateElectricityEmissions(float $electricity, float $factor): float
    {
        return $electricity * $factor;
    }

    /**
     * Calculates carbon emissions based on the user's diet.
     *
     * It is estimated that diet has a significant carbon footprint, especially an omnivorous diet,
     * which includes large amounts of meat. The carbon footprint of diets is based on studies about the emissions
     * associated with food production, especially meat and dairy products.
     *
     * - Vegan diet: 1500 kg CO2/year
     * - Vegetarian diet: 2000 kg CO2/year
     * - Omnivorous diet: 3300 kg CO2/year
     *
     * @param string $diet
     * @return float
     */
    public function calculateDietEmissions(string $diet): float
    {
        $dietFactors = [
            "vegan" => 1500,
            "vegetarian" => 2000,
            "omnivorous" => 3300
        ];

        return $dietFactors[$diet];
    }

    /**
     * Calculates carbon emissions associated with goods and services consumption.
     *
     * The consumption of goods generates emissions due to manufacturing, transportation, and disposal.
     * It is estimated that the carbon footprint of consumption is around 0.15 kg CO2 per monetary unit
     * (e.g., 0.15 kg CO2 per $1 or R$1), depending on the type of goods consumed.
     *
     * @param float $comsumption
     * @return float
     */
    public function calculateConsumptionEmissions(float $comsumption): float
    {
        return $comsumption * 0.15;
    }

    /**
     * Calculates carbon emissions associated with waste disposal.
     *
     * Waste disposal has a carbon footprint due to decomposition and treatment processes
     * (such as incineration or landfills). The average estimated footprint is 0.6 kg CO2 per kg of waste.
     *
     * @param float $waste
     * @return float
     */
    public function calculateWasteEmissions(float $waste): float
    {
        return $waste * 0.6;
    }

    /**
     * Calculates total carbon emissions based on all provided data.
     *
     * It sums up the emissions from transport, electricity, diet, consumption, and waste to calculate the total carbon footprint.
     *
     * @param array $data
     * @return array
     */
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

