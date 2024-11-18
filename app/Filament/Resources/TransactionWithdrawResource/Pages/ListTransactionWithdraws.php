<?php

namespace App\Filament\Resources\TransactionWithdrawResource\Pages;

use App\Filament\Resources\TransactionWithdrawResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTransactionWithdraws extends ListRecords
{
    protected static string $resource = TransactionWithdrawResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
