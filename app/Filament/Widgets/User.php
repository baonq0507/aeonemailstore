<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User as UserModel;
class User extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Tổng số người dùng', UserModel::count()),
        ];
    }
}
