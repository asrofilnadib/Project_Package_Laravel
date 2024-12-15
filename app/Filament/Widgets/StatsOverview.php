<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
  protected function getStats(): array
  {
    $incomes = Transaction::percentageChange('incomes');
    $expenses = Transaction::percentageChange('expenses');

    $incomeCurrent = (int) str_replace('.', '', $incomes['current']);
    $expenseCurrent = (int) str_replace('.', '', $expenses['current']);

    $balance = $incomeCurrent - $expenseCurrent;

    return [
      Stat::make('Pemasukan', $incomes['current'])
        ->description($incomes['status'].' ('.$incomes['percentageChange'].')')
        ->descriptionIcon($incomes['status'] === 'Naik' ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
        ->color($incomes['status'] === 'Naik' ? 'success' : ($incomes['status'] === 'Turun' ? 'danger' : 'grey')),
      Stat::make('Pengeluaran', $expenses['current'])
        ->description($expenses['status'].' ('.$expenses['percentageChange'].')')
        ->descriptionIcon($expenses['status'] === 'Naik' ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
        ->color($expenses['status'] === 'Naik' ? 'success' : ($expenses['status'] === 'Turun' ? 'danger' : 'grey')),
      Stat::make('Selisih', \number_format($balance, 0, ',', '.'))
//        ->description('3% increase')
//        ->descriptionIcon('heroicon-m-arrow-trending-up')
        ->color('grey'),
    ];
  }
}
