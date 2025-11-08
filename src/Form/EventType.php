<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\Filter;
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
            ->add('comment', null, [
                'label' => 'Комментарий',
            ])
            ->add('dateBegin', null, [
                'label' => 'Дата/Время начала',
                'widget' => 'single_text'
            ])
            ->add('dateEnd', null, [
                'label' => 'Дата/Время окончания',
                'widget' => 'single_text'
            ])
            ->add('service', EntityType::class, [
                'label' => 'Услуга',
                'class' => Filter::class,
                'choice_label' => 'title',
            ])
            ->add('place', EntityType::class, [
                'label' => 'Место',
                'class' => Filter::class,
                'choice_label' => 'title',
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
        ]);
    }
}
