<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 2/15/19
 * Time: 9:59 AM
 */

namespace App\RuleEngine\Events\OrderSubmitted;

use App\RuleEngine\ContextModels\Address;
use App\RuleEngine\ContextModels\Order;
use App\RuleEngine\ContextModels\User;
use App\RuleEngine\EventTypeInterface;

class OrderSubmittedEventType implements EventTypeInterface
{
    public function getResultDefinition(): array
    {
        return [
            'order' => Order::class,
        ];
    }

    public function getResultData($inputData): array
    {
        $order = new Order();
        $order->setOrderId($inputData['order_id']);

        $user = new User();
        $user->setId(208711);
        $user->setCellphone("09125995014");
        $address = new Address();
        $address->setDescription("address description");
        $address->setLatitude(53.12);
        $address->setLongitude(33.12);
        $user->setAddresses([$address]);
        $order->setUser($user);

        return [
            'order' => $order,
        ];
    }
}
