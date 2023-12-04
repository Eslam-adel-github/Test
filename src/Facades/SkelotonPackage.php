<?php

namespace Eslam\SkelotonPackage\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Eslam\SkelotonPackage\SkelotonPackage
 */
class SkelotonPackage extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Eslam\SkelotonPackage\SkelotonPackage::class;
    }
}
