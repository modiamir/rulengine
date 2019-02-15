<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 2/14/19
 * Time: 9:46 PM
 */

namespace App\RuleEngine;


interface ConditionTypeInterface
{
    public function evaluate(ValueResolver $valueResolver);

    public function getParametersFormType(): string;
}
