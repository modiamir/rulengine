<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 2/14/19
 * Time: 9:45 PM
 */

namespace App\RuleEngine;

class ActionTypeFactory
{
    private $actionTypes = [];

    public function registerActionType($code, ActionTypeInterface $actionType)
    {
        $this->actionTypes[$code] = $actionType;
    }

    /**
     * @param $code
     *
     * @return ActionTypeInterface
     */
    public function getActionType($code)
    {
        return $this->actionTypes[$code];
    }

    public function getActionTypeCodes()
    {
        return array_keys($this->actionTypes);
    }
}
