<?php

namespace App\Controller\Admin;

use App\Entity\Service;
use App\Entity\User;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ServiceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Service::class;
    }
    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $queryBuilder = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);

        $queryBuilder->orderBy('entity.id', 'DESC')
        ;

        return $queryBuilder;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            //self::PAGE_DETAIL, self::PAGE_EDIT, self::PAGE_INDEX, self::PAGE_NEW
            ->setPageTitle(Crud::PAGE_INDEX, 'Chalet CRM | Услуги')
            ->setPageTitle(Crud::PAGE_DETAIL, fn (Service  $service) => sprintf('Chalet CRM | Услуга: %s', $service->getTitle()))
            ->setPageTitle(Crud::PAGE_EDIT, fn (Service  $service) => sprintf('Chalet CRM | Редактирование услуги: %s', $service->getTitle()))
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm()
            ->setTemplatePath('admin/field/id_link.html.twig')
        ;
        yield TextField::new('title');
        yield TextEditorField::new('description');
        yield IntegerField::new('priority');

        yield DateTimeField::new('createdAt')->hideOnForm();
        yield DateTimeField::new('updatedAt')->hideOnForm();
        yield DateTimeField::new('deletedAt')->hideOnForm();
    }
}
