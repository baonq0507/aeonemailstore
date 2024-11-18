<?php

namespace App\Filament\Resources\ProductUserResource\Pages;

use App\Filament\Resources\ProductUserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProductUser extends EditRecord
{
    protected static string $resource = ProductUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
