<?php

namespace COil\Jobeet2Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use COil\Jobeet2Bundle\Entity\Category;
use COil\Jobeet2Bundle\Controller\Jobeet2Controller;

/**
 * Category controller.
 *
 * @Route("/category")
 */
class CategoryController extends Jobeet2Controller
{
    /**
     * Finds and displays the jobs related to a category Category.
     *
     * @Route("/{slug}", name="category_show")
     * @Route("/{slug}/feed.{_format}", name="category_feed")
     *
     * @Template()
     */
    public function showAction($slug)
    {
        $categoryRepo = $this->getRepo('Category');
        $category = $categoryRepo->findOneBySlug($slug);

        if (!$category) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        // Get query
        $query = $categoryRepo->getActiveJobs($category->getId(), null, true);

        // Build paginator
        $paginator = $this->get('knp_paginator');
        $pager = $paginator->paginate(
            $query,
            $this->get('request')->query->get('page', 1),
            $this->container->getParameter('jobeet2.max_jobs_on_category')
        );

        // Set a custom pager template
        $pager->setTemplate('Jobeet2Bundle:Category:_pager.html.twig');

        // Render the template with the requested format
        $format = $this->getRequest()->getRequestFormat();

        return $this->render('Jobeet2Bundle:Category:show.'. $format. '.twig', array(
            'category'   => $category,
            'pager'      => $pager,
            'latestPost' => $categoryRepo->getLatestPost($category->getId())
        ));
    }
}