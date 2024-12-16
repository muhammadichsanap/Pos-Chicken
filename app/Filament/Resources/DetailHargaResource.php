<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DetailHargaResource\Pages;
use App\Models\DetailHarga;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DetailHargaResource extends Resource
{
    protected static ?string $model = DetailHarga::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('produk_id')
                    ->label('Produk')
                    ->relationship('produk', 'nama_produk') // Menggunakan relasi ke Produk
                    ->required(),
                Forms\Components\TextInput::make('ukuran_produk')
                    ->label('Ukuran Produk')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('harga_produk')
                    ->label('Harga')
                    ->required()
                    ->numeric()
                    ->minValue(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('produk.nama_produk')
                    ->label('Produk')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('ukuran_produk')
                    ->label('Ukuran Produk')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('harga_produk')
                    ->label('Harga')
                    ->money('IDR'), // Format harga
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Produk';
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDetailHargas::route('/'),
            'create' => Pages\CreateDetailHarga::route('/create'),
            'edit' => Pages\EditDetailHarga::route('/{record}/edit'),
        ];
    }
}
