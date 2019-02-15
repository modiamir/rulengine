<?php

namespace App\Form;

use App\Entity\Action;
use App\RuleEngine\ActionTypeFactory;
use App\RuleEngine\ActionTypeInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActionType extends AbstractType
{
    /**
     * @var ActionTypeFactory
     */
    private $actionTypeFactory;

    public function __construct(ActionTypeFactory $actionTypeFactory)
    {
        $this->actionTypeFactory = $actionTypeFactory;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var Action $action */
        $action = $builder->getData();
        $actionType = $action->getCode();
        /** @var ActionTypeInterface $actionType */
        $actionType = $this->actionTypeFactory->getActionType($actionType);

        $builder
            ->add('parameters', $actionType->getParametersFormType())
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Action::class,
        ]);
    }
}
