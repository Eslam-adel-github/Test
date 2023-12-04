<?php

namespace EslamDDD\SkelotonPackage\Helper\Make\Types;

use EslamDDD\SkelotonPackage\Helper\Make\Maker;

class Auth extends Maker
{
    /**
     * Options to be available once Command-Type is called
     *
     * @return array
     */
    public $options = [
        'domain',
        'entity',
    ];

    /**
     * Return options that should be treated as choices
     *
     * @return array
     */
    public $allowChoices = [
        'domain',
        'entity',
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

        // Chagne entity to authenticatable and create Auth directory inside controllers
        // Modify the config auth file to match the new class name

        $this->command->error('Impelementation is required');
        exit();

        return true;
    }
}
