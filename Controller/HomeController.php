<?php

namespace COil\Jobeet2Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use COil\Jobeet2Bundle\Controller\Jobeet2Controller;

/**
 * Homepage main controller.
 */
class HomeController extends Jobeet2Controller
{
    /**
     * Main controller.
     *
     * @Route("/", name="home")
     * @Route("/job.{_format}", name="job_feed")
     * @Template()
     *
     * @return Response
     */
    public function indexAction()
    {
        $route = $this->getRequest()->get('_route');
        $categoryRepo = $this->getRepo('Category');

        // Parameter to limit the number of returned results
        $maxJobsOnHomepage = $this->container->getParameter('jobeet2.max_jobs_on_homepage');

        // Retrieve categories with at least one active job
        $categories = $categoryRepo->findWithJobs();

        // Now retrieve the active jobs
        foreach ($categories as $category)
        {
            $category->setActiveJobs($categoryRepo->getActiveJobs($category->getId(), $maxJobsOnHomepage));
            $category->setCountActiveJobs($categoryRepo->countActiveJobs($category->getId()));
        }

        // Render the template with the good format
        $format = $this->getRequest()->getRequestFormat();

        return $this->render('Jobeet2Bundle:Home:index.'. $format. '.twig', array(
            'categories'        => $categories,
            'maxJobsOnHomepage' => $maxJobsOnHomepage,
            'latestPost'        => $this->getRepo('Job')->getLatestPost()
        ));
    }
}