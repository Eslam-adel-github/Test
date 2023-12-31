<?php

namespace EslamDDD\SkelotonPackage\Helper\Make\Service\Test;

<<<<<<< HEAD
use ReflectionClass;
use ReflectionMethod;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use EslamDDD\SkelotonPackage\Helper\Path;
use EslamDDD\SkelotonPackage\Helper\Naming;
use EslamDDD\SkelotonPackage\Helper\Make\Maker;
use Illuminate\Support\Facades\File;
use EslamDDD\SkelotonPackage\Helper\NamespaceCreator;
use EslamDDD\SkelotonPackage\Helper\Make\Service\Test\Test;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Relation;
=======
use Eslam\SkelotonPackage\Helper\Make\Maker;
use Eslam\SkelotonPackage\Helper\NamespaceCreator;
use Eslam\SkelotonPackage\Helper\Path;
use Illuminate\Support\Str;
use ReflectionClass;
>>>>>>> 93eb304d6b785e161e437b08fcd86eddcbeaf2c2

class EntitiesRelations extends Test
{
    private $domain;

    private $realtionsDirPath;

    private $entityShortName;

    private $relationshipMethods;

    private $TestCommand;

    public function __construct(Maker $TestCommand, string $domain)
    {
        $this->domain = $domain;
        $this->realtionsDirPath = ['App', 'Domain', $domain, 'Entities', 'Traits', 'Relations'];
        $this->realtions = Path::files(...$this->realtionsDirPath);
        $this->TestCommand = $TestCommand;
    }

    public function generate()
    {
        foreach ($this->realtions as $realtion) {
            $realtionNameSpace = NamespaceCreator::segments(
                ...array_merge($this->realtionsDirPath, [$realtion])
            );

            // assign anonymous class that use the relationship tarit to global variable model
            eval(Str::of($this->TestCommand->getStub('entity-relations-anonymous-class'))
                ->replace(['{{RealtionshipNameSpace}}'], [$realtionNameSpace]));

            $this->relationshipMethods = $this->relationMethods();
            $this->createBasicTestCases();

            $placeholders = [
                '{{Relation}}' => $realtion,
                '{{DOMAIN}}' => $this->domain,
                '{{TESTCASES}}' => $this->testCases['basic'],
            ];

            $dir = Path::toDomain($this->domain, 'Tests', 'Unit', 'Entities', 'Traits', 'Relations');
            $content = Str::of($this->TestCommand->getStub('entity-relations-test'))
                ->replace(array_keys($placeholders), array_values($placeholders));
            $classFullName = $realtion.'Test';
            $this->TestCommand->save($dir, $classFullName, 'php', $content);
        }
    }

    public function relationMethods()
    {
        $relationClassReflection = new ReflectionClass($this->relationClass);
        $relationTrait = array_values($relationClassReflection->getTraits())[0];

        return $relationTrait->getmethods();
    }

    protected function createRelationTestCases()
    {
        $content = [];
        foreach ($this->relationshipMethods as $method) {
            $testCases = new RelationsTestCasesFactory($this->TestCommand, $this->relationClass, $method->name);
            array_push($content, $testCases->make());
        }

        return implode("\n", $content);
    }
}
