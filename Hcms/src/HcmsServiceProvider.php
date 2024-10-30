<?php

declare(strict_types=1);

namespace App\Hcms\src;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class HcmsServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        $this->loadMigrationsFrom(base_path('app/Hcms/src/Database/migrations'));
        View::addNamespace('hcms', base_path('app/Hcms/src/resources/views'));
    }
}
