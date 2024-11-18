<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ConfigResource\Pages;
use App\Filament\Resources\ConfigResource\RelationManagers;
use App\Models\Config;
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
class ConfigResource extends Resource
{
    protected static ?string $model = Config::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Cấu hình';

    protected static ?string $label = 'Cấu hình';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->orderBy('created_at', 'desc');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Cấu hình')
                    ->schema([
                        TextInput::make('key')
                            ->required()
                            ->label('Phí rút tiền')
                            ->visible(fn(Config $config) => $config->key === 'withdraw_fee'),
                        TextInput::make('key')
                            ->required()
                            ->label('Phí nạp tiền')
                            ->visible(fn(Config $config) => $config->key === 'deposit_fee'),
                        TextInput::make('key')
                            ->required()
                            ->label('Số tiền rút tối thiểu')
                            ->visible(fn(Config $config) => $config->key === 'min_withdraw'),
                        TextInput::make('key')
                            ->required()
                            ->label('Số tiền rút tối đa')
                            ->visible(fn(Config $config) => $config->key === 'max_withdraw'),
                        TextInput::make('key')
                            ->required()
                            ->label('Số tiền nạp tối thiểu')
                            ->visible(fn(Config $config) => $config->key === 'min_deposit'),
                        TextInput::make('key')
                            ->required()
                            ->label('Số tiền nạp tối đa')
                            ->visible(fn(Config $config) => $config->key === 'max_deposit'),
                        TextInput::make('key')
                            ->required()
                            ->label('Tên website')
                            ->visible(fn(Config $config) => $config->key === 'name_website'),
                        TextInput::make('key')
                            ->required()
                            ->label('Tiêu đề website')
                            ->visible(fn(Config $config) => $config->key === 'title_website'),
                        TextInput::make('key')
                            ->required()
                            ->label('Mô tả website')
                            ->visible(fn(Config $config) => $config->key === 'description_website'),
                        TextInput::make('key')
                            ->required()
                            ->label('Live chat ID')
                            ->visible(fn(Config $config) => $config->key === 'livechat_id'),
                        TextInput::make('key')
                            ->required()
                            ->label('Telegram Token')
                            ->readOnly()
                            ->visible(fn(Config $config) => $config->key === 'telegram_token'),
                        TextInput::make('key')
                            ->required()
                            ->label('Tên cấu hình')
                            ->visible(fn(Config $config) => is_null($config->id))
                            ->required(fn(Config $config) => is_null($config->id)),
                        TextInput::make('value')
                            ->required()
                            ->label('Giá trị'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('key')
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(fn($state) => match ($state) {
                        'withdraw_fee' => 'Phí rút tiền',
                        'deposit_fee' => 'Phí nạp tiền',
                        'min_withdraw' => 'Số tiền rút tối thiểu',
                        'max_withdraw' => 'Số tiền rút tối đa',
                        'min_deposit' => 'Số tiền nạp tối thiểu',
                        'max_deposit' => 'Số tiền nạp tối đa',
                        'name_website' => 'Tên website',
                        'title_website' => 'Tiêu đề website',
                        'description_website' => 'Mô tả website',
                        'livechat_id' => 'Live chat ID',
                        default => $state,
                    })
                    ->label('Tên cấu hình'),
                TextColumn::make('value')
                    ->searchable()
                    ->sortable()
                    ->label('Giá trị'),
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
            'index' => Pages\ListConfigs::route('/'),
            'create' => Pages\CreateConfig::route('/create'),
            'edit' => Pages\EditConfig::route('/{record}/edit'),
        ];
    }
}
