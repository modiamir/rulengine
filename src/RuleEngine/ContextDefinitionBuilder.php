<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 2/15/19
 * Time: 1:39 PM
 */

namespace App\RuleEngine;


use App\Entity\Rule;
use Symfony\Component\PropertyInfo\PropertyInfoExtractorInterface;

class ContextDefinitionBuilder
{
    /**
     * @var PropertyInfoExtractorInterface
     */
    private $propertyInfoExtractor;
    /**
     * @var EventTypeFactory
     */
    private $eventTypeFactory;

    public function __construct(
        PropertyInfoExtractorInterface $propertyInfoExtractor,
        EventTypeFactory $eventTypeFactory
    ) {
        $this->propertyInfoExtractor = $propertyInfoExtractor;
        $this->eventTypeFactory = $eventTypeFactory;
    }

    public function buildForRule(Rule $rule)
    {
        $contextDefinition = new ContextDefinition($this->propertyInfoExtractor);

        $event = $rule->getEvent();

        $eventType = $this->eventTypeFactory->createEvent($event->getCode());
        $definitions = $eventType->getResultDefinition();

        foreach ($definitions as $name => $type) {
            $contextDefinition->addContextModel("{$event->getCode()}__$name", $type);
        }

        return $contextDefinition;
    }
}
