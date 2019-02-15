<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 2/15/19
 * Time: 12:56 AM
 */

namespace App\RuleEngine;


class ValueResolver
{
    /**
     * @var Context
     */
    private $context;

    /**
     * @var array
     */
    private $parameters;

    public function __construct(Context $context, array $parameters = null)
    {
        $this->context = $context;
        $this->parameters = $parameters;
    }

    public function get($key, $default = null)
    {
        if (!isset($this->parameters[$key])) {
            return $default;
        }

        $value = $this->parameters[$key];
        if (is_string($value) && strlen($value) > 1 && ':' === $value[0]) {
            return $this->context->get(substr($value, 1), $default);
        }

        return $value;
    }
}
