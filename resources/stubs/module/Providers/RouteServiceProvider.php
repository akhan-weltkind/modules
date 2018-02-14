<?php

namespace App\Modules\DummyName\Providers;

use App\Modules\Admin\Providers\BaseAdminRouteServiceProvider;

class RouteServiceProvider extends BaseAdminRouteServiceProvider
{
    protected $namespace = 'App\Modules\DummyName\Http\Controllers';

    protected $module    = 'DummySlug';
}