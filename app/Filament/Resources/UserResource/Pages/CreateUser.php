<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;
class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    public function mutateFormDataBeforeCreate(array $data): array
    {
        $data['password'] = Hash::make($data['password']);
        if(!isset($data['balance'])){
            $data['balance'] = 0;
        }
        if(!isset($data['balance_lock'])){
            $data['balance_lock'] = 0;
        }

        //order_number
        $data['order_number'] = 0;
        //total_withdraw
        $data['total_withdraw'] = 0;
        //total_deposit
        $data['total_deposit'] = 0;
        //toltal_order
        $data['total_order'] = 0;
        return $data;
    }
}
