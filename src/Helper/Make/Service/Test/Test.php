<?php

namespace EslamDDD\SkelotonPackage\Helper\Make\Service\Test;

use Eslam\SkelotonPackage\Helper\NamespaceCreator;
use ReflectionClass;
use ReflectionMethod;
<<<<<<< HEAD
use Illuminate\Support\Str;
use EslamDDD\SkelotonPackage\Helper\ArrayFormatter;
use EslamDDD\SkelotonPackage\Helper\NamespaceCreator;
use EslamDDD\SkelotonPackage\Helper\Path;
use EslamDDD\SkelotonPackage\Helper\Stub;
=======
>>>>>>> 93eb304d6b785e161e437b08fcd86eddcbeaf2c2

abstract class Test
{
    protected $testCases = ['basic' => [], 'keep' => ''];

    abstract protected function generate();

    public function setUp(string $content)
    {
        return "
        public function setUp(): void
        {
            parent::setUp();
            {$content}
        }";
    }

    public function createBasicTestCases(object $testable = null)
    {
        $this->testCases['basic'] = [];
        $basicTestCases = $this->getBaseTestCases();
        $this->formateTestCases('basic', $basicTestCases, $testable);
    }

    private function getBaseTestCases()
    {
        return array_map(
            function ($testCase) {
                return $testCase->name;
            },
            (new ReflectionClass($this))
                ->getMethods(ReflectionMethod::IS_PROTECTED)
        );
    }

    private function formateTestCases(string $containerKey, array $basicTestCases, object $testable = null)
    {

        foreach ($basicTestCases as $testCase) {
            array_push(
                $this->testCases[$containerKey],
                $this->{$testCase}($testable)
            );
        }

        $this->testCases[$containerKey] = implode("\n", $this->testCases[$containerKey]);
    }

    public function instantiateJustCreated(array $dir, $class, ...$args)
    {
        array_push($dir, $class);
        $model = NamespaceCreator::segments(...$dir);

        return new $model(...$args);
    }
}
