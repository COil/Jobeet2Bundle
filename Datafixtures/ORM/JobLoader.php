<?php

namespace COil\Jobeet2Bundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use COil\Jobeet2Bundle\DataFixtures\ORM\LoadJobeet2Data;
use COil\Jobeet2Bundle\Entity\Job as Job;

class LoadJobData extends LoadJobeet2Data implements OrderedFixtureInterface
{
    /**
     * Main load function.
     *
     * @param type $manager
     */
    public function load($manager)
    {
        $jobs = $this->getModelFixtures();

        // Now iterate thought all fixtures
        foreach ($jobs['Job'] as $reference => $columns)
        {
            // Create our new Job entity
            $job = new Job();

            // Assign category from the fixtures references
            $category = $this->getReference('Category_'. $columns['Category']);
            $job->setCategory($category);

            // Now assign standart values
            $job->setType(isset($columns['type']) ? $columns['type'] : null);
            $job->setCompany($columns['company']);
            $job->setLogo(isset($columns['logo']) ? $columns['logo'] : null);
            $job->setLocation($columns['location']);
            $job->setUrl(isset($columns['url']) ? $columns['url'] : null);
            $job->setPosition($columns['position']);
            $job->setDescription($columns['description']);
            $job->setHowToApply($columns['how_to_apply']);
            $job->setIsPublic($columns['is_public']);
            $job->setIsActivated($columns['is_activated']);
            $job->setToken($columns['token']);
            $job->setEmail($columns['email']);
            //$job->setSlug($reference);       // TODO
            $job->setCreatedAt(new \DateTime(isset($columns['created_at']) ? $columns['created_at'] : null));
            $job->setUpdatedAt(new \DateTime(isset($columns['updated_at']) ? $columns['updated_at'] : null));

            // Don't persiste the job_add fixture because its the reference job for duplication
            if ('job_add' != $reference)
            {
                $manager->persist($job);
                $manager->flush();

                // Add a reference to be able to use this object in others loaders
                $this->addReference('Job_'. $reference, $job);
            }
        }

        // Insert additional
        $this->duplicateLastJob($manager, $job);
    }

    /**
     * Add addtional Jobs so we can test record limits and pagers.
     *
     * @param type $job
     */
    protected function duplicateLastJob($manager, $job)
    {
        for ($i = 100; $i <= 130; $i++)
        {
            $jobClone = clone $job;
            $jobClone->setCompany(sprintf($job->getCompany(), $i));
            $jobClone->setHowToApply(sprintf($job->getHowToApply(), $i));
            $jobClone->setToken(sprintf($job->getToken(), $i));
            $manager->persist($jobClone);
            $manager->flush();
        }
    }

    /**
     * The main fixtures files for this loader.
     */
    public function getModelFile()
    {
        return 'jobs';
    }

    /**
     * The order in which the fixtures for this model will be loaded.
     */
    public function getOrder()
    {
        return 2;
    }
}