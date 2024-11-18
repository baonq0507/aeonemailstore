<?php

namespace App\Filament\Resources\TransactionWithdrawResource\Pages;

use App\Filament\Resources\TransactionWithdrawResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;
use App\Models\User;

class CreateTransactionWithdraw extends CreateRecord
{
    protected static string $resource = TransactionWithdrawResource::class;

    public function mutateFormDataBeforeCreate(array $data): array
    {
        $data['type'] = 'withdraw';
        $data['transaction_code'] = Str::random(10);
        $data['fee'] = 0;
        $user = User::find($data['user_id']);
        $data['amount_after_fee'] = $data['amount'];
        $data['balance_before'] = $user->balance;
        $data['balance_after'] = $user->balance - $data['amount'];
        return $data;
    }
}
