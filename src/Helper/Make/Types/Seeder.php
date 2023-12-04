<?php

namespace Eslam\SkelotonPackage\Helper\Make\Types;

use Eslam\SkelotonPackage\Helper\Make\Maker;
use Eslam\SkelotonPackage\Helper\NamespaceCreator;
use Eslam\SkelotonPackage\Helper\Naming;
use Eslam\SkelotonPackage\Helper\Path;
use Eslam\SkelotonPackage\Helper\Stub;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class Seeder extends Maker
{
    /**
     * Options to be available once Command-Type is cllade
     *
     * @return Array
     */
    public $options = [
        'name',
        'domain',
        'entity',
        'count',
    ];

    /**
     * Return options that should be treated as choices
     *
     * @return Array
     */
    public $allowChoices = [
        'domain',
        'entity',
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
     * @return boolean
     */
    public function service(Array $values = []):bool{

        $name   = Naming::class($values['name']);
        $domain = Naming::class($values['domain']);
        $entity = Naming::class($values['entity']);
        $file   = Naming::class($values['name'],'table seeder');

        $placeholders = [
            '{{NAME}}'      => $name,
            '{{DOMAIN}}'    => $domain,
            '{{ENTITY}}'    => $entity,
            '{{COUNT}}'     => $values['count'],
        ];

        $destination = Path::toDomain($values['domain'],'Database','Seeds');

        $content = Str::of($this->getStub('seeder'))->replace(array_keys($placeholders),array_values($placeholders));

        $this->save($destination,$file,'php',$content);

        return true;
    }

}
