<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use Filament\Widgets\ChartWidget;

class CategoryWiseReport extends ChartWidget
{
    protected ?string $heading = 'ক্যাটাগরি ভিত্তিক আবেদন রিপোর্ট';
    protected static ?int $sort=0;
    protected static bool $isLazy = false;

    protected function getData(): array
    {
        $categories = Category::orderBy('id')->pluck('category_name')->toArray();

        // Count of applicants by category
        $counts = Category::orderBy('id')
            ->withCount('applicants')
            ->get()
            ->pluck('applicants_count')
            ->toArray();

        return [
            'labels' => $categories,
            'datasets' => [
                [
                    'label' => 'মোট আবেদন',
                    'data'  => $counts,
                    'backgroundColor' => [
                        '#FF5733', // category 1
                        '#33FF57', // category 2
                        '#3357FF', // category 3
                        '#FFC300', // category 4
                        '#8E44AD', // category 5
                        '#16A085', // category 6
                        '#E74C3C', // category 7
                    ],
                ]
            ],
        ];
    }

    protected function getOptions(): ?array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'left',
                ],
            ],
            'scales' => [
                'x' => [
                    'display' => false,
                    'grid' => ['display' => false],
                ],
                'y' => [
                    'display' => false,
                    'grid' => ['display' => false],
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'polarArea';
    }
}
