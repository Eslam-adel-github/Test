<?php

namespace Eslam\SkelotonPackage\Helper;

class StringFormatter
{
    /**
     * Wrap string between delimetters
     *
     * @param  string  $string
     * @param  string  $wrapper
     */
    public static function wrap($string, $wrapper): string
    {

        $string = trim($string, $wrapper);

        return $wrapper.$string.$wrapper;
    }
}
