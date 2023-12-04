<?php

namespace EslamDDD\SkelotonPackage\Tests;

use Eslam\SkelotonPackage\SkelotonPackageServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;
<<<<<<< HEAD
use EslamDDD\SkelotonPackage\SkelotonPackageServiceProvider;
=======
>>>>>>> 93eb304d6b785e161e437b08fcd86eddcbeaf2c2

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Eslam\\SkelotonPackage\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            SkelotonPackageServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_skeloton-package_table.php.stub';
        $migration->up();
        */
    }
}
