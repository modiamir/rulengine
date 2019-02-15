<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 2/14/19
 * Time: 10:13 PM
 */

namespace App\RuleEngine\Conditions\DataComparison;


use App\RuleEngine\Validator\Constraint\ContextDefinition;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class DataComparisonConditionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('first_value', TextType::class, [
                'required' => true,
                'constraints' => [
                    new ContextDefinition()
                ]
            ])
            ->add('operator', ChoiceType::class, [
                'choices' => [
                    '=' => '='
                ],
                'required' => true,
            ])
            ->add('second_value', TextType::class,[
                'required' => true,
            ])
        ;
    }
}
