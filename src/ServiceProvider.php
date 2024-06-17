<?php

namespace Thoughtco\BlurHash;

use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    protected $tags = [
        Tags\BlurHash::class,
    ];

    public function bootAddon()
    {
        $this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/statamic-blurhash'),
        ], 'statamic-blurhash');
    }
}
