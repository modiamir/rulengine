<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 2/14/19
 * Time: 9:45 PM
 */

namespace App\RuleEngine;

class ConditionTypeFactory
{
    private $conditionTypes = [];

    public function registerConditionType($code, $class)
    {
        $this->conditionTypes[$code] = $class;
    }

    /**
     * @param $code
     *
     * @return ConditionTypeInterface
     */
    public function createConditionType($code)
    {
        $class = $this->conditionTypes[$code];

        return new $class();
    }

    public function getConditionTypes()
    {
        return $this->conditionTypes;
    }
}
