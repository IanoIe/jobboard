<?php

namespace App\EventSubscriber;

use ApiPlatform\Symfony\EventListener\EventPriorities;
use App\Entity\JobOffer;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class JobOfferSubscriber implements EventSubscriberInterface
{
    public function __construct(private Security $security){}

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::VIEW => ['setUserForJobOffer', EventPriorities::PRE_VALIDATE],
        ];
    }

    public function setUserForJobOffer(ViewEvent $event): void
    {
        $jobOffer = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$jobOffer instanceof JobOffer || $method !== 'POST'){
            return;
        }

        $user = $this->security->getUser();
        $jobOffer->setUser($user);
    }
}
