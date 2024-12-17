<?php

namespace App\Filament\Resources\PesananProdukResource\Pages;

use App\Filament\Resources\PesananProdukResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPesananProduk extends EditRecord
{
    protected static string $resource = PesananProdukResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
