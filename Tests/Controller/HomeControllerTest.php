<?php

namespace COil\Jobeet2Bundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{
    /**
     * Test the index action of the Homepage controller.
     */
    public function testIndex()
    {
        $client    = static::createClient();
        $crawler   = $client->request('GET', '/');
        $container = $client->getContainer();

        // 1 - The homepage - Check response code, route and controller
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('home', $client->getRequest()->get('_route'));
        $this->assertEquals('COil\Jobeet2Bundle\Controller\HomeController::indexAction', $client->getRequest()->get('_controller'));

        // 1.1 - Expired jobs are not listed
        $this->assertFalse($crawler->filter('.jobs td.position:contains("expired")')->count() > 0);

        // 1.2 - Only 10 jobs are listed for a category
        $maxJobsOnHomepage = $container->getParameter('jobeet2.max_jobs_on_homepage');
        $this->assertEquals($crawler->filter('.category_programming tr')->count(), $maxJobsOnHomepage);

        // 1.3.1 - A category has a link to the category page only if too many jobs
        $this->assertEquals($crawler->filter('.category_design .more_jobs')->count(), 0);

        // 1.3.2 - The oppposite of 1.3.1 for the programming category
        $this->assertEquals($crawler->filter('.category_programming .more_jobs')->count(), 1);

        // 1.4 - Jobs are sorted by date
        $mostRecentJob = $this->getMostRecentProgrammingJob($container);
        $findJob = $crawler->filter('.category_programming tr')->first()->filter('a[id="position_'. $mostRecentJob->getId().'"]');
        $this->assertTrue($findJob->count() == 1);
    }

    /**
     * Shortcut.
     *
     * @param  Container $container
     * @return Job
     */
    protected function getMostRecentProgrammingJob($container)
    {
        $repo = $container->get('doctrine')->getEntityManager()->getRepository('Jobeet2Bundle:Category');;

        return $repo->getMostRecentProgrammingJob();
    }
}
