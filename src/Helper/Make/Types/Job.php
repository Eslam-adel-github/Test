<?php

namespace Eslam\SkelotonPackage\Helper\Make\Types;

use Eslam\SkelotonPackage\Helper\Make\Maker;
use Eslam\SkelotonPackage\Helper\Naming;
use Eslam\SkelotonPackage\Helper\Path;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class Job extends Maker
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

        $name = Naming::class($values['name']);

        $placeholders = [
            '{{NAME}}' => $name,
            '{{DOMAIN}}' => $values['domain'],
        ];

        $dir = Path::toDomain($values['domain'], 'Jobs');

        $content = Str::of($this->getStub('job'))
            ->replace(array_keys($placeholders), array_values($placeholders));

        $this->save($dir, $name, 'php', $content);

        return true;
    }
}
