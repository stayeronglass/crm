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
            ->add('Monday', CheckboxType::class, [
                'label'  => 'Понедельник',
                'attr' => ['class' => 'time_checkbox', 'onclick' => 'toggleBeginEnd(this)' ]
            ])
            ->add('MondayTimeBegin', TimeType::class, [
                'input'  => 'datetime',
                'widget' => 'choice',
                'label'  => false,
                'attr' => ['class' => 'time_begin']
            ])
            ->add('MondayTimeEnd', TimeType::class, [
                'input'  => 'datetime',
                'widget' => 'choice',
                'label'  => false,
                'attr' => ['class' => 'time_end']
            ])

            ->add('Tuesday', CheckboxType::class, [
                'label'  => 'Вторник','attr' => ['class' => 'time_checkbox', 'onclick' => 'toggleBeginEnd(this)']
            ])
            ->add('TuesdayTimeBegin', TimeType::class, [
                'input'  => 'datetime',
                'widget' => 'choice',
                'label'  => false,'attr' => ['class' => 'time_begin']
            ])
            ->add('TuesdayTimeEnd', TimeType::class, [
                'input'  => 'datetime',
                'widget' => 'choice',
                'label'  => false,'attr' => ['class' => 'time_end']
            ])

            ->add('Wednesday', CheckboxType::class, [
                'label'  => 'Среда','attr' => ['class' => 'time_checkbox', 'onclick' => 'toggleBeginEnd(this)']
            ])
            ->add('WednesdayTimeBegin', TimeType::class, [
                'input'  => 'datetime',
                'widget' => 'choice',
                'label'  => false,'attr' => ['class' => 'time_begin']
            ])
            ->add('WednesdayTimeEnd', TimeType::class, [
                'input'  => 'datetime',
                'widget' => 'choice',
                'label'  => false,'attr' => ['class' => 'time_end']
            ])

            ->add('Thursday', CheckboxType::class, [
                'label'  => 'Четверг','attr' => ['class' => 'time_checkbox', 'onclick' => 'toggleBeginEnd(this)']
            ])
            ->add('ThursdayTimeBegin', TimeType::class, [
                'input'  => 'datetime',
                'widget' => 'choice',
                'label'  => false,'attr' => ['class' => 'time_begin']
            ]) ->add('ThursdayTimeEnd', TimeType::class, [
                'input'  => 'datetime',
                'widget' => 'choice',
                'label'  => false,'attr' => ['class' => 'time_end']
            ])


            ->add('Friday', CheckboxType::class, [
                'label'  => 'Пятница','attr' => ['class' => 'time_checkbox', 'onclick' => 'toggleBeginEnd(this)']
            ])
            ->add('FridayTimeBegin', TimeType::class, [
                'input'  => 'datetime',
                'widget' => 'choice',
                'label'  => false,'attr' => ['class' => 'time_begin']
            ])
            ->add('FridayTimeEnd', TimeType::class, [
                'input'  => 'datetime',
                'widget' => 'choice',
                'label'  => false,'attr' => ['class' => 'time_end']
            ])

            ->add('Saturday', CheckboxType::class, [
                'label'  => 'Суббота','attr' => ['class' => 'time_checkbox', 'onclick' => 'toggleBeginEnd(this)']
            ])
            ->add('SaturdayTimeBegin', TimeType::class, [
                'input'  => 'datetime',
                'widget' => 'choice',
                'label'  => false,'attr' => ['class' => 'time_begin']
            ])
            ->add('SaturdayTimeEnd', TimeType::class, [
                'input'  => 'datetime',
                'widget' => 'choice',
                'label'  => false,'attr' => ['class' => 'time_end']
            ])

            ->add('Sunday', CheckboxType::class, [
                'label'  => 'Воскресенье','attr' => ['class' => 'time_checkbox', 'onclick' => 'toggleBeginEnd(this)']
            ])
            ->add('SundayTimeBegin', TimeType::class, [
                'input'  => 'datetime',
                'widget' => 'choice',
                'label'  => false,'attr' => ['class' => 'time_begin']
            ])
            ->add('SundayTimeEnd', TimeType::class, [
                'input'  => 'datetime',
                'widget' => 'choice',
                'label'  => false,'attr' => ['class' => 'time_end']
            ])
        ;


    }

}
