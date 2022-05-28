<?php

namespace App\EventSubscriber;

use App\Entity\HistoriqueConnexion;
use App\Repository\HistoriqueConnexionRepository;
use DateTime;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Event\AuthenticationSuccessEvent;

class LoginSubscriber implements EventSubscriberInterface
{
    private HistoriqueConnexionRepository $hcRepo;
    private RequestStack $request;

    public function __construct(HistoriqueConnexionRepository $hcR, RequestStack $rq)
    {
        $this->hcRepo = $hcR;
        $this->request = $rq;
    }

    public function onSecurityAuthenticationSuccess(AuthenticationSuccessEvent $event): void
    {
        /**
         * @var User
        */

        $user = $event->getAuthenticationToken()->getUser();

        $url = $this->request->getCurrentRequest()->server->get("PATH_INFO");
        // $ip = $this->request->getCurrentRequest()->server->get("REMOTE_ADDR");
        $ip = $this->request->getCurrentRequest()->getClientIp();

        $hc = new HistoriqueConnexion();

        $hc->setDateConnexion(new DateTime())
            ->setEmail($user->getEmail())
            ->setIp($ip)
            ->setUrl($url);

        $user->setLastConnexion(new DateTime());

        $this->hcRepo->add($hc, true);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'security.authentication.success' => 'onSecurityAuthenticationSuccess',
        ];
    }
}
