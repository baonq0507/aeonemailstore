<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LevelResource\Pages;
use App\Filament\Resources\LevelResource\RelationManagers;
use App\Models\Level;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\ActionGroup;

class LevelResource extends Resource
{
    protected static ?string $model = Level::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Quản lý';

    public static ?string $label = 'Cấp độ';

    public static ?string $navigationLabel = 'Cấp độ';

    public static function getEloquentQuery(): Builder
    {
        return Level::query()->orderByDesc('min_balance');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Thông tin cấp độ')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->label('Tên cấp độ'),
                        TextInput::make('min_balance')
                            ->required()
                            ->label('Số dư tối thiểu'),
                        TextInput::make('order')
                            ->required()
                            ->label('Số đơn hàng'),
                        TextInput::make('commission')
                            ->required()
                            ->numeric()
                            ->step(0.01)
                            ->prefix('%')
                            ->label('Tỷ lệ hoa hồng'),
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
                    ->label('Tên cấp độ'),
                TextColumn::make('min_balance')
                    ->sortable()
                    ->label('Số dư tối thiểu'),
                TextColumn::make('order')
                    ->sortable()
                    ->label('Số đơn hàng'),
                TextColumn::make('commission')
                    ->sortable()
                    ->label('Tỷ lệ hoa hồng'),
            ])
            ->filters([
                //
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
            'index' => Pages\ListLevels::route('/'),
            'create' => Pages\CreateLevel::route('/create'),
            'edit' => Pages\EditLevel::route('/{record}/edit'),
        ];
    }
}
