<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 2/15/19
 * Time: 8:58 PM
 */

namespace App\RuleEngine\Validator\Constraint;


use Symfony\Component\Validator\Constraint;

class ContextDefinition extends Constraint
{
    public $message = 'The context path is not valid.';

    public function getTargets()
    {
        return [
            self::CLASS_CONSTRAINT,
            self::PROPERTY_CONSTRAINT
        ];
    }

}
