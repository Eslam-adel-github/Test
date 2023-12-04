<?php

namespace Eslam\SkelotonPackage\Helper\Make\Types;

use Eslam\SkelotonPackage\Helper\Make\Maker;
use Eslam\SkelotonPackage\Helper\NamespaceCreator;
use Eslam\SkelotonPackage\Helper\Naming;
use Eslam\SkelotonPackage\Helper\Path;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class Datatable extends Maker
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
     * Fill all placeholders in the stub file
     */
    public function service(array $values = []): bool
    {

        $name = Naming::class($values['name']);
        $domain = Naming::class($values['domain']);
        $entity = Naming::class($values['entity']);

        $file = Naming::class($values['name']).'Datatable';

        $placeholders = [
            '{{NAME}}' => $name,
            '{{DOMAIN}}' => $domain,
            '{{ENTITY}}' => $entity,
        ];

        $destination = Path::toDomain($values['domain'], 'Datatables');

        $content = Str::of($this->getStub('datatable'))->replace(array_keys($placeholders), array_values($placeholders));

        $this->save($destination, $file, 'php', $content);

        $component_key = strtolower(Str::of($values['name'])->replace(' ', '-'));
        $namespace = NamespaceCreator::Segments('App', 'Domain', $domain, 'Datatables', $file);

        $this->buildComponent($component_key, $namespace, $domain);

        return true;
    }

    private function buildComponent($name, $namespace, $domain)
    {

        $DatatableServiceProviderPath = Path::toDomain($domain, 'Providers', 'DatatableServiceProvider.php');

        $DatatableServiceProviderContent = Str::of(File::get($DatatableServiceProviderPath))->replace(
            '###DATATABLES_PLACEHOLDER###',
            "'$name' => $namespace::class,\n\t\t\t###DATATABLES_PLACEHOLDER###"
        );

        $this->save(
            Path::toDomain($domain, 'Providers'),
            'DatatableServiceProvider',
            'php',
            $DatatableServiceProviderContent
        );
    }
}
