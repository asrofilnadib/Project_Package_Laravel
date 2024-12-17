<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class StatsOverview extends BaseWidget
{
  use InteractsWithPageFilters;
  protected function getStats(): array
  {
    $startDate = $this->getStartDate();
    $endDate = $this->getEndDate();
    // tipe perhitungan data
    $income = Transaction::incomes()->whereBetween('date_transaction', [$startDate, $endDate])->sum('amount');
    $expense = Transaction::expenses()->whereBetween('date_transaction', [$startDate, $endDate])->sum('amount');

    // tipe pengembalian data
    $incomes = Transaction::percentageChange('incomes');
    $expenses = Transaction::percentageChange('expenses');

    $incomeCurrent = (int) str_replace('.', '', $incomes['current']);
    $expenseCurrent = (int) str_replace('.', '', $expenses['current']);

    $balance = $incomeCurrent - $expenseCurrent;

    return [
      Stat::make('Pemasukan', 'Rp ' . \number_format($income, 0, ',', '.')),
      Stat::make('Pengeluaran', 'Rp ' . \number_format($expense, 0, ',', '.')),
      Stat::make('Selisih', 'Rp ' . \number_format($income - $expense, 0, ',', '.')),
    ];

    /*return [
      Stat::make('Pemasukan', $income)
        ->description($incomes['status'].' ('.$incomes['percentageChange'].')')
        ->descriptionIcon($incomes['status'] === 'Naik' ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
        ->color($incomes['status'] === 'Naik' ? 'success' : ($incomes['status'] === 'Turun' ? 'danger' : 'grey')),
      Stat::make('Pengeluaran', $expense)
        ->description($expenses['status'].' ('.$expenses['percentageChange'].')')
        ->descriptionIcon($expenses['status'] === 'Naik' ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
        ->color($expenses['status'] === 'Naik' ? 'success' : ($expenses['status'] === 'Turun' ? 'danger' : 'grey')),
      Stat::make('Selisih', \number_format($balance, 0, ',', '.'))
//        ->description('3% increase')
//        ->descriptionIcon('heroicon-m-arrow-trending-up')
        ->color('grey'),
    ];*/
  }

  private function getStartDate()
  {
    if (! \is_null($this->filters['startDate'] ?? null)) {
      return Carbon::parse($this->filters['startDate']);
    }

    return Transaction::min('date');
  }

  private function getEndDate()
  {
    if (! \is_null($this->filters['endDate'] ?? null)) {
      return Carbon::parse($this->filters['endDate']);
    }

    return Transaction::max('date');
  }
}
