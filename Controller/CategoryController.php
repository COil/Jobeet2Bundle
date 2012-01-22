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
        $entity = $this->getRepo('Category')->findOneBySlug($slug);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        $categoryRepo = $this->getRepo('Category');
        $entity->setActiveJobs($categoryRepo->getActiveJobs($entity->getId()));

        return array(
            'category' => $entity
        );
    }
}