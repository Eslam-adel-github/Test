<?php

namespace Eslam\SkelotonPackage\Helper\Make\Service\Test;

use Illuminate\Support\Str;
use Eslam\SkelotonPackage\Helper\Path;
use Eslam\SkelotonPackage\Helper\ArrayFormatter;
use Eslam\SkelotonPackage\Helper\NamespaceCreator;
use ReflectionClass;

class TestCaseFactory
{

    public static function __callStatic($testClass, $args)
    {
        $TestCommand = $args[0];
        $domain = $args[1];

        preg_match('#^generate(.*)#', $testClass, $matches);

        $testClassNameSpace = NamespaceCreator::Segments('MohamedReda', 'DDD', 'Helper', 'Make', 'Service', 'Test', $matches[1]);

        $testClass = new $testClassNameSpace($TestCommand, $domain);
        $testClass->generate();
    }
}
