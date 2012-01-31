<?php

namespace COil\Jobeet2Bundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Yaml\Yaml;

abstract class LoadJobeet2Data extends AbstractFixture implements ContainerAwareInterface
{
    /**
     * Return the file for the current model.
     */
    abstract function getModelFile();

    /**
     * @var Symfony\Component\DependencyInjection\ContainerInterface
     */
    private $container;

    /**
     * Make the sc available to our loader.
     *
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Return the fixtures for the current model.
     *
     * @return Array
     */
    public function getModelFixtures()
    {
        $fixturesPath = realpath(dirname(__FILE__). '/../fixtures');
        $fixtures     = Yaml::parse(file_get_contents($fixturesPath. '/'. $this->getModelFile(). '.yml'));

        return $fixtures;
    }
}