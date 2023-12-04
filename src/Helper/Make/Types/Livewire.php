<?php

namespace EslamDDD\SkelotonPackage\Helper\Make\Types;

<<<<<<< HEAD
use Illuminate\Support\Str;
use EslamDDD\SkelotonPackage\Helper\Path;
use EslamDDD\SkelotonPackage\Helper\Naming;
use EslamDDD\SkelotonPackage\Helper\Make\Maker;
=======
use Eslam\SkelotonPackage\Helper\Make\Maker;
use Eslam\SkelotonPackage\Helper\Naming;
use Eslam\SkelotonPackage\Helper\Path;
use Illuminate\Support\Str;
>>>>>>> 93eb304d6b785e161e437b08fcd86eddcbeaf2c2

class Livewire extends Maker
{
    /**
     * Options to be available once Command-Type is cllade
     *
     * @return array
     */
    public $options = [
        'name',
    ];

    /**
     * Set Service
     */
    public function service(array $values): bool
    {

        $name = Naming::class($values['name']);

        $view = strtolower(Naming::class($values['name']));

        $placeholders = [
            '{{NAME}}' => $name,
            '{{NAME_LC}}' => $view,
        ];

        $destination = Path::toCommon('Http', 'Livewire');

        $content = Str::of($this->getStub('livewire'))->replace(array_keys($placeholders), array_values($placeholders));

        $this->save($destination, $name, 'php', $content);

        return true;
    }
}
