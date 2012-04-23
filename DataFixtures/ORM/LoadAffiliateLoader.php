<?php

namespace COil\Jobeet2Bundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use COil\Jobeet2Bundle\DataFixtures\ORM\LoadJobeet2Data;
use COil\Jobeet2Bundle\Entity\Job as Job;

/**
 * Load Affiliate entities.
 */
class LoadAffiliatData extends LoadJobeet2Data implements OrderedFixtureInterface
{
    /**
     * Main load function.
     *
     * @param Doctrine\Common\Persistence\ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {
        $affiliates = $this->getModelFixtures();

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

            $manager->persist($job);
            $manager->flush();

            // Add a reference to be able to use this object in others loaders
            $this->addReference('Job_'. $reference, $job);
        }

        // Insert additional
        $this->duplicateLastJob($manager, $job);
    }

    /**
     * The main fixtures file for this loader.
     *
     * @return string
     */
    public function getModelFile()
    {
        return 'affiliates';
    }

    /**
     * The order in which the fixtures for this model will be loaded.
     *
     * @return integer
     */
    public function getOrder()
    {
        return 3;
    }
}