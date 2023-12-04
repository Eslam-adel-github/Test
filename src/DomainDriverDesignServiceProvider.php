<?php

namespace EslamDDD\SkelotonPackage;

<<<<<<< HEAD
use EslamDDD\SkelotonPackage\Make;
use EslamDDD\SkelotonPackage\Build;
use EslamDDD\SkelotonPackage\Directory;
=======
>>>>>>> 93eb304d6b785e161e437b08fcd86eddcbeaf2c2
use Illuminate\Support\ServiceProvider;

class DomainDriverDesignServiceProvider extends ServiceProvider
{
    protected $commands = [
        Directory::class,
        Make::class,
    ];

    public function boot()
    {
        $this->setConfigs();
        $this->setCommands();
    }

    public function register()
    {

    }

    private function setConfigs()
    {
        $this->publishes([
            __DIR__.'/../config/ddd.php' => config_path('ddd.php'),
        ]);

        $this->mergeConfigFrom(__DIR__.'/../config/ddd.php', 'ddd');
    }

    private function setCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands($this->commands);
        }
    }
}
