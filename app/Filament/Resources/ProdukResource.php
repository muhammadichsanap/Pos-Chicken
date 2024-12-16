<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProdukResource\Pages;
use App\Models\Produk;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProdukResource extends Resource
{
    protected static ?string $model = Produk::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_produk')
                    ->label('Nama Produk')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('deskripsi_produk')
                    ->label('Deskripsi Produk')
                    ->required(),
                Forms\Components\FileUpload::make('gambar_produk')
                    ->label('Gambar Produk')
                    ->image()
                    ->disk('public')
                    ->directory('produk-images')
                    ->required()
                    ->imageResizeMode('cover')
                    ->imageCropAspectRatio('1:1'),
                Forms\Components\Select::make('kategori_produk_id')
                    ->label('Kategori Produk')
                    ->relationship('kategori', 'nama_kategori')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_produk')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('deskripsi_produk')->limit(50),
                Tables\Columns\TextColumn::make('kategori.nama_kategori')->label('Kategori')->sortable(),
                Tables\Columns\ImageColumn::make('gambar_produk')->circular()
                    ->label('Gambar')
                    ->disk('public')
                    ->square()
                    ->width(100)
                    ->height(100),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListProduks::route('/'),
            'create' => Pages\CreateProduk::route('/create'),
            'edit' => Pages\EditProduk::route('/{record}/edit'),
        ];
    }
}
