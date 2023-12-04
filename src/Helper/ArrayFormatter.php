<?php

namespace EslamDDD\SkelotonPackage\Helper;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class ArrayFormatter
{
    public static function dot($array): array
    {
        $flattened = Arr::dot($array);

        $data = [];
        foreach ($flattened as $folder => $files) {
            $_folder = explode('.', $folder);
            if (is_numeric(last($_folder))) {
                array_pop($_folder);
                $key = implode('.', $_folder);
                if (! array_key_exists($key, $data)) {
                    $data[$key] = [];
                }
                array_push($data[$key], $files);
            } else {
                $data[$folder] = $files;
            }
        }

        return $data;
    }

    public static function directories($array): array
    {
        $data = Arr::dot($array);
        $new = [];

        foreach ($data as $key => $value) {
            $dir = $key.'.'.$value;
            $dir = preg_replace("#\.[0-9]+\.#", DIRECTORY_SEPARATOR, $dir);
            $dir = preg_replace("#^[0-9]+\.#", '', $dir);
            $new[] = str_replace('.', DIRECTORY_SEPARATOR, $dir);
        }

        return $new;
    }

    public static function files($files): array
    {

        foreach ($files as &$file) {
            $file = pathinfo($file, PATHINFO_FILENAME);
        }

        return $files;
    }

    public static function trim(array $array, string $string)
    {

        array_walk($array, function (&$el) use ($string) {
            $el = trim($el, $string);
        });

        return $array;
    }

    public static function lower(array $array)
    {

        array_walk($array, function (&$el) {
            $el = Str::lower($el);
        });

        return $array;
    }

    public static function camel(array $array)
    {

        array_walk($array, function (&$el) {
            $el = Str::ucfirst(Str::camel(Str::lower($el)));
        });

        return $array;
    }

    public static function wrap(array $array, string $before, string $after): array
    {

        array_walk($array, function (&$el) use ($before, $after) {
            $el = trim($el, $before.$after);
            $el = $before.$el.$after;
        });

        return $array;
    }
}
