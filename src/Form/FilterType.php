<?php

namespace App\Form;

use App\Entity\Resource;
use App\Entity\Slot;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('price')
            ->add('dateBegin', null, [
                'widget' => 'single_text'
            ])
            ->add('dateEnd', null, [
                'widget' => 'single_text'
            ])
            ->add('lft')
            ->add('lvl')
            ->add('rgt')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('deletedAt')
            ->add('root', EntityType::class, [
                'class' => Filter::class,
                'choice_label' => 'id',
            ])
            ->add('parent', EntityType::class, [
                'class' => Filter::class,
                'choice_label' => 'id',
            ])
            ->add('slots', EntityType::class, [
                'class' => Slot::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Filter::class,
        ]);
    }
}
