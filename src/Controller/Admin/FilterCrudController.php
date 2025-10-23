<?php

namespace App\Controller\Admin;

use App\Entity\Filter;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class FilterCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Filter::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();
        yield TextField::new('title');
        yield TextEditorField::new('description');
        yield AssociationField::new('parent')
            ->autocomplete();

        yield DateTimeField::new('dateBegin');
        yield DateTimeField::new('dateEnd');

        yield DateTimeField::new('rgt')->hideOnForm()->hideOnIndex();
        yield DateTimeField::new('lft')->hideOnForm()->hideOnIndex();
        yield DateTimeField::new('level')->hideOnForm()->hideOnIndex();

        yield DateTimeField::new('createdAt')->hideOnForm();
        yield DateTimeField::new('updatedAt')->hideOnForm();
    }
}
