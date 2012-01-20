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
        // Parameter ti limit the number of returned results
        $maxJobsOnHomepage = $this->container->getParameter('jobeet2.max_jobs_on_homepage');

        return array(
            'categories' => $this->getRepo('Category')->findWithJobs($maxJobsOnHomepage)
        );
    }
}