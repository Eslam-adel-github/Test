<?php

namespace EslamDDD\SkelotonPackage\Helper\Make\Types;

use EslamDDD\SkelotonPackage\Helper\Make\Maker;
use EslamDDD\SkelotonPackage\Helper\Naming;
use EslamDDD\SkelotonPackage\Helper\Path;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
<<<<<<< HEAD
use EslamDDD\SkelotonPackage\Helper\NamespaceCreator;
=======
>>>>>>> 93eb304d6b785e161e437b08fcd86eddcbeaf2c2

class DatabaseView extends Maker
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

        $name = Naming::class($values['name']);
        $file = Naming::class($values['name'],'view');

        $placeholders = [
            '{{NAME}}' => $name,
            '{{DOMAIN}}' => $values['domain'],
            '{{TABLE}}' => Naming::DatabaseViewTableName($name),
        ];

        $destination = Path::toDomain($values['domain'], 'Entities', 'Views');

        $content = Str::of($this->getStub('database-view'))->replace(array_keys($placeholders), array_values($placeholders));

        $this->save($destination, $file, 'php', $content);

        $this->createMigrationFile($values);

        return true;
    }

    public function createMigrationFile($values)
    {

        $domain = $values['domain'];
        $name = $values['name'];
        $table = Naming::DatabaseViewTableName($name);
        $placeholders = [
            '{{NAME}}' => $name,
            '{{TABLE}}' => $table,
        ];
        $fileName = Naming::migration_database_view('create', $table);

        $destination = Path::toDomain($domain, 'Database', 'Migrations');

        $content = Str::of($this->getStub('migration_view'))
            ->replace(array_keys($placeholders), array_values($placeholders));

        $this->save($destination, trim($fileName, '.php'), 'php', $content);

        return true;
    }
}
