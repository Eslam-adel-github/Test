<?php

namespace EslamDDD\SkelotonPackage\Helper\Make\Service\Test;

<<<<<<< HEAD
use Illuminate\Support\Str;
use EslamDDD\SkelotonPackage\Helper\Path;
use EslamDDD\SkelotonPackage\Helper\Make\Maker;
use Illuminate\Support\Facades\File;
use EslamDDD\SkelotonPackage\Helper\Make\Service\Test\Test;
=======
use Eslam\SkelotonPackage\Helper\Make\Maker;
use Eslam\SkelotonPackage\Helper\Path;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
>>>>>>> 93eb304d6b785e161e437b08fcd86eddcbeaf2c2

class RepositoriesEloquent extends Test
{
    private $domain;

    private $TestCommand;

    public function __construct(Maker $TestCommand, string $domain)
    {
        $this->domain = $domain;
        $this->repositoriesDirPath = ['App', 'Domain', $domain, 'Repositories', 'Eloquent'];
        $this->repositories = Path::files(...$this->repositoriesDirPath);
        $this->TestCommand = $TestCommand;
    }

    public function generate()
    {
        foreach ($this->repositories as $repository) {
            $repoInstance = $this->instantiateJustCreated($this->repositoriesDirPath, $repository, app());
            $entity = get_class($repoInstance->getmodel());
            $entityName = collect(explode('\\', $entity))->last();

            $placeholders = [
                '{{REPOSITORY}}' => $repository,
                '{{ENTITY}}' => $entityName,
                '{{ENTITY_LC}}' => Str::lower($entityName),
                '{{DOMAIN}}' => $this->domain,
            ];

            $dir = Path::toDomain($this->domain, 'Tests', 'Unit', 'Repositories', 'Eloquent');

            if (! File::isDirectory($dir)) {
                File::makedirectory($dir, 0755, true, true);
            }

            $content = Str::of($this->TestCommand->getStub('repository-eloquent-test'))
                ->replace(array_keys($placeholders), array_values($placeholders));

            $classFullName = $repository.'Test';

            $this->TestCommand->save($dir, $classFullName, 'php', $content);
        }
    }
}
