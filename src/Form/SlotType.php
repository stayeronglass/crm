<?php

namespace App\Form;

use App\Entity\Resource;
use App\Entity\Service;
use App\Entity\Slot;
use App\Form\Embed\WeekAndTimeType;
use App\Repository\ResourceRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SlotType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', null, [
                'label' => 'Название',
                'required' => true,
                'attr' => [
                    'maxlength' => 255, // Sets HTML <input maxlength="255">
                ],
            ])
            ->add('description', null, [
                'label' => 'Описание',
                'required' => true,
            ])
            ->add('dayOfWeek', WeekAndTimeType::class, [
                'mapped'   => false,
                'required' => false,
                'label'    => 'Повторять',
                'help'     => 'Если не выбрать то будет один раз',
            ])
            ->add('price', null, [
                'required' => false,
                'label'    => 'Цена',
            ])
            ->add('dateBegin', null, [
                'widget'   => 'single_text',
                'label'    => 'Начало',
                'required' => true,
            ])
            ->add('dateEnd', null, [
                'widget'   => 'single_text',
                'label'    => 'Окончание',
                'required' => true,
            ])
            ->add('resources', EntityType::class, [
                'class'         => Resource::class,
                'choice_label'  => 'title',
                'multiple'      => true,
                'label'         => 'Место',
                'required'      => true,
                'query_builder' => function (ResourceRepository $r): \Doctrine\ORM\QueryBuilder {
                    $root = $r->find(1);
                    return $r->getLeafsQueryBuilder($root);
                },
            ])
            ->add('services', EntityType::class, [
                'class'        => Service::class,
                'choice_label' => 'title',
                'multiple'     => true,
                'label'        => 'Услуга',
                'required'     => true,
            ])
            ->add('color', ColorType::class, [
                'label'      => 'Цвет',
                'empty_data' => '',
            ])
        ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event): void {
            $slot = $event->getData();
            $form = $event->getForm();

            if (!$slot || null === $slot->getId()) {
                $form->add('submit', ButtonType::class, [
                    'label' => 'Создать',
                    'attr'  => ['class' => 'btn btn-secondary', 'onclick' => 'create_slot(this)']
                ]);
            } else {
                $form
                    ->add('edit', ButtonType::class, [
                        'label' => 'Сохранить',
                        'attr'  => ['class' => 'btn btn-success', 'onclick' => "edit_slot({$slot->getId()})"]
                    ])
                    ->add('delete', ButtonType::class, [
                        'label' => 'Удалить',
                        'attr'  => ['class' => 'btn btn-danger', 'onclick' => "delete_slot({$slot->getId()})"]
                    ])
                ;
            }
            $form->add('cancel', ButtonType::class, [
                'label' => 'Отмена',
                'attr'  => ['class' => 'btn btn-primary', 'onclick' => 'ec.unselect();dialog.close();']
            ]);
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class'      => Slot::class,
            'csrf_protection' => false, // Disable CSRF for this specific form
            'user_timezone'   => 'Europe/Moscow'
        ]);
    }
}
