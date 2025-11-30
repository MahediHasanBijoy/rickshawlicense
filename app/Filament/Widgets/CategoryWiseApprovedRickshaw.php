<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use Filament\Widgets\ChartWidget;

class CategoryWiseApprovedRickshaw extends ChartWidget
{
    protected ?string $heading = 'ক্যাটাগরি ভিত্তিক অনুমোদিত রিক্সার রিপোর্ট';
    protected static ?int $sort=2;
    protected static bool $isLazy = false;

    protected function getData(): array
    {
        $categories = Category::orderBy('id')->pluck('category_name')->toArray();

        // Count of applicants by category
        $counts = Category::orderBy('id')
            ->withCount([
                'applicants as approved_count' => function ($query) {
                    $query->where('status', 'approved');
                }
            ])
            ->get()
            ->pluck('approved_count')
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

    protected function getType(): string
    {
        return 'bar';
    }
}
