<?php

namespace App\Filament\Widgets;

use App\Models\Area;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Widgets\ChartWidget;

class AreaWiseApprovedRickshaw extends ChartWidget
{
    use HasWidgetShield;
    protected ?string $heading = 'এরিয়া ভিত্তিক অনুমোদিত রিক্সার রিপোর্ট';
    protected static ?int $sort=3;
    protected static bool $isLazy = false;

    protected function getData(): array
    {
       $areas = Area::orderBy('id')->pluck('area_name')->toArray();

        $counts = Area::orderBy('id')
            ->withCount([
                'applicants as approved_count' => function ($q) {
                    $q->where('status', 'approved');
                }
            ])
            ->get()
            ->pluck('approved_count')
            ->toArray();

        return [
            'labels' => $areas,
            'datasets' => [
                [
                    'label' => 'Approved Applicants',
                    'data' => $counts,
                    'backgroundColor' => [
                        
                        '#33FF57', // category 2
                        '#8E44AD', // category 5
                        '#16A085', // category 6
                       
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
