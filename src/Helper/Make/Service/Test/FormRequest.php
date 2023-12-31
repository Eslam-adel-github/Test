<?php

namespace EslamDDD\SkelotonPackage\Helper\Make\Service\Test;

<<<<<<< HEAD
use ReflectionClass;
use Illuminate\Support\Str;
use EslamDDD\SkelotonPackage\Helper\Path;
use EslamDDD\SkelotonPackage\Helper\Naming;
use EslamDDD\SkelotonPackage\Helper\Make\Maker;
use EslamDDD\SkelotonPackage\Helper\NamespaceCreator;
use EslamDDD\SkelotonPackage\Helper\Make\Service\Test\Test;
use Illuminate\Validation\ValidationRuleParser;
use Illuminate\Foundation\Http\FormRequest as Request;
use EslamDDD\SkelotonPackage\Helper\Make\Service\Test\FormRequestsTestCasesFactory;
=======
use Eslam\SkelotonPackage\Helper\Make\Maker;
use Eslam\SkelotonPackage\Helper\Path;
use Illuminate\Foundation\Http\FormRequest as Request;
use Illuminate\Support\Str;
>>>>>>> 93eb304d6b785e161e437b08fcd86eddcbeaf2c2

class FormRequest extends Test
{
    private $domain;

    private $formRequestsDirPath;

    private $formRequestDirs;

    private $TestCommand;

    public function __construct(Maker $TestCommand, string $domain)
    {
        $this->domain = $domain;
        $this->formRequestsDirPath = ['App', 'Domain', $domain, 'Http', 'Requests'];
        $this->formRequestDirs = Path::directories(...$this->formRequestsDirPath);
        $this->TestCommand = $TestCommand;
    }

    public function generate()
    {
        foreach ($this->formRequestDirs as $formRequestDir) {
            $formRequests = Path::files(...array_merge($this->formRequestsDirPath, [$formRequestDir]));

            foreach ($formRequests as $formRequest) {
                $formRequestInstance = $this->instantiateJustCreated(array_merge($this->formRequestsDirPath, [$formRequestDir]), $formRequest);
                // $this->entityInstance = $this->instantiateJustCreated($this->entitiesDirPath, $entity);
                // $entityNameSpace = join('\\', array_merge($this->entitiesDirPath, [$entity]));
                // $this->entityRecord = factory($entityNameSpace)->make([
                // 'id' => 1,
                // ]);
                // $resourceInstance = $this->instantiateJustCreated(array_merge($this->resourcesDirPath, [$entity]), $resource, $this->entityRecord);

                $this->createBasicTestCases($formRequestInstance);

                $placeholders = [
                    '{{REQUEST_LC}}' => Str::lower($formRequest).'FormRequest',
                    '{{REQUEST}}' => $formRequest.'FormRequest',
                    '{{DOMAIN}}' => $this->domain,
                    '{{TESTCASES}}' => $this->testCases['basic'],
                    // '{{JWTMETHODS}}' => $this->createJWTMethods(),
                    // '{{SETUP}}' => $this->createSetupMethod($formRequest)
                ];
                dd($placeholders);
                $dir = Path::toDomain($this->domain, 'Tests', 'Unit', 'Entities');

                if (! File::isDirectory($dir)) {
                    File::makeDirectory($dir);
                }

                $content = Str::of($this->TestCommand->getStub('resource-test'))
                    ->replace(array_keys($placeholders), array_values($placeholders));

                $classFullName = $resource.'Test';

                $this->TestCommand->save($dir, $classFullName, 'php', $content);
            }
        }
    }

    protected function createRulesTestCases(Request $formRequest)
    {
        foreach ($formRequest->rules() as $fieldRules) {
            $content = [];

            if (is_string($fieldRules)) {
                $fieldRules = explode('|', $fieldRules);
            }

            foreach ($fieldRules as $fieldRule) {
                $testCases = new FormRequestsTestCasesFactory($fieldRule);
                $testCases->make();
                array_push($content, $testCases->make());
            }

            return implode("\n", $content);
        }
    }
}
