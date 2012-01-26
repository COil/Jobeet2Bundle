<?php

namespace COil\Jobeet2Bundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class JobControllerTest extends WebTestCase
{
    public function testShow()
    {
        $client = static::createClient();

        // 2 - The job page
        $crawler   = $client->request('GET', '/');
        $container = $client->getContainer();

        // 2.1 - Each job on the homepage is clickable and give detailed information
        $link    = $crawler->filter('.category_programming tr a')->first()->link();
        $crawler = $client->click($link);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('job_show_user', $client->getRequest()->get('_route'));
        $this->assertEquals(1, $client->getRequest()->get('id'));

        // 2.2 - A non-existent job forwards the user to a 404
        $crawler = $client->request('GET', '/job/foo-inc/milano-italy/0/painter');
        $this->assertEquals(404, $client->getResponse()->getStatusCode());

        // 2.3 - An expired job page forwards the user to a 404
        $expiredJob = $this->getExpiredJob($container);
        //$container->get('coil.tools.debug')->dump($expiredJob, '$expiredJob', 1);

        $crawler = $client->request('GET', sprintf('/job/sensio-labs/paris-france/%d/web-developer', $expiredJob->getId()));
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }

    /**
     * Shortcut.
     *
     * @param  Container $container
     * @return Job
     */
    protected function getExpiredJob($container)
    {
        $repo = $container->get('doctrine')->getEntityManager()->getRepository('Jobeet2Bundle:Job');

        return $repo->findOneExpired();
    }
}