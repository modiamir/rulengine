<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 2/14/19
 * Time: 10:07 PM
 */

namespace App\RuleEngine\Conditions\DataComparison;

use App\RuleEngine\ConditionTypeInterface;
use App\RuleEngine\Context;
use App\RuleEngine\ValueResolver;

class DataComparisonConditionType implements ConditionTypeInterface
{
    public function evaluate(ValueResolver $valueResolver)
    {
        return $valueResolver->get('first_value') == $valueResolver->get('second_value');
    }

    public function getParametersFormType(): string
    {
        return DataComparisonConditionFormType::class;
    }
}
