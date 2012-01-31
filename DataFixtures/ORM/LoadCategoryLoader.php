<?php

namespace COil\Jobeet2Bundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use COil\Jobeet2Bundle\DataFixtures\ORM\LoadJobeet2Data;
use COil\Jobeet2Bundle\Entity\Category as Category;

class LoadCategoryData extends LoadJobeet2Data implements OrderedFixtureInterface
{
    /**
     * Main load function.
     *
     * @param Doctrine\Common\Persistence\ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {
        $categories = $this->getModelFixtures();

        // Now iterate thought all fixtures
        foreach ($categories['Category'] as $reference => $columns)
        {
            $category = new Category();
            $category->setName($columns['name']);
            $category->setSlug($reference);
            $category->setCreatedAt(new \DateTime());
            $category->setUpdatedAt(new \DateTime());
            $manager->persist($category);
            $manager->flush();

            // Add a reference to be able to use this object in others entities loaders
            $this->addReference('Category_'. $reference, $category);
        }
    }

    /**
     * The main fixtures file for this loader.
     */
    public function getModelFile()
    {
        return 'categories';
    }

    /**
     * The order in which these fixtures will be loaded.
     */
    public function getOrder()
    {
        return 1;
    }
}