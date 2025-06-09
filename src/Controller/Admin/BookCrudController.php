<?php

namespace App\Controller\Admin;

use App\Entity\Book;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class BookCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Book::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title')
                ->setRequired(true)
                ->setFormTypeOption('required', true)
                ->setFormTypeOption('empty_data', ''),
            TextField::new('isbn')
                ->setRequired(false)
                ->setFormTypeOption('required', false)
                ->setFormTypeOption('empty_data', ''),
            TextField::new('cover')
                ->setRequired(false)
                ->setFormTypeOption('required', false)
                ->setFormTypeOption('empty_data', ''),
            TextField::new('status')
                ->setRequired(false)
                ->setFormTypeOption('required', false)
                ->setFormTypeOption('empty_data', ''),
            TextField::new('slug')->hideOnForm(),
            TextEditorField::new('description')->hideOnIndex(),
            AssociationField::new('authors'),
        ];
    }
}
