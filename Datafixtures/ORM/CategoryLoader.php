<?php

namespace COil\Jobeet2Bundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use COil\Jobeet2Bundle\DataFixtures\ORM\LoadJobeet2Data;
use COil\Jobeet2Bundle\Entity\Category as Category;

class LoadCategoryData extends LoadJobeet2Data implements OrderedFixtureInterface
{
    /**
     * Main load function.
     *
     * @param type $manager
     */
    public function load($manager)
    {
        $categories = $this->getModelFixtures();

        // Now iterate thought all fixtures
        foreach ($categories['Category'] as $reference => $columns)
        {
            $category = new Category();
            $category->setName($columns['name']);
            $category->setSlug($reference);         // TODO
            $category->setCreatedAt(new \DateTime); // TODO
            $category->setUpdatedAt(new \DateTime); // TODO
            $manager->persist($category);
            $manager->flush();

            // Add the reference to use it in other fixtures loader
            $this->addReference('Category_'. $reference, $category);
        }
    }

    /**
     * The main fixtures files for this loader.
     */
    public function getModelFile()
    {
        return 'categories';
    }

    /**
     * The order in which fixtures will be loaded.
     */
    public function getOrder()
    {
        return 1;
    }
}