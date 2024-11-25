<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductUserResource\Pages;
use App\Filament\Resources\ProductUserResource\RelationManagers;
use App\Models\ProductUser;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Str;
use Filament\Forms\Components\Actions\ButtonAction;
class ProductUserResource extends Resource
{
    protected static ?string $model = ProductUser::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Quản lý';

    protected static ?string $navigationLabel = 'Nhiệm vụ';

    public static ?string $label = 'Nhiệm vụ';

    public static function getEloquentQuery(): Builder
    {
        return ProductUser::query()->orderBy('created_at', 'desc');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Thông tin nhiệm vụ')
                    ->schema([
                        TextInput::make('order_code')
                            ->label('Mã đơn hàng')
                            ->suffixAction(function () {
                                return Forms\Components\Actions\ButtonAction::make('random')
                                    ->label('Random')
                                    ->action(function ($state, $set) {
                                        $set('order_code', Str::random(10));
                                    });
                            }),
                        Select::make('user_id')
                            ->label('Người thực hiện')
                            ->relationship('user', 'full_name'),
                        Select::make('product_id')
                            ->label('Sản phẩm')
                            ->relationship('product', 'name'),
                        Select::make('status')
                            ->label('Trạng thái')
                            ->options([
                                'pending' => 'Chờ thực hiện',
                                'completed' => 'Đã thực hiện',
                                'failed' => 'Thất bại',
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order_code')
                    ->label('Mã đơn hàng'),
                TextColumn::make('user.full_name')
                    ->searchable()
                    ->sortable()
                    ->label('Người thực hiện'),
                TextColumn::make('product.name')
                    ->searchable()
                    ->sortable()
                    ->label('Sản phẩm'),
                TextColumn::make('before_balance')
                    ->label('Số dư trước'),
                TextColumn::make('after_balance')
                    ->label('Số dư sau'),
                TextColumn::make('status')
                    ->label('Trạng thái')
                    ->formatStateUsing(fn ($state) => $state === 'pending' ? 'Chờ thực hiện' : ($state === 'completed' ? 'Đã thực hiện' : 'Thất bại'))
                    ->badge(),
            ])
            ->filters([
                //filter by user
                SelectFilter::make('user_id')
                    ->label('Người thực hiện')
                    ->relationship('user', 'full_name'),
                SelectFilter::make('status')
                    ->label('Trạng thái')
                    ->options([
                        'pending' => 'Chờ thực hiện',
                        'completed' => 'Đã thực hiện',
                        'failed' => 'Thất bại',
                    ]),
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListProductUsers::route('/'),
            'create' => Pages\CreateProductUser::route('/create'),
            'edit' => Pages\EditProductUser::route('/{record}/edit'),
        ];
    }
}
