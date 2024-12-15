<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;
use phpDocumentor\Reflection\Types\This;

class Transaction extends Model
{
  use HasFactory;

  public function category()
  {
    return $this->belongsTo(Category::class, 'category_id');
  }

  public function scopeIncomes($query)
  {
    return $query->whereHas('category', function ($query) {
      $query->where('is_expenses', false);
    });
  }
  public function scopeExpenses($query)
  {
    return $query->whereHas('category', function ($query) {
      $query->where('is_expenses', true);
    });
  }

  public static function percentageChange($type = 'incomes')
  {
    if (!\in_array($type, ['incomes', 'expenses'])) {
      throw new \InvalidArgumentException('invalid type provide. use "incomes" or "expenses".');
    }

    $currentMonth = self::{$type}()
      ->whereBetween('created_at', [Carbon::now()->subDay(30), Carbon::now()])
      ->sum('amount');
    $previousMonth = self::{$type}()
      ->whereBetween('created_at', [Carbon::now()->subDay(60), Carbon::now()->subDay(30)])
      ->sum('amount');

    $status = 'Tetap';
    if ($currentMonth > $previousMonth) {
      $status = 'Naik';
    } else {
      $status = 'Turun';
    }

    $percentageChange = 0;
    if ($previousMonth > 0) {
      $percentageChange = (($currentMonth - $previousMonth) / $previousMonth) * 100;
    }
//    \dd($previousMonth);

    return [
      'current' => \number_format($currentMonth, 0, ',', '.'),
      'previous' => \number_format($previousMonth, 0, ',', '.'),
      'status' => $status,
      'percentageChange' => \number_format($percentageChange, 2,) . ' %',
    ];
  }
}
