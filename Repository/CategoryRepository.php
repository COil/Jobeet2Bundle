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
     * Get the active Jobs for a given category.
     *
     * @param Integer $id
     * @param Integer $maxResults
     */
    public function getActiveJobs($id, $maxResults = null, $returnQuery = false)
    {
        // Build the query for the current category and use the jobRepository function
        $repo = $this->getEntityManager()->getRepository('Jobeet2Bundle:Job');
        $q = $repo->createQueryBuilder('j')
            ->andWhere('j.category = :category')
            ->setParameter('category', $id)
        ;

        if (!is_null($maxResults))
        {
            $q->setMaxResults($maxResults);
        }

        return $returnQuery ? $repo->findAllActiveJobs($q, true) : $repo->findAllActiveJobs($q);
    }

    /**
     * Add criteria to a QueryBuilder to restrict on only active jobs.
     *
     * @param type $q
     * @return type
     */
    protected function addWithActiveJobsCriterias(\Doctrine\ORM\QueryBuilder $q)
    {
        $q->leftJoin('c.jobs', 'j')
            ->andWhere('j.expiresAt > :expiresAt')
            ->setParameter('expiresAt', date('Y-m-d H:i:s', time()))
            ->andWhere('j.isActivated = :isActivated')
            ->setParameter('isActivated', true)
            ->addOrderBy('c.name', 'ASC')
            ->addOrderBy('j.createdAt', 'DESC');
        ;

        return $q;
    }

    /**
     * Get the most recent Job from the category with slug "programming"
     *
     * @return Job
     */
    public function getMostRecentProgrammingJob()
    {
        $programming = $this->findOneBySlug('programming');
        $job =  $this->getActiveJobs($programming->getId(), 1);

        return $job ? $job[0] : null;
    }

    /**
     * Get the latest Job for the category.
     *
     * @param Integer $id
     * @return Job
     */
    public function getLatestPost($id)
    {
        $lastestJob = $this->getActiveJobs($id, 1);

        return $lastestJob ? $lastestJob[0] : null;
    }
}