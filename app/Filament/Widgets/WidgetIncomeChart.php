<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class WidgetIncomeChart extends ChartWidget
{
  protected static ?string $heading = 'Pemasukan';

  protected function getData(): array
  {
    $data = Trend::query(Transaction::incomes())
      ->between(
        start: now()->startOfYear(),
        end: now(),
      )
      ->perDay()
      ->sum('amount');
//      ->count();
    return [
      'datasets' => [
        [
          'label' => 'Incomes',
          'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
        ],
      ],
      'labels' => $data->map(fn (TrendValue $value) => $value->date),
    ];
  }

  protected function getType(): string
  {
    return 'line';
  }
}
