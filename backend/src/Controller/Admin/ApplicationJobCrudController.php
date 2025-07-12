<?php

namespace App\Controller\Admin;

use App\Entity\ApplicationJob;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;


final class ApplicationJobCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ApplicationJob::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'Application Jobs')
            ->setEntityLabelInPlural('Application Jobs')
            ->setEntityLabelInSingular('Application Job')
            ->setDefaultSort(['id' => 'DESC']);
    }

    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('user')->setLabel('Name candidate');
        yield AssociationField::new('jobOffer')->setLabel('Offer & Enterprise');
        yield Field::new('state')->setLabel('App Status');
        yield Field::new('createdAt')->setLabel('Date');
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('state');
    }
}
