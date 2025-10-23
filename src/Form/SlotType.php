<?php

namespace App\Form;

use App\Entity\Filter;
use App\Entity\Slot;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SlotType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('dateBegin', null, [
                'widget' => 'single_text'
            ])
            ->add('dateEnd', null, [
                'widget' => 'single_text'
            ])
            ->add('createdAt')
            ->add('updatedAt')
            ->add('deletedAt')
            ->add('filters', EntityType::class, [
                'class' => Filter::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Slot::class,
        ]);
    }
}
