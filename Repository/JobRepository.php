<?php

namespace COil\Jobeet2Bundle\Repository;

use Doctrine\ORM\EntityRepository;

class JobRepository extends EntityRepository
{
    /**
     * Returns active jobs.
     *
     * @return COil\Jobeet2Bundle\Entity\Job[]
     */
    public function findAllActiveJobs(Doctrine\ORM\QueryBuilder $q = null)
    {

        if (is_null($q))
        {
            $q = $this->createQueryBuilder('j');
        }


        $q = $q
            ->where('j.expiresAt > :expiresAt')
            ->setParameter('expiresAt', date('Y-m-d H:i:s', time()))
            ->orderBy('j.expiresAt', 'DESC')
            ->getQuery()
        ;

        return $q->getResult();
    }

    /**
     * Returns an active job only.
     *
     * @return COil\Jobeet2Bundle\Entity\Job
     */
    public function findOneActive($id)
    {
        $q = $this->createQueryBuilder('j')
            ->where('j.id = :id')
            ->setParameter('id', $id)
            ->andWhere('j.expiresAt > :expiresAt')
            ->setParameter('expiresAt', date('Y-m-d H:i:s', time()))
            ->getQuery()
        ;

        return $q->getOneOrNullResult();
    }
}