<?php

namespace EslamDDD\SkelotonPackage\Helper\Make\Service;

use EslamDDD\SkelotonPackage\Helper\ArrayFormatter;
use Illuminate\Support\Str;
use EslamDDD\SkelotonPackage\Helper\Make\Maker;
use EslamDDD\SkelotonPackage\Helper\Make\Service\NullMaker;
use EslamDDD\SkelotonPackage\Helper\Make\Types\Controller;
use EslamDDD\SkelotonPackage\Helper\Make\Types\DatabaseView;
use EslamDDD\SkelotonPackage\Helper\Make\Types\Datatable;
use EslamDDD\SkelotonPackage\Helper\Make\Types\Domain;
use EslamDDD\SkelotonPackage\Helper\Make\Types\Entity;
use EslamDDD\SkelotonPackage\Helper\Make\Types\Factory;
use EslamDDD\SkelotonPackage\Helper\Make\Types\Migration;
use EslamDDD\SkelotonPackage\Helper\Make\Types\Seeder;
use EslamDDD\SkelotonPackage\Helper\NamespaceCreator;
use EslamDDD\SkelotonPackage\Helper\Path;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;

class MakeFactory{

    /**
     * Holds the segments of namespace structure
     *
     * @var array
     */
    public static $namespace=[
        'theaddresstech',
        'DDD',
        'Helper',
        'Make',
        'Types',
    ];

    /**
     * Create an instance of the Maker to create directories
     *
     * @param Illuminate\Console\Command $ci
     * @return Maker
     */
    public static function create(Command $ci) : Maker{

        $makers = ArrayFormatter::files(File::files(Path::helper('Make','Types')));

        $supported  = ArrayFormatter::lower($makers);

        $type    = Str::lower($ci->argument('type'));

        if(in_array($type,$supported)){

            $type = Str::ucfirst($type);

            $namespace = MakeFactory::$namespace;

            array_push($namespace,$type);

            $class = NamespaceCreator::segments(...$namespace);

            return new $class($ci);

        }else{
            return new NullMaker($ci);
        }

    }

    public static function defineAttributes(&$signature){

        $files = ArrayFormatter::files(File::files(Path::helper('Make','Types')));

        array_walk($files,function(&$class){
            $class = NamespaceCreator::Segments('theaddresstech','DDD','Helper','Make','Types',$class);
        });

        $keys=[];

        foreach($files as $class){
            $keys=array_unique(array_merge($keys,$class::getSignature()));
        }

        $keys = ArrayFormatter::wrap(ArrayFormatter::trim($keys,'_'),'{--','}');

        $join = implode(' ',$keys);

        $signature.=" ".$join;
    }

}
