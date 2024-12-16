<?php

namespace App\Filament\Resources\DetailHargaResource\Pages;

use App\Filament\Resources\DetailHargaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDetailHarga extends EditRecord
{
    protected static string $resource = DetailHargaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
