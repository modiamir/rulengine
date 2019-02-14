<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 */
class Event
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $code;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Rule", inversedBy="event", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $rule;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getRule(): ?Rule
    {
        return $this->rule;
    }

    public function setRule(Rule $rule): self
    {
        $this->rule = $rule;

        return $this;
    }
}
