<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProdukResource\Pages;
use App\Models\Produk;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\Stack;
use Filament\Forms\Components\Card;

class ProdukResource extends Resource
{
    protected static ?string $model = Produk::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
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
                        Forms\Components\TextInput::make('harga')
                            ->label('Harga')
                            ->required()
                            ->numeric()
                            ->prefix('Rp'),
                        Forms\Components\Select::make('ukuran')
                            ->label('Ukuran')
                            ->required()
                            ->options([
                                'S' => 'Small',
                                'M' => 'Medium',
                                'L' => 'Large',
                                'XL' => 'Extra Large'
                            ]),
                        Forms\Components\Select::make('kategori_produk_id')
                            ->label('Kategori Produk')
                            ->relationship('kategori', 'nama_kategori')
                            ->required()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('nama_kategori')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\Textarea::make('deskripsi_kategori')
                                    ->maxLength(65535),
                            ])
                            ->searchable(),
                    ])
                    ->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('gambar_produk')
                    ->label('Gambar')
                    ->disk('public')
                    ->square()
                    ->width(100)
                    ->height(100),
                Tables\Columns\TextColumn::make('nama_produk')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('harga')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('ukuran')
                    ->badge()
                    ->color('warning'),
                Tables\Columns\TextColumn::make('kategori.nama_kategori')
                    ->label('Kategori')
                    ->badge()
                    ->color('success')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kategori')
                    ->relationship('kategori', 'nama_kategori'),
                Tables\Filters\SelectFilter::make('ukuran')
                    ->options([
                        'S' => 'Small',
                        'M' => 'Medium',
                        'L' => 'Large',
                        'XL' => 'Extra Large'
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
