<?php

namespace Thoughtco\BlurHash;

use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    protected $tags = [
        Tags\BlurHash::class,
    ];
}