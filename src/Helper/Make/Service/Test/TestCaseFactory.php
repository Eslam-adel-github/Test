<?php

namespace EslamDDD\SkelotonPackage\Helper\Make\Service\Test;

<<<<<<< HEAD
use Illuminate\Support\Str;
use EslamDDD\SkelotonPackage\Helper\Path;
use EslamDDD\SkelotonPackage\Helper\ArrayFormatter;
use EslamDDD\SkelotonPackage\Helper\NamespaceCreator;
use ReflectionClass;
=======
use Eslam\SkelotonPackage\Helper\NamespaceCreator;
>>>>>>> 93eb304d6b785e161e437b08fcd86eddcbeaf2c2

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
