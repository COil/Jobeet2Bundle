<?php

namespace COil\Jobeet2Bundle\Repository;

use Doctrine\ORM\EntityRepository;

class CategoryRepository extends EntityRepository
{
    /**
     * Returns all categories that have at least one non expired job.
     *
     * @return COil\Jobeet2Bundle\Entity\Category[]
     */
    public function findWithJobs()
    {
        $q = $this->createQueryBuilder('c');
        $q = $this->addWithActiveJobsCriterias($q);
        $q = $q->getQuery();

        return $q->getResult();
    }

    /**
     * Count the number of active Jobs for a given category.
     * @param type $id
     */
    public function countActiveJobs($id)
    {
        $repo = $this->getEntityManager()->getRepository('Jobeet2Bundle:Job');
        $q = $repo->createQueryBuilder('j')
            ->select('count(j.id)')
            ->andWhere('j.category = :category')
            ->setParameter('category', $id)
        ;
        $q = $repo->findAllActiveJobs($q, true);

        return $q->getSingleScalarResult();
    }

    /**
     * Count the number of active Jobs for a given category.
     * @param type $id
     */
    public function getActiveJobs($id, $maxResults = null)
    {
        // Build the query for the current category and use the jobRepository function
        $repo = $this->getEntityManager()->getRepository('Jobeet2Bundle:Job');
        $q = $repo->createQueryBuilder('j')
            ->andWhere('j.category = :category')
            ->setParameter('category', $id)
            ->setMaxResults($maxResults)
        ;

        return $repo->findAllActiveJobs($q);
    }

    /**
     * Add criteria to a QueryBuilder to restrict on only active jobs.
     *
     * @param type $q
     * @return type
     */
    public function addWithActiveJobsCriterias($q)
    {
        $q->leftJoin('c.jobs', 'j')
            ->andWhere('j.expiresAt > :expiresAt')
            ->setParameter('expiresAt', date('Y-m-d H:i:s', time()))
        ;

        return $q;
    }
}