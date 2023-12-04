<?php

namespace Eslam\SkelotonPackage\Helper\Make\Types;

use Eslam\SkelotonPackage\Helper\Make\Maker;
use Eslam\SkelotonPackage\Helper\Naming;
use Eslam\SkelotonPackage\Helper\Path;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class Request extends Maker
{
    /**
     * Options to be available once Command-Type is cllade
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

        $className = Naming::class($values['name']);

        $placeholders = [
            '{{NAME}}' => $className,
            '{{DOMAIN}}' => $values['domain'],
            '{{ENTITY}}' => $className,
            '{{ENTITY_LC}}' => Str::lower($className),
            '{{ENTITY_PL}}' => Str::plural(Str::lower($className)),
        ];

        $destinationStore = Path::toDomain($values['domain'], 'Http', 'Requests', $className);

        $contentStore = Str::of($this->getStub('request-store'))
            ->replace(array_keys($placeholders), array_values($placeholders));
        $this->save($destinationStore, $className.'StoreFormRequest', 'php', $contentStore);

        $destinationUpdate = Path::toDomain($values['domain'], 'Http', 'Requests', $className);
        $contentUpdate = Str::of($this->getStub('request-update'))
            ->replace(array_keys($placeholders), array_values($placeholders));
        $this->save($destinationUpdate, $className.'UpdateFormRequest', 'php', $contentUpdate);

        return true;
    }
}
