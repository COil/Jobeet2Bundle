<?php

namespace COil\Jobeet2Bundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class JobControllerTest extends WebTestCase
{
    public function testShow()
    {
        $client    = static::createClient();

        // 2 - The job page
        $crawler   = $client->request('GET', '/');
        $container = $client->getContainer();

        // 2.1 - Each job on the homepage is clickable and give detailed information
        $link    = $crawler->filter('.category_programming tr a')->first()->link();
        $crawler = $client->click($link);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('job_show', $client->getRequest()->get('_route'));
        $this->assertEquals(1, $client->getRequest()->get('id'));

        // 2.2 - A non-existent job forwards the user to a 404
        $crawler = $client->request('GET', '/job/foo-inc/milano-italy/0/painter');
        $this->assertEquals(404, $client->getResponse()->getStatusCode());

        // 2.3 - An expired job page forwards the user to a 404
        $expiredJob = $this->getExpiredJob($container);
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

    /*
    public function exemple()
    {
        //$container->get('coil.tools.debug')->dump($expiredJob, '$expiredJob', 1);

        // Create a new client to browse the application
        $client = static::createClient();

        // Create a new entry in the database
        $crawler = $client->request('GET', '/job/');
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());
        $crawler = $client->click($crawler->selectLink('Create a new entry')->link());

        // Fill in the form and submit it
        $form = $crawler->selectButton('Create')->form(array(
            'job[field_name]'  => 'Test',
            // ... other fields to fill
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check data in the show view
        $this->assertTrue($crawler->filter('td:contains("Test")')->count() > 0);

        // Edit the entity
        $crawler = $client->click($crawler->selectLink('Edit')->link());

        $form = $crawler->selectButton('Edit')->form(array(
            'job[field_name]'  => 'Foo',
            // ... other fields to fill
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check the element contains an attribute with value equals "Foo"
        $this->assertTrue($crawler->filter('[value="Foo"]')->count() > 0);

        // Delete the entity
        $client->submit($crawler->selectButton('Delete')->form());
        $crawler = $client->followRedirect();

        // Check the entity has been delete on the list
        $this->assertNotRegExp('/Foo/', $client->getResponse()->getContent());
    }
    */
}