<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionWithdrawResource\Pages;
use App\Filament\Resources\TransactionWithdrawResource\RelationManagers;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\ActionGroup;
use Filament\Forms\Components\Section;
use Filament\Notifications\Notification;


class TransactionWithdrawResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Giao dịch';

    protected static ?string $label = 'Giao dịch rút tiền';

    protected static ?string $navigationLabel = 'Giao dịch rút tiền';

    // hiện thị số lượng giao dịch chờ duyệt
    public static function getNavigationBadge(): ?string
    {
        return Transaction::where('status', 'pending')->where('type', 'withdraw')->count();
    }

    //query
    public static function getEloquentQuery(): Builder
    {
        return Transaction::query()->where('type', 'withdraw')->orderBy('created_at', 'desc');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Thông tin giao dịch')
                ->schema([
                    Select::make('user_id')
                    ->label('Người nạp')
                    ->relationship('user', 'full_name'),
                    TextInput::make('amount')
                    ->label('Số tiền')
                    ->numeric()
                        ->required(),
                    Select::make('status')
                    ->label('Trạng thái')
                    ->options([
                        'pending' => 'Chờ xử lý',
                        'success' => 'Thành công',
                        'failed' => 'Thất bại',
                    ]),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.full_name')
                ->label('Người nạp'),
                TextColumn::make('amount')
                ->label('Số tiền')
                ->money('USD'),
                TextColumn::make('status')
                ->label('Trạng thái')
                ->formatStateUsing(fn($state) => match ($state) {
                    'pending' => 'Kiểm duyệt',
                    'success' => 'Thành công',
                    'failed' => 'Thất bại',
                    default => $state,
                })
                    ->badge()
                    ->color(fn($state) => match ($state) {
                        'pending' => 'warning',
                        'success' => 'success',
                        'failed' => 'danger',
                        default => 'secondary',
                    }),
                TextColumn::make('balance_before')
                ->label('Số dư trước')
                ->money('USD'),
                TextColumn::make('balance_after')
                ->label('Số dư sau')
                ->money('USD'),
                TextColumn::make('created_at')
                ->label('Thời gian')
                ->dateTime('d/m/Y H:i'),
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                    //duyệt
                    Tables\Actions\Action::make('approve')
                    ->label('Duyệt')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->action(function ($record) {
                        $record->update(['status' => 'success']);
                        $record->user->update(['balance' => $record->balance_after]);
                        Notification::make()
                            ->title('Thành công')
                            ->body('Duyệt giao dịch thành công')
                            ->success()
                            ->send();
                    })
                        ->visible(fn($record) => $record->status === 'pending'),

                    //thất bại
                    Tables\Actions\Action::make('fail')
                    ->label('Từ chối')
                    ->icon('heroicon-o-x-mark')
                    ->color('danger')
                    ->action(function ($record) {
                        $record->update(['status' => 'failed']);
                        $record->user->update(['balance' => $record->balance_before]);
                        Notification::make()
                            ->title('Thành công')
                            ->body('Từ chối giao dịch thành công')
                            ->success()
                            ->send();
                    })
                        ->visible(fn($record) => $record->status === 'pending'),
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
            'index' => Pages\ListTransactionWithdraws::route('/'),
            'create' => Pages\CreateTransactionWithdraw::route('/create'),
            'edit' => Pages\EditTransactionWithdraw::route('/{record}/edit'),
        ];
    }
}
