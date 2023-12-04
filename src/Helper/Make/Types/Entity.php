<?php

namespace Eslam\SkelotonPackage\Helper\Make\Types;

use Eslam\SkelotonPackage\Helper\Make\Maker;
use Eslam\SkelotonPackage\Helper\Naming;
use Eslam\SkelotonPackage\Helper\Path;
use Illuminate\Support\Str;

class Entity extends Maker
{
    /**
     * Options to be available once Command-Type is called
     *
     * @return array
     */
    public $options = [
        'name',
        'domain',
    ];

    /**
     * Return options that should be treated as choices
     *
     * @return array
     */
    public $allowChoices = [
        'domain',
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

        $this->createEntity($values);
        $this->createRelations($values);
        $this->createAttributes($values);

        return true;
    }

    private function createEntity($values)
    {
        $name = Naming::class($values['name']);
        $table = Naming::TableName($values['name']);

        $entity_placholder = [
            '{{NAME}}' => $name,
            '{{DOMAIN}}' => $values['domain'],
            '{{TABLE}}' => $table,
        ];

        $entity_destination = Path::toDomain($values['domain'], 'Entities');
        $entity_content = Str::of($this->getStub('entity'))->replace(array_keys($entity_placholder), array_values($entity_placholder));
        $this->save($entity_destination, $name, 'php', $entity_content);

    }

    private function createRelations($values)
    {

        $name = Naming::class($values['name']);
        $file = Naming::class($values['name'],'relations');

        $relations_placholder = [
            '{{NAME}}' => $name,
            '{{DOMAIN}}' => $values['domain'],
        ];

        $relations_destination = Path::toDomain($values['domain'], 'Entities', 'Traits', 'Relations');

        $relation_content = Str::of($this->getStub('relation'))->replace(array_keys($relations_placholder), array_values($relations_placholder));

        $this->save($relations_destination, $file, 'php', $relation_content);

    }

    private function createAttributes($values)
    {
        $name = Naming::class($values['name']);
        $file = Naming::class($values['name'],'attributes');

        $attributes_placholder = [
            '{{NAME}}' => $name,
            '{{DOMAIN}}' => $values['domain'],
        ];
        $attributes_destination = Path::toDomain($values['domain'], 'Entities', 'Traits', 'CustomAttributes');
        $attributes_content = Str::of($this->getStub('customer-attributes'))->replace(array_keys($attributes_placholder), array_values($attributes_placholder));
        $this->save($attributes_destination, $file, 'php', $attributes_content);
    }
}
