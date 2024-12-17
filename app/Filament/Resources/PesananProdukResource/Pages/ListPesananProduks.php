<?php

namespace App\Filament\Resources\PesananProdukResource\Pages;

use App\Filament\Resources\PesananProdukResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions;
use App\Filament\Widgets\CurrentOrderWidget;

class ListPesananProduks extends ListRecords
{
    protected static string $resource = PesananProdukResource::class;

    protected function getHeaderActions(): array
    {
        return [];  // Hapus tombol Create
    }

    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [5, 10, 25, 50];
    }

    protected function getDefaultTableSortColumn(): ?string
    {
        return 'nama_produk';
    }

    protected function getDefaultTableSortDirection(): ?string
    {
        return 'asc';
    }

    protected function getHeaderWidgets(): array
    {
        return [
            CurrentOrderWidget::class,
        ];
    }
}
