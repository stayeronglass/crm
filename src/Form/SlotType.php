<?php

namespace App\Form;

use App\Entity\Filter;
use App\Entity\Resource;
use App\Entity\Service;
use App\Entity\Slot;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SlotType extends AbstractType
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

            ->add('resource', EntityType::class, [
                'class' => Resource::class,
                'choice_label' => 'title',
                'multiple' => true,
            ])

            ->add('service', EntityType::class, [
                'class' => Service::class,
                'choice_label' => 'title',
                'multiple' => true,
            ])


            ->add('submit', SubmitType::class, [
                'label' => 'Создать',
            ])
            ->add('cancel', ButtonType::class, [
                'label' => 'Закрыть',
                'attr' => ['class' => 'btn btn-secondary', 'onclick' => 'dialog.close();']
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
