<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Filament\Resources\TransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;
use App\Models\User;

class CreateTransaction extends CreateRecord
{
    protected static string $resource = TransactionResource::class;

    public function mutateFormDataBeforeCreate(array $data): array
    {
        $data['type'] = 'deposit';
        $data['fee'] = 0;
        $user = User::find($data['user_id']);
        $data['transaction_code'] = Str::random(10);
        $data['amount_after_fee'] = $data['amount'] - $data['fee'];
        $data['balance_before'] = $user->balance;
        $data['balance_after'] = $user->balance + $data['amount'];


        if($data['status'] === 'success') {
            $user->update(['balance' => $data['balance_after']]);
        }
        return $data;
    }
}
