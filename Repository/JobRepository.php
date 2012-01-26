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
    public function findAllActiveJobs($q = null, $returnQuery = false)
    {
        if (is_null($q))
        {
            $q = $this->createQueryBuilder('j');
        }

        $q = $q
            ->andWhere('j.expiresAt > :expiresAt')
            ->setParameter('expiresAt', date('Y-m-d H:i:s', time()))
            ->andWhere('j.isActivated = :isActivated')
            ->setParameter('isActivated', true)
            ->orderBy('j.expiresAt', 'DESC')
            ->getQuery()
        ;

        return $returnQuery ? $q : $q->getResult();
    }

    /**
     * Returns an active job only.
     *
     * @return COil\Jobeet2Bundle\Entity\Job
     */
    public function findOneActiveById($id)
    {
        $q = $this->createQueryBuilder('j')
            ->where('j.id = :id')
            ->setParameter('id', $id)
            ->andWhere('j.expiresAt > :expiresAt')
            ->setParameter('expiresAt', date('Y-m-d H:i:s', time()))
            ->andWhere('j.isActivated = :isActivated')
            ->setParameter('isActivated', true)
            ->getQuery()
        ;

        return $q->getOneOrNullResult();
    }

    /**
     * Returns an active job only.
     *
     * @return COil\Jobeet2Bundle\Entity\Job
     */
    public function findOneActiveByToken($token)
    {
        $q = $this->createQueryBuilder('j')
            ->where('j.token = :token')
            ->setParameter('token', $token)
            ->andWhere('j.expiresAt > :expiresAt')
            ->setParameter('expiresAt', date('Y-m-d H:i:s', time()))
            ->getQuery()
        ;

        return $q->getOneOrNullResult();
    }

    /**
     * Returns an expired job only.
     *
     * @return COil\Jobeet2Bundle\Entity\Job
     */
    public function findOneExpired()
    {
        $q = $this->createQueryBuilder('j')
            ->andWhere('j.expiresAt < :expiresAt')
            ->setParameter('expiresAt', date('Y-m-d H:i:s', time()))
            ->getQuery()
        ;

        return $q->getOneOrNullResult();
    }
}