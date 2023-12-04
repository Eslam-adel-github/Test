<?php

namespace EslamDDD\SkelotonPackage\Helper\Make\Service\Test;

<<<<<<< HEAD
use Illuminate\Support\Str;
use EslamDDD\SkelotonPackage\Helper\Path;
use EslamDDD\SkelotonPackage\Helper\Naming;
use Src\Domain\User\Entities\User;
use EslamDDD\SkelotonPackage\Helper\Make\Maker;
use Illuminate\Support\Facades\File;
use EslamDDD\SkelotonPackage\Helper\NamespaceCreator;
use EslamDDD\SkelotonPackage\Helper\Make\Service\Test\Test;
=======
use Eslam\SkelotonPackage\Helper\Make\Maker;
use Eslam\SkelotonPackage\Helper\Path;
>>>>>>> 93eb304d6b785e161e437b08fcd86eddcbeaf2c2
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;
use ReflectionClass;

class Resources extends Test
{
    private $domain;

    private $entitiesDirPath;

    private $entities;

    private $entityInstance;

    private $entityShortName;

    private $TestCommand;

    public function __construct(Maker $TestCommand, string $domain)
    {
        $this->domain = $domain;
        $this->resourcesDirPath = ['App', 'Domain', $domain, 'Http', 'Resources'];
        $this->entitiesDirPath = ['App', 'Domain', $domain, 'Entities'];
        $this->entities = Path::directories(...$this->resourcesDirPath);
        $this->TestCommand = $TestCommand;
    }

    public function generate()
    {
        foreach ($this->entities as $entity) {
            $resource = $entity.'Resource';
            $this->entityInstance = $this->instantiateJustCreated($this->entitiesDirPath, $entity);
            $entityNameSpace = implode('\\', array_merge($this->entitiesDirPath, [$entity]));
            $this->entityRecord = factory($entityNameSpace)->make([
                'id' => 1,
            ]);
            $resourceInstance = $this->instantiateJustCreated(array_merge($this->resourcesDirPath, [$entity]), $resource, $this->entityRecord);

            $this->createBasicTestCases($resourceInstance);

            $placeholders = [
                '{{RESOURCE}}' => $resource,
                '{{ENTITY}}' => $entity,
                '{{DOMAIN}}' => $this->domain,
                '{{TESTCASES}}' => $this->testCases['basic'],
                // '{{JWTMETHODS}}' => $this->createJWTMethods(),
                '{{SETUP}}' => $this->createSetupMethod($entity),
            ];

            $dir = Path::toDomain($this->domain, 'Tests', 'Unit', 'Entities');

            $content = Str::of($this->TestCommand->getStub('resource-test'))
                ->replace(array_keys($placeholders), array_values($placeholders));

            $classFullName = $resource.'Test';

            $this->TestCommand->save($dir, $classFullName, 'php', $content);
        }
    }

    protected function createNormalresource(JsonResource $resourceInstance)
    {
        $resource = explode('\\', get_class($resourceInstance));
        $entity = explode('\\', get_class($this->entityInstance));

        $placeholders = [
            '{{RESOURCE}}' => end($resource),
            '{{RSOURCE_CC}}' => Str::camel(end($resource)),
            '{{CONTENT}}' => implode('","', array_keys($resourceInstance->resolve())),
            '{{ENTITY_LC}}' => Str::lower(end($entity)),
        ];

        return Str::of($this->TestCommand->getStub('resource-normal-test'))
            ->replace(array_keys($placeholders), array_values($placeholders));
    }

    public function createRelationships(JsonResource $resourceInstance)
    {
        dd(new ReflectionClass($resourceInstance));
    }

    public function createSetupMethod(string $entity)
    {
        $placeholders = [
            '{{ENTITY_LC}}' => Str::lower($entity),
            '{{ENTITY}}' => Str::ucfirst($entity),
            '{{RESOURCE_CC}}' => Str::lower($entity).'Resource',
            '{{RESOURCE}}' => $entity.'Resource',
        ];

        return Str::of($this->TestCommand->getStub('entity-setup-method'))->replace(array_keys($placeholders), array_values($placeholders));
    }
}
