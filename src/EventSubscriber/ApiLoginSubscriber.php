<?php

namespace App\EventSubscriber;
use App\Repository\UserRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class ApiLoginSubscriber implements EventSubscriberInterface
{
    private UserRepository $userRepo;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepo = $userRepository;
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        // ...
        $event->getRequest();

        $request = $event->getRequest();

        $path = $request->getPathInfo();
        
        if (preg_match("/^\api/", $path) && preg_match("/^\api/login$/", $path==0)) {
            
            $apiToken  = $request->headers->get("X-AUTH-TOKEN", 0);
            $user = $this->userRepo->findBy(["apiToken"=>$apiToken]);

            if(!$user){
                $event->setResponse(new JsonResponse("Utilisateur non authentifié",401));
            }

            //si existe
            return;

        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'kernel.request' => 'onKernelRequest',
        ];
    }
}
