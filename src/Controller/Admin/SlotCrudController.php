<?php

namespace App\Controller\Admin;

use App\Entity\Slot;
use App\Entity\User;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ColorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SlotCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Slot::class;
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
            ->setPageTitle(Crud::PAGE_INDEX, 'Chalet CRM | Слоты')
            ->setPageTitle(Crud::PAGE_DETAIL, fn (Slot $slot) => sprintf('Chalet CRM | Слот: %s', $slot->getTitle()))
            ->setPageTitle(Crud::PAGE_EDIT, fn (Slot $slot) => sprintf('Chalet CRM | Редактирование слота: %s', $slot->getTitle()))
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm()
            ->setTemplatePath('admin/field/id_link.html.twig')
        ;
        yield TextField::new('title');
        yield TextEditorField::new('description');

        yield AssociationField::new('resources')
            ->setFormTypeOptions([
                'by_reference' => false,
                'required' => false,
            ])
            ->onlyOnForms()
            ->autocomplete()
        ;

        yield DateTimeField::new('dateBegin');
        yield DateTimeField::new('dateEnd');

        yield IntegerField::new('price');
        yield ColorField::new('color');

        yield DateTimeField::new('createdAt')->hideOnForm();
        yield DateTimeField::new('updatedAt')->hideOnForm();
    }
}
