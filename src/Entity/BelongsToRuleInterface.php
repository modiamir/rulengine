<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 2/15/19
 * Time: 9:29 PM
 */

namespace App\Entity;


interface BelongsToRuleInterface
{
    public function getRule(): ?Rule;
}
