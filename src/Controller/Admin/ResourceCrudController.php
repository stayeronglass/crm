<?php

namespace App\Controller\Admin;

use App\Entity\Resource;
use App\Entity\User;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ResourceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Resource::class;
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
            ->setPageTitle(Crud::PAGE_INDEX, 'Chalet CRM | Помещения')
            ->setPageTitle(Crud::PAGE_DETAIL, fn (Resource $resource) => sprintf('Chalet CRM | Помещение: %s', $resource->getTitle()))
            ->setPageTitle(Crud::PAGE_EDIT, fn (Resource $resource) => sprintf('Chalet CRM | Редактирование помещения: %s', $resource->getTitle()))
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm()
            ->setTemplatePath('admin/field/id_link.html.twig')
        ;
        yield TextField::new('title');
        yield TextEditorField::new('description');


        yield AssociationField::new('parent')
            ->autocomplete();


        yield DateTimeField::new('rgt')->hideOnForm()->hideOnIndex();
        yield DateTimeField::new('lft')->hideOnForm()->hideOnIndex();
        yield DateTimeField::new('level')->hideOnForm()->hideOnIndex();

        yield DateTimeField::new('createdAt')->hideOnForm();
        yield DateTimeField::new('updatedAt')->hideOnForm();
    }
}
