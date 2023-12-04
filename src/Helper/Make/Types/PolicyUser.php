<?php

namespace EslamDDD\SkelotonPackage\Helper\Make\Types;

<<<<<<< HEAD
use EslamDDD\SkelotonPackage\Helper\FileCreator;
use EslamDDD\SkelotonPackage\Helper\Make\Maker;
use EslamDDD\SkelotonPackage\Helper\NamespaceCreator;
use EslamDDD\SkelotonPackage\Helper\Naming;
use EslamDDD\SkelotonPackage\Helper\Path;
=======
use Eslam\SkelotonPackage\Helper\Make\Maker;
use Eslam\SkelotonPackage\Helper\NamespaceCreator;
use Eslam\SkelotonPackage\Helper\Naming;
use Eslam\SkelotonPackage\Helper\Path;
>>>>>>> 93eb304d6b785e161e437b08fcd86eddcbeaf2c2
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PolicyUser extends Maker
{
    /**
     * Options to be available once Command-Type is called
     *
     * @return array
     */
    public $options = [
        'name',
        'domain',
        'entity',
    ];

    /**
     * Return options that should be treated as choices
     *
     * @return array
     */
    public $allowChoices = [
        'domain',
        'entity',
    ];

    /**
     * Check if the current options is True/False question
     *
     * @return array
     */
    public $booleanOptions = [];

    /**
     * Check if the current options is requesd based on other option
     *
     * @return array
     */
    public $requiredUnless = [];

    /**
     * Fill all placeholders in the stub file
     */
    public function service(array $values = []): bool
    {

        $name = Naming::class($values['name']);

        $placeholders = [
            '{{NAME}}' => $name,
            '{{DOMAIN}}' => $values['domain'],
            '{{ENTITY}}' => $values['entity'],
            '{{ENTITY_LC}}' => Str::lower($values['entity']),
        ];

        $dir = Path::toDomain($values['domain'], 'Policies');

        if (! File::isDirectory($dir)) {
            File::makeDirectory($dir);
        }

        $content = Str::of($this->getStub('policy_user'))
            ->replace(array_keys($placeholders), array_values($placeholders));

        $this->save($dir, $name, 'php', $content);

        $ServiceProviderPath = Path::toDomain($values['domain'], 'Providers');

        $content = File::get(Path::build($ServiceProviderPath, 'PolicyServiceProvider.php'));

        $entity_namespace = NamespaceCreator::Segments('Src', 'Domain', $values['domain'], 'Entities', $values['entity']);
        $policy_namespace = NamespaceCreator::Segments('Src', 'Domain', $values['domain'], 'Policies', $name);

        $policyServiceProviderContent = Str::of($content)->replace(
            '###POLICIES###',
            "$entity_namespace::class => $policy_namespace::class,\n\t\t###POLICIES###"
        );

        $this->save($ServiceProviderPath, 'PolicyServiceProvider', 'php', $policyServiceProviderContent);

        return true;
    }
}
