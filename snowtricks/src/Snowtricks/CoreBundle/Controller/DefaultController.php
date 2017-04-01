<?php

namespace Snowtricks\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SnowtricksCoreBundle:Default:index.html.twig');
    }
}
