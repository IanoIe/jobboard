<?php

namespace App\Controller\Admin;

use App\Entity\ApplicationJob;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

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
}
