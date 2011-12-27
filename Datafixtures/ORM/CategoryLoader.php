<?php

namespace COil\Jobeet2Bundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use COil\Jobeet2Bundle\Entity\Category;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load($manager)
    {
        $categories = array(
            'Design',
            'Programming',
            'Manager',
            'Administrator'
        );

        foreach ($categories as $name)
        {
            $category = new Category();
            $category->setName($name);
            $category->setSlug($name);

            // @TODO
            $category->setCreatedAt(new \DateTime);
            $category->setUpdatedAt(new \DateTime);
            $manager->persist($category);
            $manager->flush();

            $this->addReference('category_'. $category->getId(), $category);
        }
    }

    /**
     * The order in which fixtures will be loaded
     */
    public function getOrder()
    {
        return 1;
    }
}