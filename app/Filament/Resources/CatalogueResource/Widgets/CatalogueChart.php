<?php

namespace App\Filament\Resources\CatalogueResource\Widgets;

use App\Models\Catalogue;
use Filament\Facades\Filament;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class CatalogueChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected static ?string $heading = 'Catalogo por fecha';
    protected static ?string $pollingInterval = null;

    protected function getData(): array
    {
        $startDate = $this->filters['startDate'] ?? null;
        $endDate = $this->filters['endDate'] ?? null;

        $data = Catalogue::query()
            ->when($startDate, fn (Builder $query) => $query->whereDate('created_at', '>=', $startDate))
            ->when($endDate, fn (Builder $query) => $query->whereDate('created_at', '<=', $endDate))
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Total €',
                    'data' => $data->map(fn (Catalogue $catalogue) => $catalogue->price),
                ],
            ],
            'labels' => $data->map(fn (Catalogue $catalogue) => $catalogue->created_at),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
