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
    public function findWithJobs($max)
    {
        $q = $this->createQueryBuilder('c')
            ->leftJoin('c.jobs', 'j')
            ->addSelect('j')
            ->where('j.expiresAt > :expiresAt')
            ->setParameter('expiresAt', date('Y-m-d H:i:s', time()))
            ->setMaxResults($max)
            ->getQuery()
        ;

        return $q->getResult();
    }
}