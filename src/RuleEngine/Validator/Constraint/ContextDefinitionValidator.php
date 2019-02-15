<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 2/15/19
 * Time: 9:00 PM
 */

namespace App\RuleEngine\Validator\Constraint;

use App\Entity\BelongsToRuleInterface;
use App\RuleEngine\ContextDefinitionBuilder;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ContextDefinitionValidator extends ConstraintValidator
{
    /**
     * @var ContextDefinitionBuilder
     */
    private $contextDefinitionBuilder;

    /**
     * @var PropertyAccessorInterface
     */
    private $propertyAccessor;

    public function __construct(
        ContextDefinitionBuilder $contextDefinitionBuilder,
        PropertyAccessorInterface $propertyAccessor
    ) {
        $this->contextDefinitionBuilder = $contextDefinitionBuilder;
        $this->propertyAccessor = $propertyAccessor;
    }

    /**
     * Checks if the passed value is valid.
     *
     * @param mixed $value The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     */
    public function validate($value, Constraint $constraint)
    {
        if (!is_string($value) || strlen($value) <= 1 || ':' !== $value[0]) {
            return;
        }

        $rootData = $this->context->getRoot()->getData();

        if (!$rootData instanceof BelongsToRuleInterface) {
            return;
        }

        $rule = $rootData->getRule();

        $contextDefinition = $this->contextDefinitionBuilder->buildForRule($rule);
        $availableDataPath = $contextDefinition->availableDataPath();

        if (!$this->propertyAccessor->isReadable($availableDataPath, substr($value, 1))) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();

        }
    }
}
