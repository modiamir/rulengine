<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 2/14/19
 * Time: 9:07 AM
 */

namespace App\RuleEngine;

interface EventTypeInterface
{
    public function getResultData($inputData): array ;
    public function getResultDefinition(): array ;
}
