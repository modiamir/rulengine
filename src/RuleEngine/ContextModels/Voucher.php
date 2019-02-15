<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 2/15/19
 * Time: 5:05 PM
 */

namespace App\RuleEngine\ContextModels;


class Voucher
{
    private $voucherId;

    private $customerCode;

    /**
     * @return mixed
     */
    public function getVoucherId()
    {
        return $this->voucherId;
    }

    /**
     * @param mixed $voucherId
     */
    public function setVoucherId($voucherId): void
    {
        $this->voucherId = $voucherId;
    }

    /**
     * @return mixed
     */
    public function getCustomerCode()
    {
        return $this->customerCode;
    }

    /**
     * @param mixed $customerCode
     */
    public function setCustomerCode($customerCode): void
    {
        $this->customerCode = $customerCode;
    }
}
