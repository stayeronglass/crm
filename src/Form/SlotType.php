<?php

namespace App\Form;

use App\Entity\Resource;
use App\Entity\Service;
use App\Entity\Slot;
use App\Form\Embed\WeekAndTimeType;
use App\Repository\ResourceRepository;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SlotType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', null, [
                'label' => 'Название',
            ])
            ->add('description', null, [
                'label' => 'Описание',
            ])
            ->add('dayOfWeek', WeekAndTimeType::class, [
                'mapped'   => false,
                'required' => 'true',
                'label'    => 'Повторять',
                'help'     => 'Если не выбрать то будет один раз',
            ])
            ->add('price', null, [
                'required' => 'false',
                'label'    => 'Цена',
            ])
            ->add('dateBegin', null, [
                'widget'   => 'single_text',
                'label'    => 'Начало',
                'required' => 'true',
            ])
            ->add('dateEnd', null, [
                'widget'   => 'single_text',
                'label'    => 'Окончание',
                'required' => 'true',
            ])
            ->add('resources', EntityType::class, [
                'class'         => Resource::class,
                'choice_label'  => 'title',
                'multiple'      => true,
                'label'         => 'Место',
                'required'      => 'true',
                'query_builder' => function (ResourceRepository $r): \Doctrine\ORM\QueryBuilder {
                    $root = $r->find(1);
                    return $r->getLeafsQueryBuilder($root)
                    ;
                },
            ])
            ->add('services', EntityType::class, [
                'class'        => Service::class,
                'choice_label' => 'title',
                'multiple'     => true,
                'label'        => 'Услуга',
                'required'     => 'true',
            ])
            ->add('color', ColorType::class, [
                'label'      => 'Цвет',
                'empty_data' => '',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Создать',
            ])
            ->add('cancel', ButtonType::class, [
                'label' => 'Закрыть',
                'attr'  => ['class' => 'btn btn-secondary', 'onclick' => 'dialog.close();']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class'      => Slot::class,
            'csrf_protection' => false, // Disable CSRF for this specific form
        ]);
    }
}
