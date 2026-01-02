<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('phone', TelType::class, [
                'label'      => 'Телефон',
                'empty_data' => '',
                'help'       => 'Будет использоваться для смс/телеграм/макс, 11 цифр, формат любой',
                'attr'       => ['placeholder' => '+7111111111','maxlength' => 12,],
                'required'   => true,

            ])
            ->add('name', TextType::class, [
                'label'      => 'Имя клиента',
                'empty_data' => '',
                'help'       => 'ФИО или как к нему обращаться',
                'required'   => true,
                'attr' => [
                    'maxlength' => 255, // Sets HTML <input maxlength="255">
                ],
            ])
            ->add('email', EmailType::class, [
                'label'    => 'Email клиента',
                'attr'     => ['placeholder' => 'email@example.ru', 'maxlength' => 255],
                'required' => true,

            ])

            ->add('telegram', TextType::class, [
                'label'    => 'Имя в телеграме',
                'attr'     => ['placeholder' => '@username', 'maxlength' => 255],
                'required' => false,

            ])
        ;

        $builder->get('phone')
            ->addModelTransformer(new CallbackTransformer(
            // The transform function (model data to form data) - usually not needed for this
                function ($originalData) {
                    return '+'.$originalData;
                },
                // The reverseTransform function (submitted data to model data)
                function ($submittedData) {
                    if (null === $submittedData) {
                        return null;
                    }
                    return \preg_replace('/\D/', '', $submittedData);
                }
            ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
