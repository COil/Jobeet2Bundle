<?php

namespace COil\Jobeet2Bundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class JobControllerTest extends WebTestCase
{
    public function testShow()
    {
        // Create a new client to browse the application
        $client = static::createClient();

        // Create a new entry in the database
        $crawler = $client->request('GET', '/');
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());
//        $crawler = $client->click($crawler->selectLink('Web Developper')->link());
//        $this->assertTrue($crawler->filter('html:contains("How to apply?")')->count() > 0);
    }

    protected function create_job($defaults = array())
    {
        static $category = null;

        if (is_null($category))
        {
            $category = Doctrine_Core::getTable('JobeetCategory')
              ->createQuery()
              ->limit(1)
              ->fetchOne();
        }

        $job = new Job();
        $job->fromArray(array_merge(array(
            'category_id'  => $category->getId(),
            'company'      => 'Sensio Labs',
            'position'     => 'Senior Tester',
            'location'     => 'Paris, France',
            'description'  => 'Testing is fun',
            'how_to_apply' => 'Send e-Mail',
            'email'        => 'job@example.com',
            'token'        => rand(1111, 9999),
            'is_activated' => true,
        ), $defaults));

        return $job;
    }


    /*
    public function exemple()
    {
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