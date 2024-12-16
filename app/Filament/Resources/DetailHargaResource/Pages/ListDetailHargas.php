<?php

namespace App\Filament\Resources\DetailHargaResource\Pages;

use App\Filament\Resources\DetailHargaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDetailHargas extends ListRecords
{
    protected static string $resource = DetailHargaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
