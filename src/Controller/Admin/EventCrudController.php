<?php

namespace App\Controller\Admin;

use App\Entity\Event;
use App\Entity\User;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ColorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EventCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Event::class;
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
            ->setPageTitle(Crud::PAGE_INDEX, 'Chalet CRM | Записи')
            ->setPageTitle(Crud::PAGE_DETAIL, fn (Event $event) => sprintf('Chalet CRM | Запись: %s', $event->getId()))
            ->setPageTitle(Crud::PAGE_EDIT, fn (Event $event) => sprintf('Chalet CRM | Редактирование записи: %s', $event->getId()))
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm()
            ->setTemplatePath('admin/field/id_link.html.twig')
        ;
        yield TextEditorField::new('comment');

        yield DateTimeField::new('dateBegin');
        yield DateTimeField::new('dateEnd');
        yield ColorField::new('color');

        yield AssociationField::new('resource')
            ->autocomplete();
        yield AssociationField::new('service')
            ->autocomplete();
        yield AssociationField::new('slot')
            ->autocomplete();


        yield DateTimeField::new('createdAt')->hideOnForm();
        yield DateTimeField::new('updatedAt')->hideOnForm();
    }
}
