<?php

namespace App\Form\Embed;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WeekAndTimeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('monday', CheckboxType::class, [
            ])
            ->add('mondaytime', TimeType::class, [
                'input'  => 'datetime',
                'widget' => 'choice',
                'label'  => 'mondayTime',
            ])

            ->add('Tuesday', CheckboxType::class, [
            ])
            ->add('Tuesdaytime', TimeType::class, [
                'input'  => 'datetime',
                'widget' => 'choice',
                'label'  => 'mondayTime',
            ])

            ->add('Wednesday', CheckboxType::class, [
            ])
            ->add('Wednesdaytime', TimeType::class, [
                'input'  => 'datetime',
                'widget' => 'choice',
                'label'  => 'mondayTime',
            ])

            ->add('Thursday', CheckboxType::class, [
            ])
            ->add('Thursdaytime', TimeType::class, [
                'input'  => 'datetime',
                'widget' => 'choice',
                'label'  => 'mondayTime',
            ])

            ->add('Friday', CheckboxType::class, [
            ])
            ->add('Fridaytime', TimeType::class, [
                'input'  => 'datetime',
                'widget' => 'choice',
                'label'  => 'mondayTime',
            ])

            ->add('Saturday', CheckboxType::class, [
            ])
            ->add('Saturdaytime', TimeType::class, [
                'input'  => 'datetime',
                'widget' => 'choice',
                'label'  => 'mondayTime',
            ])

            ->add('Sunday', CheckboxType::class, [
            ])
            ->add('Sundaytime', TimeType::class, [
                'input'  => 'datetime',
                'widget' => 'choice',
                'label'  => 'mondayTime',
            ])
        ;
    }

}
