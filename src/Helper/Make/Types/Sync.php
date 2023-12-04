<?php

namespace Eslam\SkelotonPackage\Helper\Make\Types;

use Eslam\SkelotonPackage\Helper\Make\Maker;
use Eslam\SkelotonPackage\Helper\Path;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class Sync extends Maker
{
    /**
     * Options to be available once Command-Type is called
     *
     * @return array
     */
    public $options = [];

    /**
     * Return options that should be treated as choices
     *
     * @return array
     */
    public $allowChoices = [];

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
     * Check if the current options is requesd based on other option
     *
     * @return array
     */
    public $sync = [];

    /**
     * Fill all placeholders in the stub file
     *
     * @return Boll
     */
    public function service(array $values): bool
    {
        $this->command->info('Not implemented');

        return true;
        if (! File::exists(base_path('columns-match').'.json')) {
            $template_name = [
                [
                    'table' => 'migration_table_name',
                    'sync' => [
                        [
                            'type' => 'Entity | API Resource | Request',
                            'domain' => 'Post',
                            'name' => 'Post',
                        ],
                    ],
                ],
            ];
            File::put(base_path('columns-match').'.json', json_encode($template_name, JSON_PRETTY_PRINT));
            $this->command->error('Please fill columns-match.json file');

            return false;
        }

        $sync = json_decode(File::get(base_path('columns-match').'.json'), true);

        $tables = implode("','", collect($sync)->map(function ($el) {
            return $el['table'];
        })->toArray());

        $columns = DB::select(DB::raw("SELECT *
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE TABLE_NAME in('$tables') AND TABLE_SCHEMA = '".env('DB_DATABASE')."'"));

        $_columns = [];
        foreach ($columns as $column) {
            $_columns[$column->TABLE_NAME][] = $column->COLUMN_NAME;
        }

        foreach ($sync as $t) {

            foreach ($t['sync'] as $type) {

                $this->{$type['type']}($type['domain'], $type['name'], $_columns[$t['table']]);

            }
        }

        return true;
    }

    private function entity($domain, $name, $columns)
    {
        $file = File::get(Path::toDomain($domain, 'Entities', "$name.php"));

        dd($file, $columns);
    }
}
