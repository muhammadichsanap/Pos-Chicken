<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PesananProdukResource\Pages;
use App\Models\PesananProduk;
use App\Models\Produk;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use App\Services\CartService;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Widgets\CurrentOrderWidget;
use Filament\Tables\Actions\Action;

class PesananProdukResource extends Resource
{
    protected static ?string $model = Produk::class;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationLabel = 'Buat Pesanan';

    public static function table(Table $table): Table
    {
        return $table
            ->query(Produk::query())
            ->contentGrid([
                'md' => 2,
                'lg' => 3,
                'xl' => 4,
            ])
            ->columns([
                Stack::make([
                    ImageColumn::make('gambar_produk')
                        ->height(200)
                        ->extraImgAttributes(['class' => 'object-cover w-full rounded-t-lg']),
                    TextColumn::make('nama_produk')
                        ->size('lg')
                        ->weight('bold')
                        ->searchable()
                        ->alignCenter(),
                    TextColumn::make('harga')
                        ->money('IDR')
                        ->size('lg')
                        ->weight('bold')
                        ->alignCenter(),
                    TextColumn::make('kategori.nama_kategori')
                        ->badge()
                        ->color('warning')
                        ->searchable()
                        ->alignCenter(),
                ])->alignment('center'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kategori')
                    ->relationship('kategori', 'nama_kategori')
                    ->label('Kategori'),
            ])
            ->actions([
                Action::make('add_to_cart')
                    ->label('Tambah ke Keranjang')
                    ->icon('heroicon-m-plus-circle')
                    ->button()
                    ->color('primary')
                    ->action(fn (Produk $record) => CartService::addToCart([
                        'id' => $record->id,
                        'nama' => $record->nama_produk,
                        'harga' => $record->harga,
                        'gambar' => $record->gambar_produk,
                    ])),
            ])
            ->bulkActions([])
            ->defaultPaginationPageOption(12);
    }

    public static function getWidgets(): array
    {
        return [
            CurrentOrderWidget::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPesananProduks::route('/'),
        ];
    }
}
