<?php

namespace App\Filament\Resources\ProductUserResource\Pages;

use App\Filament\Resources\ProductUserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProductUser extends CreateRecord
{
    protected static string $resource = ProductUserResource::class;
}
