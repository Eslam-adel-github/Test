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

class Event extends Maker
{
    /**
     * Options to be available once Command-Type is called
     *
     * @return array
     */
    public $options = [
        'name',
        'domain',
        'command_http_general',
    ];

    /**
     * Return options that should be treated as choices
     *
     * @return array
     */
    public $allowChoices = [
        'domain',
        'command_http_general',
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
        $type = $values['command_http_general'];

        $placeholders = [
            '{{NAME}}' => $name,
            '{{DOMAIN}}' => $values['domain'],
            '{{TYPE}}' => $type,
        ];

        $className = $name.'Event';

        $destination = Path::toDomain($values['domain'], 'Events', $type);

        $content = Str::of($this->getStub('event'))
            ->replace(array_keys($placeholders), array_values($placeholders));
        $this->save($destination, $className, 'php', $content);

        preg_match('#namespace (.*);#', $content, $matches);

        $class = $matches[1].'\\'.$className;

        $eventServiceProviderPath = Path::toDomain($values['domain'], 'Providers');

        $content = File::get(Path::build($eventServiceProviderPath, 'EventServiceProvider.php'));

        $eventServiceProviderContent = Str::of($content)->replace(
            '###EVENTS###',
            "\\$class::class => [\n\t\t\t###LISTENERS_{$type}_$className###\n\t\t],\n\t\t###EVENTS###"
        );

        $this->save($eventServiceProviderPath, 'EventServiceProvider', 'php', $eventServiceProviderContent);

        return true;
    }
}
