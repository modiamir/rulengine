<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ConditionRepository")
 * @ORM\Table(name="conditions")
 */
class Condition implements BelongsToRuleInterface
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
     * @ORM\Column(type="json", nullable=true)
     */
    private $parameters = [];

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Rule", inversedBy="conditions")
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

    public function getParameters(): ?array
    {
        return $this->parameters;
    }

    public function setParameters(?array $parameters): self
    {
        $this->parameters = $parameters;

        return $this;
    }

    public function getRule(): ?Rule
    {
        return $this->rule;
    }

    public function setRule(?Rule $rule): self
    {
        $this->rule = $rule;

        return $this;
    }
}
