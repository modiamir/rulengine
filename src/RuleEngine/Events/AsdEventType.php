<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 2/14/19
 * Time: 9:02 PM
 */

namespace App\RuleEngine\Events;


use App\RuleEngine\ContextModels\Order;
use App\RuleEngine\EventTypeInterface;

class AsdEventType implements EventTypeInterface
{
    public function getResultData($inputData): array
    {
        return [
            'orderId' => $inputData['order_id'],
        ];
    }

    public function getResultDefinition(): array
    {
        return [
            'orderId' => 'int',
            'order' => Order::class,
        ];
    }
}
