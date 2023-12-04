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
use Eslam\SkelotonPackage\Helper\Naming;
use Eslam\SkelotonPackage\Helper\Path;
>>>>>>> 93eb304d6b785e161e437b08fcd86eddcbeaf2c2
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class Resource extends Maker
{
    /**
     * Options to be available once Command-Type is cllade
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

        $className = Naming::class($values['name'].' Resource');

        $placeholders = [
            '{{NAME}}' => $className,
            '{{DOMAIN}}' => $values['domain'],
            '{{ENTITY}}' => $values['entity'],
        ];

        $destination = Path::toDomain($values['domain'], 'Http', 'Resources', $values['entity']);

        if (! File::isFile($destination)) {
            $single = Str::of($this->getStub('resource'))
                ->replace(array_keys($placeholders), array_values($placeholders));
            $this->save($destination, $className, 'php', $single);

            $collection = Str::of($this->getStub('resource_collection'))
                ->replace(array_keys($placeholders), array_values($placeholders));

            $this->save($destination, $className.'Collection', 'php', $collection);
        } else {
            $this->command->error('File Exists');

            return false;
        }

        return true;
    }
}
