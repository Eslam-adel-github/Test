<?php

namespace Eslam\SkelotonPackage\Helper\Make\Types;

use Eslam\SkelotonPackage\Helper\FileCreator;
use Eslam\SkelotonPackage\Helper\Make\Maker;
use Eslam\SkelotonPackage\Helper\NamespaceCreator;
use Eslam\SkelotonPackage\Helper\Naming;
use Eslam\SkelotonPackage\Helper\Path;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class Criteria extends Maker
{
    /**
     * Options to be available once Command-Type is called
     *
     * @return Array
     */
    public $options = [
        'name',
        'domain'
    ];

    /**
     * Return options that should be treated as choices
     *
     * @return Array
     */
    public $allowChoices = [
        'domain'
    ];

    /**
     * Check if the current options is True/False question
     *
     * @return Array
     */
    public $booleanOptions = [];

    /**
     * Check if the current options is requesd based on other option
     *
     * @return Array
     */
    public $requiredUnless = [];

    /**
     * Fill all placeholders in the stub file
     *
     * @param array $values
     * @return boolean
     */
    public function service(Array $values = []):bool{

        $name = Naming::class($values['name']);

        $placeholders = [
            '{{NAME}}' => $name,
            '{{DOMAIN}}' => $values['domain'],
        ];

        $className = $name.'Criteria';

        $dir = Path::toDomain($values['domain'],'Criteria');

        if(!File::isDirectory($dir)){
            File::makeDirectory($dir);
        }

        $content = Str::of($this->getStub('criteria'))
                        ->replace(array_keys($placeholders),array_values($placeholders));

        $this->save($dir,$className,'php',$content);

        return true;
    }

}