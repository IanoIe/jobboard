<?php

namespace App\Controller\Admin;

use App\Entity\JobOffer;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

final class JobOfferCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return JobOffer::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'JobOffer')
            ->setEntityLabelInPlural('Job Offers')
            ->setEntityLabelInSingular('Job Offer')
            ->setDefaultSort(['id' => 'DESC']);
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('nomEnterprise')->setLabel('Enterprise');
        yield TextField::new('title')->setLabel('Offer');
        yield TextField::new('typeContract');
        yield TextField::new('description');
        yield Field::new('createdAt')->onlyOnIndex()->setLabel('Date');
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('title');

    }
}
