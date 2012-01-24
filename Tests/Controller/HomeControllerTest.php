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
        $client = static::createClient();
        $container = $client->getContainer();
        $maxJobsOnHomepage = $container->getParameter('jobeet2.max_jobs_on_homepage');
        $crawler = $client->request('GET', '/');

        // 1.1 - Expired jobs are not listed
        $this->assertFalse($crawler->filter('.jobs td.position:contains("expired")')->count() > 0);

        // 1.2 - Only 10 jobs are listed for a category
        $this->assertEquals($crawler->filter('.category_programming tr')->count(), $maxJobsOnHomepage);

        // 1.3.1 - A category has a link to the category page only if too many jobs
        $this->assertFalse($crawler->filter('.category_design .more_jobs')->count() > 1);
        // 1.3.2
        $this->assertFalse($crawler->filter('.category_design .more_jobs')->count() > 1);

        // Get 1st created job in the programming category
        $mostRecentJob = $this->getMostRecentJob($container);
        //$container->get('coil.tools.debug')->dump($mostRecentJob, '$mostRecentJob', 1, 2);

        // 1.4 - Jobs are sorted by date
        $findJob = $crawler->filter('.category_programming tr')->first()->filter('a[id="position_'. $mostRecentJob->getId().'"]');
        $this->assertTrue($findJob->count() == 1);
    }

    /**
     * Shortcut.
     *
     * @param  Container $container
     * @return Job
     */
    protected function getMostRecentJob($container)
    {
        $repo = $container->get('doctrine')->getEntityManager()->getRepository('Jobeet2Bundle:Category');;

        return $repo->getMostRecentProgrammingJob();
    }
}
