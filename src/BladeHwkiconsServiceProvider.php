<?php

declare(strict_types=1);

namespace Aleex1848\BladeHwkicons;

use BladeUI\Icons\Factory;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;

final class BladeHwkiconsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerConfig();

        $this->callAfterResolving(Factory::class, function (Factory $factory, Container $container) {
            $config = $container->make('config')->get('blade-hwkicons', []);

            $factory->add('hwkicons', array_merge(['path' => __DIR__.'/../resources/svg'], $config));
        });
    }

    private function registerConfig(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/blade-hwkicons.php', 'blade-hwkicons');
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../resources/svg' => public_path('vendor/blade-hwkicons'),
            ], 'blade-hwkicons');

            $this->publishes([
                __DIR__.'/../config/blade-hwkicons.php' => $this->app->configPath('blade-hwkicons.php'),
            ], 'blade-hwkicons-config');
        }
    }
}
