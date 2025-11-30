<?php

namespace App\Filament\Widgets;

use App\Models\Applicant;
use Filament\Widgets\ChartWidget;

class PercentageOfApplication extends ChartWidget
{
    protected ?string $heading = 'মোট আবেদনের উপর স্ট্যাটাস ভিত্তিক হার %';
    protected static ?int $sort=1;
    protected static bool $isLazy = false;

    protected function getData(): array
    {
        $total = Applicant::count();

        $approved = Applicant::where('status', 'approved')->count();
        $rejected = Applicant::where('status', 'rejected')->count();
        $pending  = Applicant::where('status', 'pending')->count();

        // Convert to percentages
        $approvedPct = $total ? round(($approved / $total) * 100, 2) : 0;
        $rejectedPct = $total ? round(($rejected / $total) * 100, 2) : 0;
        $pendingPct  = $total ? round(($pending  / $total) * 100, 2) : 0;

        return [
            'labels' => ['Approved', 'Rejected', 'Pending'],
            'datasets' => [
                [
                    'label' => 'Percentage',
                    'data' => [
                        $approvedPct,
                        $rejectedPct,
                        $pendingPct,
                        
                    ],
                    'backgroundColor' => [
                        '#16A085', // category 6
                        '#E74C3C', // category 7
                        '#FFC300', // category 4
                       
                        
                        
                    ],

                ],
            ],
        ];
    }
    

    protected function getType(): string
    {
        return 'pie';
    }
}
