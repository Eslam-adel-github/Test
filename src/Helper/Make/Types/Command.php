<?php

namespace EslamDDD\SkelotonPackage\Helper\Make\Types;

use EslamDDD\SkelotonPackage\Helper\Make\Maker;
use EslamDDD\SkelotonPackage\Helper\Naming;
use EslamDDD\SkelotonPackage\Helper\Path;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class Command extends Maker
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

    public function service(array $values): bool
    {

        $name = Naming::class($values['name'].' command');

        $command_name = Str::of($values['name'])->replace(' ', '_');

        $placeholders = [
            '{{NAME}}' => $name,
            '{{C_NAME}}' => $command_name,
            '{{DOMAIN}}' => $values['domain'],
        ];

        $destination = Path::toDomain($values['domain'], 'Commands');

        $content = Str::of($this->getStub('command'))->replace(array_keys($placeholders), array_values($placeholders));

        $this->save($destination, $name, 'php', $content);

        $console = File::get(Path::toCommon('Console', 'kernel.php'));

        preg_match('#namespace (.*);#', $content, $matches);
        $class = $matches[1].'\\'.$name;

        $console_content = Str::of($console)->replace('###COMMON_COMMAND###', "\\$class::class,\n\t\t###COMMON_COMMAND###");
        $this->save(Path::toCommon('Console'), 'kernel', 'php', $console_content);

        return true;
    }
}
