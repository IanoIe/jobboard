<?php

namespace App\Controller\Admin;

use App\Entity\JobOffer;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use Symfony\Bundle\SecurityBundle\Security;
use Doctrine\ORM\QueryBuilder;


final class JobOfferCrudController extends AbstractCrudController
{
    private Security $security;

    public function __construct(Security $security) {
        $this->security = $security;
    }

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

    public function createIndexQueryBuilder(
        SearchDto $searchDto,
        EntityDto $entityDto,
        FieldCollection $fields,
        FilterCollection $filters
        ): QueryBuilder {
            $user = $this->security->getUser();

            $qb = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);

            if (in_array('ROLE_RECRUITER', $user->getRoles())) {
                $qb->andWhere('entity.user = :user')
                   ->setParameter('user', $user);
            }

        return $qb;
    }
}
