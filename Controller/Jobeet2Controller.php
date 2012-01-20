<?php

namespace COil\Jobeet2Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class Jobeet2Controller extends Controller
{
    /**
     * Shortcut.
     *
     * @param  String $repository
     * @return DoctrineRepository
     */
    protected function getRepo($repository)
    {
        return $this->getDoctrine()->getEntityManager()->getRepository('Jobeet2Bundle:'. $repository);
    }
}