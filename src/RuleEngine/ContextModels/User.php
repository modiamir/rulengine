<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 2/15/19
 * Time: 10:00 AM
 */

namespace App\RuleEngine\ContextModels;


class User
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $cellphone;

    /**
     * @var Address[]
     */
    private $addresses;

    /**
     * @return integer
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param integer $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getCellphone(): string
    {
        return $this->cellphone;
    }

    /**
     * @param string $cellphone
     */
    public function setCellphone(string $cellphone): void
    {
        $this->cellphone = $cellphone;
    }

    /**
     * @return Address[]
     */
    public function getAddresses(): array
    {
        return $this->addresses;
    }

    /**
     * @param Address[] $addresses
     */
    public function setAddresses(array $addresses): void
    {
        $this->addresses = $addresses;
    }
}
