<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 2/15/19
 * Time: 9:59 AM
 */

namespace App\RuleEngine\ContextModels;


class Order
{
    /**
     * @var integer
     */
    private $orderId;

    /**
     * @var User
     */
    private $user;

    /**
     * @return integer
     */
    public function getOrderId(): int
    {
        return $this->orderId;
    }

    /**
     * @param integer $orderId
     */
    public function setOrderId(int $orderId): void
    {
        $this->orderId = $orderId;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }
}
