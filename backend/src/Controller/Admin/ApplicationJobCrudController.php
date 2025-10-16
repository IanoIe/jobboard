<?php

namespace App\Controller\Admin;

use App\Entity\ApplicationJob;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpFoundation\Response;



final class ApplicationJobCrudController extends AbstractCrudController
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;

    }

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
        yield TextField::new('fullName')->setLabel('Candidate Name');
        //yield AssociationField::new('user')->setLabel('Name candidate');
        yield AssociationField::new('jobOffer')->setLabel('Offer & Enterprise');
        yield TextField::new('state')->setLabel('App Status');
        yield DateTimeField::new('createdAt')->setLabel('Date');

        yield TextField::new('cvLink', 'CV')
            ->onlyOnIndex()
            ->formatValue(function ($value, $entity) {
                if ($entity->getCvData()) {
                    return sprintf('<a href="/admin/application-job/%d/cv" target="_blank">download</a>', $entity->getId());
                }
                return 'None';
            })
            ->renderAsHtml();

            yield TextField::new('cvLink', 'CV')
            ->onlyOnDetail()
            ->formatValue(function ($value, $entity) {
                if ($entity->getCvData()) {
                    return sprintf('<a href="/admin/application-job/%d/cv" target="_blank">download</a>', $entity->getId());
                }

                return 'None';
            })
            ->renderAsHtml();
        }

        public function configureFilters(Filters $filters): Filters
        {
            return $filters->add('state');
        }

        public function downloadCv(int $id, EntityManagerInterface $em): Response
        {
            $application = $em->getRepository(ApplicationJob::class)->find($id);

            if (!$application || !$application->getCvData()) {
                throw $this->createNotFoundException('Don´t cv.');
            }

            $cvData = $application->getCvData();

            if (is_resource($cvData)) {
                $cvData = stream_get_contents($cvData);
            }

            $response = new StreamedResponse(function () use ($cvData) {
                echo $cvData;
            });

            $response->headers->set('Content-Type', 'application/pdf');
            $response->headers->set('Content-Disposition', 'inline; filename="cv.pdf"');
            return $response;
        }

        public function createIndexQueryBuilder(
            SearchDto $searchDto,
            EntityDto $entityDto,
            FieldCollection $fields,
            FilterCollection $filters
            ): QueryBuilder {
                $user = $this->security->getUser();
                if ($this->security->isGranted('ROLE_ADMIN')) {
                    return parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);
                }

                $qb = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);

                $rootAlias = $qb->getRootAliases()[0];
                $qb->join($rootAlias.'.jobOffer', 'j')
                    ->andWhere('j.user = :currentUser')
                    ->setParameter('currentUser', $user);

            return $qb;
       }

}
