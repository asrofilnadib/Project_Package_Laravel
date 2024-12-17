<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class WidgetExpensesChart extends ChartWidget
{
  protected static ?string $heading = 'Pengeluaran';

  protected function getData(): array
  {
    $data = Trend::query(Transaction::expenses())
      ->between(
        start: now()->subDay(90),
        end: now(),
      )
      ->perDay()
//      ->sum('amount');
      ->count();
    return [
      'datasets' => [
        [
          'label' => 'Expenses',
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
