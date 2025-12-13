<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserCrudController extends AbstractCrudController
{

    public static function getEntityFqcn(): string
    {
        return User::class;
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            //self::PAGE_DETAIL, self::PAGE_EDIT, self::PAGE_INDEX, self::PAGE_NEW
            ->setPageTitle(Crud::PAGE_INDEX, 'Chalet CRM | Пользователи')
            ->setPageTitle(Crud::PAGE_DETAIL, fn (User $user) => sprintf('Chalet CRM | Пользователь: %s', $user->getUsername()))
            ->setPageTitle(Crud::PAGE_EDIT, fn (User $user) => sprintf('Chalet CRM | Редактирование пользователя: %s', $user->getUsername()))
            ;
    }

    public function configureActions(Actions $actions): Actions
    {
            return $actions
                ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $queryBuilder = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);

        $queryBuilder->orderBy('entity.id', 'DESC');

        return $queryBuilder;
    }

    public function configureFields(string $pageName): iterable
    {
        yield FormField::addTab('Служебная информация', 'fas fa-user'); // Tab 1

        yield IdField::new('id')->hideOnForm()
            ->onlyOnIndex()
            ->setTemplatePath('admin/field/id_link.html.twig')
        ;
        yield TextField::new('username');
        yield TextField::new('email');
        yield BooleanField::new('enabled');

        yield TextField::new('plainPassword');

        yield DateTimeField::new('lastLogin')->hideOnForm();
        yield TextField::new('confirmationToken')->hideOnForm();
        yield ArrayField::new('roles')
            ->setHelp('Менеджер - может создавать слоты, селлер - может создавать записи, мастер - может принимать оплаты')
            ->setFormTypeOptions([
                'entry_type'    => ChoiceType::class,
                'entry_options' => [
                    'choices' => [
                        'Юзер'     => 'ROLE_USER',
                        'Мастер'   => 'ROLE_MASTER',
                        'Селлер'   => 'ROLE_SELLER',
                        'Менеджер' => 'ROLE_MANAGER',
                        'Админ'    => 'ROLE_ADMIN',
                    ],
                ],
            ])
        ;
        yield FormField::addTab('Профиль', 'fas fa-cog') // Tab 2
        ->setIcon('phone')->addCssClass('optional')
            ->setHelp('Профиль')
        ;
        AssociationField::new('profile')
            ->setCrudController(ProfileCrudController::class)
            ->renderAsEmbeddedForm()
        ;

        yield DateTimeField::new('createdAt')->hideOnForm();
        yield DateTimeField::new('updatedAt')->hideOnForm();
    }
}
