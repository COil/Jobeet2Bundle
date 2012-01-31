<?php

namespace COil\Jobeet2Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use COil\Jobeet2Bundle\Entity\Job;

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

    /**
     * Add a job to the user history.
     *
     * @param Job $job
     */
    protected function addJobToHistory(Job $job)
    {
        $session = $this->getRequest()->getSession();
        $ids = $session->get('job_history', array());

        if (!in_array($job->getId(), $ids))
        {
            array_unshift($ids, $job->getId());
            $session->set('job_history', array_slice($ids, 0, 3));
        }
    }

    /**
     * Get the job history and the related Job doctrine objects.
     *
     * @return Array
     */
    protected function getJobHistory()
    {
        $session = $this->getRequest()->getSession();
        $ids = $session->get('job_history', array());

        if (!empty($ids))
        {
            $repo = $this->getRepo('Job');

            return $repo->createQueryBuilder('j')
                ->andWhere('j.id IN (:ids)')
                ->setParameter('ids', $ids)
                ->getQuery()
                ->execute()
            ;
        }

        return array();
    }
}