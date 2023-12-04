<?php

namespace EslamDDD\SkelotonPackage\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \EslamDDD\SkelotonPackage\SkelotonPackage
 */
class SkelotonPackage extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \EslamDDD\SkelotonPackage\SkelotonPackage::class;
    }
}
