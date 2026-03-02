<?php

namespace App\Livewire\Reports;

use App\Models\UserIntegration;
use App\Models\Integration;
use Livewire\Component;

class IntegrationReportManager extends Component
{
    public function render()
    {
        $userIntegrations = UserIntegration::with('integration')->get();
        
        $chartLabels = [];
        $chartValues = [];

        foreach ($userIntegrations as $ui) {
            $name = $ui->integration ? $ui->integration->name : 'Unknown';
            $chartLabels[] = $name;
            // For now, representing an active integration as 1, disconnected as 0
            $chartValues[] = $ui->status === 'active' ? 1 : 0;
        }

        $chartData = [
            'labels' => $chartLabels,
            'values' => $chartValues,
        ];

        return view('livewire.reports.integration-report-manager', [
            'integrations' => $userIntegrations,
            'chartData' => $chartData
        ]);
    }
}
