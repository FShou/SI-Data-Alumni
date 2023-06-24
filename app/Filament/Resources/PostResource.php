<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationGroup = 'Akun';
    protected static ?string $navigationLabel = 'Post';
    protected static ?string $pluralModelLabel = 'post';
    protected static ?string $slug = 'post';
    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            // Forms\Components\TextInput::make('id_user')->required(),
            Card::make()
                ->schema([
                    // ...
                    TextInput::make('judul_post')
                    ->label('Judul Post')
                    ->unique()
                    ->required()
                    ->maxLength(255),
                    Forms\Components\Textarea::make('isi')
                        ->required()
                ->rows(15)
                ->maxLength(65535),
                    Toggle::make('approved')->visible(
                        auth()
                            ->user()
                            ->hasRole('Admin'),
                    ),
                ])
                ->columns(1),

            Card::make()
            ->schema([
FileUpload::make('foto_post')
                ->required()
                ->image(),
            ])
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name'),
                Tables\Columns\TextColumn::make('isi'),
                Tables\Columns\TextColumn::make('foto_post'),
                Tables\Columns\TextColumn::make('created_at')->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')->dateTime(),
                ToggleColumn::make('approved')->visible(
                    auth()
                        ->user()
                        ->hasRole('Admin'),
                ),
            ])
            ->filters([
                //
            ])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
    }

    public static function getEloquentQuery(): Builder
    {
        if (
            !auth()
                ->user()
                ->hasRole('Admin')
        ) {
            return parent::getEloquentQuery()->whereBelongsTo(auth()->user());
        }
        return parent::getEloquentQuery();
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
