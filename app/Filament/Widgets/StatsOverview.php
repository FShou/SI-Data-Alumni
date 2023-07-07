<?php

namespace App\Filament\Widgets;

use App\Models\Alumni;
use App\Models\Post;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        $alumni = Alumni::all()->count();
        $post = Post::where('approved', '=', '0')->count();
        return [
            //
            Card::make('Total Alumni', $alumni)->icon('heroicon-o-academic-cap'),

            Card::make('Post Baru', $post)->icon('heroicon-o-collection'),
        ];
    }
    public static function canView(): bool
    {
        return auth()
            ->user()
            ->hasRole('Admin');
    }
}
