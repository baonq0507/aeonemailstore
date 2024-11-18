<?php

namespace App\Filament\Resources\TransactionWithdrawResource\Pages;

use App\Filament\Resources\TransactionWithdrawResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTransactionWithdraw extends EditRecord
{
    protected static string $resource = TransactionWithdrawResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
