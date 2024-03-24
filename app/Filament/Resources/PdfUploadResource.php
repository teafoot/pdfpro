<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PdfUploadResource\Pages;
use App\Filament\Resources\PdfUploadResource\RelationManagers;
use App\Models\PdfUpload;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PdfUploadResource extends Resource
{
    protected static ?string $model = PdfUpload::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('original_filename')
                    ->required()
                    ->label('Original Filename'),
                Forms\Components\TextInput::make('file_path')
                    ->required()
                    ->label('File Path'),
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'processing' => 'Processing',
                        'completed' => 'Completed',
                        'failed' => 'Failed',
                    ])
                    ->required()
                    ->label('Status'),
                // If you want to allow the admin to change the user associated with the upload:
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name') // Replace 'name' with the actual user name field
                    ->searchable()
                    ->label('User'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Tables\Columns\TextColumn::make('original_filename'),
                // Tables\Columns\TextColumn::make('file_path'),
                // Tables\Columns\TextColumn::make('status'),

                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                Tables\Columns\TextColumn::make('original_filename')
                    ->label('Original Filename')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('file_path')
                    ->label('File Path')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name') // Replace 'name' with the actual user name field
                    ->label('Uploaded By')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Uploaded At')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->date()
                    ->sortable(),
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
            ])->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListPdfUploads::route('/'),
            'create' => Pages\CreatePdfUpload::route('/create'),
            'edit' => Pages\EditPdfUpload::route('/{record}/edit'),
        ];
    }
}
