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
     * Finds and displays a Category entity.
     *
     * @Route("/{slug}", name="category_show")
     *
     * @Template()
     */
    public function showAction($slug)
    {
        $category = $this->getRepo('Category')->findOneBySlug($slug);

        if (!$category) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        // Get query
        $categoryRepo = $this->getRepo('Category');
        $query = $categoryRepo->getActiveJobs($category->getId(), null, true);

        // Build paginator
        $paginator = $this->get('knp_paginator');
        $pager = $paginator->paginate(
            $query,
            $this->get('request')->query->get('page', 1),
            $this->container->getParameter('jobeet2.max_jobs_on_category')
        );

        $pager->setTemplate('Jobeet2Bundle:Category:_pager.html.twig');

        return compact('category', 'pager');
    }
}