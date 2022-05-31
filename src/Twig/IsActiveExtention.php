<?php

namespace App\Twig;

use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class IsActiveExtention extends AbstractExtension
{
    private $requestStack;

    public function __construct(RequestStack $rq)
    {
        $this->requestStack=$rq;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('isActive', [$this, "isActive"]),
        ];
    }

    public function isActive($lien=[]): string
    {
        $routeActuel = $this->requestStack->getCurrentRequest()->get("_route");

        if (in_array($routeActuel, $lien)) {

            return "active";

        }else return "";
    }
}