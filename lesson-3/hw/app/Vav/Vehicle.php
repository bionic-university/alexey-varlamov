<?php
namespace Vav\Vehicle;

/**
 * Class Vehicle for storing info about transport
 *
 * @author Alexey Varlamov <l.e.h.a.vav@gmail.com>
 * @version 1.0
 */
abstract class Vehicle {
    public $category;

    public static function match()
    {
        echo 'Hello in Vehicle';
    }
} 