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

class Repo extends Maker
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

        $name = $values['name'];

        $placeholders = [
            '{{DOMAIN}}' => $values['domain'],
            '{{NAME}}' => Naming::class($name),
            '{{ENTITY}}' => Naming::class($values['entity']),
        ];

        // Create Contract
        $contract_className = Naming::class($name).'Repository';

        $destination = Path::toDomain($values['domain'], 'Repositories', 'Contracts');

        $content = Str::of($this->getStub('contract'))
            ->replace(array_keys($placeholders), array_values($placeholders));

        $this->save($destination, $contract_className, 'php', $content);

        // Create Eloquent
        $eloquent_className = Naming::class($name).'Repository'.'Eloquent';

        $destination = Path::toDomain($values['domain'], 'Repositories', 'Eloquent');

        $content = Str::of($this->getStub('eloquent'))
            ->replace(array_keys($placeholders), array_values($placeholders));
        $this->save($destination, $eloquent_className, 'php', $content);

        $contract = NamespaceCreator::Segments('Src', 'Domain', $values['domain'], 'Repositories', 'Contracts', $contract_className);
        $eloquent = NamespaceCreator::Segments('Src', 'Domain', $values['domain'], 'Repositories', 'Eloquent', $eloquent_className);

        $RepositoryServiceProviderPath = Path::toDomain($values['domain'], 'Providers', 'RepositoryServiceProvider.php');

        $RepositoryServiceProviderContent = Str::of(File::get($RepositoryServiceProviderPath))->replace(
            '###REPOSITORIES_PLACEHOLDER###',
            "$contract::class => $eloquent::class,\n\t\t\t###REPOSITORIES_PLACEHOLDER###"
        );
        $this->save(
            Path::toDomain($values['domain'], 'Providers'),
            'RepositoryServiceProvider',
            'php',
            $RepositoryServiceProviderContent
        );

        return true;
    }
}
