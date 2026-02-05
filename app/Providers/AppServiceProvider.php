<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        seo()
            ->site('My Website Name') // Site name
            ->title(
                default: 'My Website Name',
                modify: fn (string $title) => $title . ' | My Website'
            )
            ->description(default: 'Welcome to my Laravel website.')
            ->image(default: asset('images/seo-cover.jpg')) // Default share image
            ->twitter() // ✅ ENABLE TWITTER CARDS
            ->twitterSite('@yourusername') // Twitter @site
            ->twitterCreator('@yourusername') // Twitter @creator
            ->withUrl(); // Adds canonical + og:url
    }
}

