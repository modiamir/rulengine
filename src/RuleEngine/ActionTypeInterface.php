<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 2/14/19
 * Time: 9:46 PM
 */

namespace App\RuleEngine;


interface ActionTypeInterface
{
    public function perform(ValueResolver $valueResolver): array;

    public function getParametersFormType(): string;

    public function getResultDefinition(): array ;
}
