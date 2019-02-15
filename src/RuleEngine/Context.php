<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 2/14/19
 * Time: 7:35 PM
 */

namespace App\RuleEngine;

use Symfony\Component\PropertyAccess\PropertyAccess;

class Context
{
    private $data = [];

    public function add($name, $value)
    {
        $this->data[$name] = $value;
    }

    public function get($key, $default = null)
    {
        $propertyAccessor = PropertyAccess::createPropertyAccessor();

        return $propertyAccessor->getValue($this->data, $key);
    }
}
