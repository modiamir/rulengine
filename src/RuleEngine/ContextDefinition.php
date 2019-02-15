<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 2/15/19
 * Time: 10:02 AM
 */

namespace App\RuleEngine;

use Symfony\Component\PropertyInfo\PropertyInfoExtractorInterface;
use Symfony\Component\PropertyInfo\Type;

class ContextDefinition
{
    private $contextModels;
    private $propertyInfo;
    private $resolvedClasses = [];

    public function __construct(PropertyInfoExtractorInterface $propertyInfo)
    {
        $this->propertyInfo = $propertyInfo;
    }

    public function addContextModel($name, $class)
    {
        $this->contextModels[$name] = $class;
    }

    public function availableDataPath()
    {
        $availableDataPath = [];
        foreach ($this->contextModels as $name => $class) {
            // see below for more examples
            $availableDataPath[$name] = $this->getPropertyMapping($class);
        }

        return $availableDataPath;
    }

    private function getPropertyMapping($class, $level = 0)
    {
        $properties = $this->propertyInfo->getProperties($class);

        $mapping = new \stdClass();
        if (empty($properties) || (in_array($class, $this->resolvedClasses) && $level == 10)) {
            $classParts = explode('\\', $class);
            return end($classParts);
        }
        $this->resolvedClasses[] = $class;
        foreach ($properties as $property) {
            /** @var Type[] $types */
            $types = $this->propertyInfo->getTypes($class, $property);
            $type = $types[0];
            if ($type->isCollection() && null !== ($collectionValueType = $type->getCollectionValueType())) {
                $mapping->$property = [
                    $collectionValueType->getBuiltinType() == 'object' ? $this->getPropertyMapping($collectionValueType->getClassName(), $level + 1) : $collectionValueType->getBuiltinType(),
                ];
            } elseif (!$type->isCollection() && $type->getBuiltinType() == 'object') {
                $mapping->$property = $this->getPropertyMapping($type->getClassName(), $level + 1);
            } else {
                $mapping->$property = $type->getBuiltinType();
            }

        }

        return $mapping;
    }

}
