<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\Resource;
use App\Entity\Service;
use App\Repository\ResourceRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateBegin', null, [
                'label'    => 'Дата/Время Начала',
                'widget'   => 'single_text',
                'required' => true,
            ])
            ->add('dateEnd', null, [
                'label'    => 'Дата/Время Окончания',
                'widget'   => 'single_text',
                'required' => true,
            ])
            ->add('service', EntityType::class, [
                'label'        => 'Услуга',
                'class'        => Service::class,
                'choice_label' => 'title',
                'required'     => true,
            ])
            ->add('resource', EntityType::class, [
                'class'         => Resource::class,
                'choice_label'  => 'title',
                'multiple'      => false,
                'label'         => 'Место',
                'required'      => true,
                'query_builder' => function (ResourceRepository $r): \Doctrine\ORM\QueryBuilder {
                    $root = $r->find(1);
                    return $r->getLeafsQueryBuilder($root);
                },
            ])
            ->add('comment', null, [
                'label'      => 'Комментарий',
                'empty_data' => '',
                'required'   => true,
            ])
            ->add('color', ColorType::class, [
                'label'      => 'Цвет',
                'empty_data' => '',
                'required'   => false,
            ])
            ->add('clientPhone', TelType::class, [
                'label'      => 'Телефон',
                'empty_data' => '',
                'help'       => 'Будет использоваться для смс/телеграм/макс',
                'attr'       => ['placeholder' => '+7111111111'],
                'required'   => true,
            ])
            ->add('clientName', null, [
                'label'      => 'Имя клиента',
                'empty_data' => '',
                'help'       => 'ФИО или как к нему обращаться',
                'required'   => true,
            ])
            ->add('clientEmail', EmailType::class, [
                'label'    => 'Email клиента',
                'attr'     => ['placeholder' => 'email@example.ru'],
                'required' => true,
            ])
            ->add('clientsNumber', IntegerType::class, [
                'label'    => 'Количество мест',
                'required' => true,
            ])
            ->add('cancel', ButtonType::class, [
                'label' => 'Закрыть',
                'attr'  => ['class' => 'btn btn-secondary', 'onclick' => 'ec.unselect();dialog.close();']
            ])
        ;

//        ->addEventListener(
//        FormEvents::PRE_SET_DATA,
//        [$this, 'onPreSetData']
//    )
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event): void {
            $e = $event->getData();
            $form = $event->getForm();
            if (!$e || null === $e->getId()) {
                $form->add('submit', SubmitType::class, [
                    'label' => 'Создать',
                ]);
            } else {
                $form
                    ->add('edit', ButtonType::class, [
                        'label' => 'Сохранить',
                        'attr'  => ['class' => 'btn btn-success', 'onclick' => "edit_event({$e->getId()})"]
                    ])
                    ->add('delete', ButtonType::class, [
                        'label' => 'Удалить',
                        'attr'  => ['class' => 'btn btn-danger', 'onclick' => "delete_event({$e->getId()})"]
                    ])
                ;
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class'      => Event::class,
            'csrf_protection' => false, // Disable CSRF for this specific form
        ]);
    }
}
