<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;
use App\Models\Category;
use App\Models\Transaction;
use Filament\Actions\DeleteAction;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransactionResource extends Resource
{
  protected static ?string $model = Transaction::class;

  protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        TextInput::make('name')
          ->required()
          ->maxLength(255),
        Select::make('category_id')
          ->required()
          ->options(Category::all()->pluck('name', 'id'))
          ->searchable(),
        DatePicker::make('date')
          ->required(),
        TextInput::make('amount')
          ->required()
          ->numeric(),
        Textarea::make('note')
          ->required()
          ->columnSpanFull(),
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        Tables\Columns\ImageColumn::make('category.image')
          ->label(''),
        TextColumn::make('category.name')
          ->description(fn (Transaction $record): string => $record->name)
          ->searchable(),
        Tables\Columns\IconColumn::make('category.is_expenses')
          ->boolean()
          ->trueIcon('heroicon-o-arrow-up-circle')
          ->falseIcon('heroicon-o-arrow-down-circle')
          ->trueColor('danger')
          ->falseColor('success')
          ->label('Tipe'),
        TextColumn::make('amount')
          ->numeric()
          ->money('Rp. ', locale: 'id')
          ->sortable(),
        TextColumn::make('date')
          ->date()
          ->label('Tanggal')
          ->sortable(),
        TextColumn::make('created_at')
          ->dateTime()
          ->sortable()
          ->toggleable(isToggledHiddenByDefault: true),
        TextColumn::make('updated_at')
          ->dateTime()
          ->sortable()
          ->toggleable(isToggledHiddenByDefault: true),
      ])
      ->filters([
        //
      ])
      ->actions([
        Tables\Actions\EditAction::make(),
        Tables\Actions\DeleteAction::make(),
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
      'index' => Pages\ListTransactions::route('/'),
      'create' => Pages\CreateTransaction::route('/create'),
      'edit' => Pages\EditTransaction::route('/{record}/edit'),
    ];
  }
}
