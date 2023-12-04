<?php

namespace Eslam\SkelotonPackage\Helper\Make\Types;

use Eslam\SkelotonPackage\Helper\Make\Maker;
use Eslam\SkelotonPackage\Helper\Naming;
use Eslam\SkelotonPackage\Helper\Path;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Eslam\SkelotonPackage\Helper\NamespaceCreator;

class Magic extends Maker
{
    /**
     * Options to be available once Command-Type is cllade
     *
     * @return Array
     */
    public $options = [];

    /**
     * Return options that should be treated as choices
     *
     * @return Array
     */
    public $allowChoices = [];

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

        $this->command->call('cache:clear');
        $this->command->call('config:clear');
        $this->command->call('event:clear');
        $this->command->call('optimize:clear');
        $this->command->call('route:clear');
        $this->command->call('view:clear');

        return true;
    }
}
