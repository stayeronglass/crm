<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\Resource;
use App\Entity\Service;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateBegin', null, [
                'label' => 'Дата/Время Начала',
                'widget' => 'single_text'
            ])
            ->add('dateEnd', null, [
                'label' => 'Дата/Время Окончания',
                'widget' => 'single_text'
            ])
            ->add('service', EntityType::class, [
                'label' => 'Услуга',
                'class' => Service::class,
                'choice_label' => 'title',
            ])
            ->add('resource', EntityType::class, [
                'label' => 'Место',
                'class' => Resource::class,
                'choice_label' => 'title',
            ])
            ->add('comment', null, [
                'label' => 'Комментарий',
                'empty_data' => '',
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
            'data_class' => Event::class,
            'csrf_protection' => false, // Disable CSRF for this specific form
        ]);
    }
}
