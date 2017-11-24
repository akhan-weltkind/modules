<?php

namespace Akhan\Modules\Providers;

use Illuminate\Support\ServiceProvider;

class GeneratorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $generators = [
            'command.make.module'            => \Akhan\Modules\Console\Generators\MakeModuleCommand::class,
            'command.make.module.controller' => \Akhan\Modules\Console\Generators\MakeControllerCommand::class,
            'command.make.module.middleware' => \Akhan\Modules\Console\Generators\MakeMiddlewareCommand::class,
            'command.make.module.migration'  => \Akhan\Modules\Console\Generators\MakeMigrationCommand::class,
            'command.make.module.model'      => \Akhan\Modules\Console\Generators\MakeModelCommand::class,
            'command.make.module.policy'     => \Akhan\Modules\Console\Generators\MakePolicyCommand::class,
            'command.make.module.provider'   => \Akhan\Modules\Console\Generators\MakeProviderCommand::class,
            'command.make.module.request'    => \Akhan\Modules\Console\Generators\MakeRequestCommand::class,
            'command.make.module.seeder'     => \Akhan\Modules\Console\Generators\MakeSeederCommand::class,
            'command.make.module.test'       => \Akhan\Modules\Console\Generators\MakeTestCommand::class,
        ];

        foreach ($generators as $slug => $class) {
            $this->app->singleton($slug, function ($app) use ($slug, $class) {
                return $app[$class];
            });

            $this->commands($slug);
        }
    }
}
