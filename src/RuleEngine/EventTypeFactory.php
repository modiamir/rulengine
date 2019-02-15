<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 2/14/19
 * Time: 9:04 AM
 */

namespace App\RuleEngine;

class EventTypeFactory
{
    private $events = [];

    public function registerEvent($code, $class)
    {
        $this->events[$code] = $class;
    }

    /**
     * @param $code
     * @param array $data
     *
     * @return EventTypeInterface
     */
    public function createEvent($code)
    {
        $class = $this->events[$code];

        return new $class();
    }
}
