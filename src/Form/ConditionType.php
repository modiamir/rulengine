<?php

namespace App\Form;

use App\Entity\Condition;
use App\RuleEngine\ConditionTypeFactory;
use App\RuleEngine\ConditionTypeInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConditionType extends AbstractType
{
    /**
     * @var ConditionTypeFactory
     */
    private $conditionTypeFactory;

    public function __construct(ConditionTypeFactory $conditionTypeFactory)
    {
        $this->conditionTypeFactory = $conditionTypeFactory;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var Condition $condition */
        $condition = $builder->getData();
        $conditionType = $condition->getCode();
        /** @var ConditionTypeInterface $conditionType */
        $conditionType = $this->conditionTypeFactory->createConditionType($conditionType);

        $builder
            ->add('parameters', $conditionType->getParametersFormType())
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Condition::class,
        ]);
    }
}
