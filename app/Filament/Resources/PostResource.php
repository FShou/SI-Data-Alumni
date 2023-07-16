<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

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
            Card::make()->schema([
                FileUpload::make('foto_post')
                    ->required()
                    ->image(),
            ]),
            Card::make()
                ->schema([
                    // ...
                    TextInput::make('judul_post')
                        ->label('Judul Post')
                        // ->unique()
                        ->required()
                        ->maxLength(255),
                    Select::make('kategori')

                        ->required()
                        ->searchable()
                        ->options([
                            'Event' => 'Event',
                            'Feedback' => 'Feedback',
                            'Loker' => 'Loker',
                        ]),
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
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->searchable(
                    auth()
                        ->user()
                        ->hasRole('Admin'),
                ),
                Tables\Columns\TextColumn::make('judul_post')->searchable(),
                // Tables\Columns\TextColumn::make('foto_post'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat pada')
                    ->dateTime('d M Y,H:i'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Terakhir diubah')
                    ->dateTime('d M Y,H:i'),
                ToggleColumn::make('approved')->visible(
                    auth()
                        ->user()
                        ->hasRole('Admin'),
                ),
            ])
            ->filters([
                Filter::make('created_at')
                ->form([
                    DatePicker::make('created_from')
                        ->label('Dari Tanggal'),
                    DatePicker::make('created_until')
                        ->label('Sampai Tanggal')])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['created_from'],
                            fn(Builder $query, $date): Builder =>
                                $query->whereDate('created_at', '>=', $date)
                        )
                        ->when(
                            $data['created_until'],
                            fn(Builder $query, $date): Builder =>
                                $query->whereDate('created_at', '<=', $date)
                        );
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
            ])
            ->bulkActions([]);
    }

    public static function getEloquentQuery(): Builder
    {
        return auth()->user()->hasRole('Admin') ?
            parent::getEloquentQuery()->latest() :
            parent::getEloquentQuery()->whereBelongsTo(auth()->user());
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/buat'),
            'edit' => Pages\EditPost::route('/{record}/ubah'),
        ];
    }
}
