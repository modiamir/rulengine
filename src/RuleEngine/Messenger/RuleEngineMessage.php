<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 2/14/19
 * Time: 8:40 PM
 */

namespace App\RuleEngine\Messenger;

class RuleEngineMessage
{
    private $event;

    private $data;

    public function __construct($event, $data)
    {
        $this->event = $event;
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }
}
