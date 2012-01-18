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
            $job->setType($columns['type']);
            $job->setCompany($columns['company']);
            $job->setLogo($columns['logo']);
            $job->setLocation($columns['location']);
            $job->setUrl($columns['url']);
            $job->setPosition($columns['position']);
            $job->setDescription($columns['description']);
            $job->setHowToApply($columns['how_to_apply']);
            $job->setIsPublic($columns['is_public']);
            $job->setIsActivated($columns['is_activated']);
            $job->setToken($columns['token']);
            $job->setEmail($columns['email']);
            $job->setExpiresAt(new \DateTime($columns['expires_at']));
            //$job->setSlug($reference);       // TODO
            $job->setCreatedAt(new \DateTime); // TODO
            $job->setUpdatedAt(new \DateTime); // TODO
            $manager->persist($job);
            $manager->flush();

            // Add a reference to be able to use this object in others loaders
            $this->addReference('Job_'. $reference, $job);
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