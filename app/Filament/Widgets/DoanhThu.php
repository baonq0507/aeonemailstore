<?php

namespace App\Filament\Widgets;

use App\Models\ProductUser;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Transaction;

class DoanhThu extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Tổng doanh thu', Transaction::where('type', 'deposit')
                ->where('status', 'success')
                ->sum('amount')),
            Stat::make('Tổng số đơn hàng hoàn thành', ProductUser::where('status', 'success')
                ->count()),
            Stat::make('Tổng số đơn hàng hôm nay', ProductUser::where('status', 'success')
                ->whereDate('created_at', now()->format('Y-m-d'))
                ->count()),
        ];
    }
}
