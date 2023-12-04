<?php

namespace Eslam\SkelotonPackage;

use Eslam\SkelotonPackage\Commands\SkelotonPackageCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class SkelotonPackageServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('skeloton-package')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_skeloton-package_table')
            ->hasCommand(SkelotonPackageCommand::class);
    }
}
