<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Filters\SelectFilter;
use App\Models\ProductUser;
class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Quản lý';

    protected static ?string $navigationLabel = 'Sản phẩm';

    protected static ?string $label = 'Sản phẩm';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Thông tin sản phẩm')
                    ->schema([
                        TextInput::make('name')
                            ->label('Tên sản phẩm')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('price')
                            ->label('Giá')
                            ->required()
                            ->numeric(),
                        Select::make('level_id')
                            ->label('Cấp độ')
                            ->relationship('level', 'name')
                            ->required(),
                        TextInput::make('image')
                            ->label('Ảnh')
                            ->required()
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->limit(50)
                    ->label('Tên sản phẩm'),
                TextColumn::make('price')
                    ->searchable()
                    ->label('Giá'),

                TextColumn::make('level.name')
                    ->searchable()
                    ->label('Cấp độ'),
                ImageColumn::make('image')
                    ->label('Ảnh'),
            ])
            ->filters([
                SelectFilter::make('level_id')
                    ->label('Cấp độ')
                    ->relationship('level', 'name'),
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make()
                        ->before(function (Product $record) {
                            ProductUser::where('product_id', $record->id)->delete();
                        }),
                ]),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
