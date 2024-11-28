<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Filament\Resources\TransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Models\User;
class EditTransaction extends EditRecord
{
    protected static string $resource = TransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public function mutateFormDataBeforeSave(array $data): array
    {
        if($data['status'] === 'success') {
            $user = User::find($data['user_id']);
            $data['balance_after'] = $user->balance + $data['amount'];
            $user->update(['balance' => $data['balance_after']]);
        }
        return $data;
    }
}
