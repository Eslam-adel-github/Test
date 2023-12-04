<?php

namespace EslamDDD\SkelotonPackage\Helper;

<<<<<<< HEAD
use EslamDDD\SkelotonPackage\Helper\Make\Types\Controller;
use EslamDDD\SkelotonPackage\Helper\Make\Types\DatabaseView;
use EslamDDD\SkelotonPackage\Helper\Make\Types\Datatable;
use EslamDDD\SkelotonPackage\Helper\Make\Types\Domain;
use EslamDDD\SkelotonPackage\Helper\Make\Types\Entity;
use EslamDDD\SkelotonPackage\Helper\Make\Types\Factory;
use EslamDDD\SkelotonPackage\Helper\Make\Types\Migration;
use EslamDDD\SkelotonPackage\Helper\Make\Types\Seeder;
use theaddresstech\Support\Arr;
=======
>>>>>>> 93eb304d6b785e161e437b08fcd86eddcbeaf2c2
use Illuminate\Support\Facades\File;

trait Stub
{
    /**
     * Retrieve the path to a specific stub
     *
     * @param [type] $name
     */
    public function stubPath(): string
    {

        $directories = ArrayFormatter::trim($this->stub, DIRECTORY_SEPARATOR);

        $file = array_pop($directories);

        $path = Path::stub(...$directories).$file;

        return $path;
    }

    /**
     * Retrieve the path to a specific stub
     *
     * @param [type] $name
     */
    public function stubContent(): string
    {

        return File::get($this->stubPath());

    }

    /**
     * Get Stub
     *
     * @param  string  $name
     * @return string
     */
    public function getStub($name, $content = true)
    {

        $stubs = config('ddd.stubs');
        if (array_key_exists($name, $stubs)) {

            $path = Path::stub().ltrim($stubs[$name], DIRECTORY_SEPARATOR);

            return $content === true ? File::get($path) : $path;
        } else {
            throw new \Exception('File Not Found');
            exit();
        }

    }
}
