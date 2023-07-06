<?php

namespace App\Filament\Widgets;

use App\Models\Post;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class UserStatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        $post = Post::where('id_user', 'like', auth()->id())->count();
        return [
            //
            Card::make('Total Post', $post),
        ];
    }
    public static function canView(): bool
    {
        return auth()
            ->user()
            ->hasRole('Alumni');
    }
}
