<?php

namespace COil\Jobeet2Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use COil\Jobeet2Bundle\Controller\Jobeet2Controller as Jobeet2Controller;

class HomeController extends Jobeet2Controller
{
    /**
     * @Route("/", name="home")
     * @Template()
     */
    public function indexAction()
    {
        return array(
            'jobeet_jobs' => $this->getJobs()
        );
    }

    /**
     * Get the list of Jobs for the template.
     */
    protected function getJobs()
    {
        $jobeet_jobs = $this->getDoctrine()
            ->getRepository('Jobeet2Bundle:Job')
            ->findAll()
        ;

        return $jobeet_jobs;
    }
}
