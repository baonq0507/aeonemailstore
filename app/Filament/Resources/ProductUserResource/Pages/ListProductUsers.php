<?php

namespace App\Filament\Resources\ProductUserResource\Pages;

use App\Filament\Resources\ProductUserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProductUsers extends ListRecords
{
    protected static string $resource = ProductUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
