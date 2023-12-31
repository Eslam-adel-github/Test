<?php

namespace EslamDDD\SkelotonPackage\Helper\Make\Types;

use EslamDDD\SkelotonPackage\Helper\Make\Maker;
use EslamDDD\SkelotonPackage\Helper\Naming;
use EslamDDD\SkelotonPackage\Helper\Path;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class GraphqlTest extends Maker
{
    /**
     * Options to be available once Command-Type is cllade
     *
     * @return array
     */
    public $options = [
        'name',
        'domain',
        'entity related',
        'entity',
        'test type',
    ];

    /**
     * Return options that should be treated as choices
     *
     * @return array
     */
    public $allowChoices = [
        'domain',
        'entity',
        'test type',
    ];

    /**
     * Check if the current options is True/False question
     *
     * @return array
     */
    public $booleanOptions = [
        'entity related',
    ];

    /**
     * Check if the current options is requesd based on other option
     *
     * @return array
     */
    public $requiredUnless = [
        'entity' => [
            'option' => 'entity related',
            'value' => true,
        ],
    ];

    public function service(array $values): bool
    {

        $name = Naming::class($values['name']);

        $placeholders = [
            '{{DOMAIN}}' => $values['domain'],
            '{{NAME}}' => $name,
            '{{ENTITY}}' => $values['entity'],
            '{{ENTITY_LC}}' => Str::lower($values['entity']),
            '{{ENTITY_PLURAL}}' => Str::plural(Str::lower($values['entity'])),
        ];

        $prefix = $values['entity related'] ? 'magic-' : '';

        $types = $values['test type'] == 'All' ? ['Feature', 'Unit'] : [$values['test type']];

        foreach ($types as $type) {
            $content = Str::of($this->getStub($prefix.$type))->replace(array_keys($placeholders), array_values($placeholders));
            File::put(Path::toDomain($values['domain'], 'Tests', $type, $name.'Test.php'), $content);
        }

        return true;
    }
}
