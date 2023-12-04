<?php

namespace EslamDDD\SkelotonPackage\Helper\Make\Types;

<<<<<<< HEAD
use EslamDDD\SkelotonPackage\Helper\Make\Maker;
use EslamDDD\SkelotonPackage\Helper\Naming;
use EslamDDD\SkelotonPackage\Helper\Path;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use EslamDDD\SkelotonPackage\Helper\NamespaceCreator;
=======
use Eslam\SkelotonPackage\Helper\Make\Maker;
use Illuminate\Support\Facades\File;
>>>>>>> 93eb304d6b785e161e437b08fcd86eddcbeaf2c2

class Magic extends Maker
{
    /**
     * Options to be available once Command-Type is cllade
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
     * Fill all placeholders in the stub file
     */
    public function service(array $values = []): bool
    {

        $this->command->call('cache:clear');
        $this->command->call('config:clear');
        $this->command->call('event:clear');
        $this->command->call('optimize:clear');
        $this->command->call('route:clear');
        $this->command->call('view:clear');

        return true;
    }
}
