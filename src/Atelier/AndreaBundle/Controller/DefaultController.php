<?php

namespace Atelier\AndreaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AtelierAndreaBundle:Default:index.html.twig');
    }
}
