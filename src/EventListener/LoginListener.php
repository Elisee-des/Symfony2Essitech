<?php

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\RequestEvent;

class LoginListener {

    public function onKernelRequest(RequestEvent $event)
    {
        dd($event);
    }
    
}