<?php

namespace COil\Jobeet2Bundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class JobControllerTest extends WebTestCase
{
    /**
     * Test the show job page (public).
     */
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

        $crawler = $client->request('GET', sprintf('/job/sensio-labs/paris-france/%d/web-developer', $expiredJob->getId()));
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }


    /**
     * Test the create job form.
     */
    public function testNew()
    {
        // 3 - Post a Job page
        $client    = static::createClient();
        $crawler   = $client->request('GET', '/job/new');
        $container = $client->getContainer();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('job_new', $client->getRequest()->get('_route'));
        $this->assertEquals('COil\Jobeet2Bundle\Controller\JobController::newAction', $client->getRequest()->get('_controller'));
    }

    public function testNewInvalid()
    {
        // 3.1 - Submit a Job
        $client = static::createClient();
        $crawler = $this->createJob($client, array());
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('job_show', $client->getRequest()->get('_route'));

        // 3.2 - Submit a Job with invalid values
        $crawler = $this->createJob($client, array(
            'job[description]' => '',
            'job[howToApply]'  => '',
            'job[email]'       => ''
        ), false);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('job_create', $client->getRequest()->get('_route'));
        $this->assertEquals('COil\Jobeet2Bundle\Controller\JobController::createAction', $client->getRequest()->get('_controller'));
        $this->assertEquals($crawler->filter('li:contains("This value should not be blank")')->count(), 3);

    }

    public function testPublish()
    {
        // 3.3 - On the preview page, you can publish the job
        $client    = static::createClient();
        $crawler = $this->createJob($client, array(
            'job[position]' => 'FOO1',
        ));
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('job_show', $client->getRequest()->get('_route'));
        $this->assertTrue($crawler->filter('h3:contains("FOO1")')->count() > 0);
        $publish = $crawler->selectLink('Publish')->first()->link();
        $client->click($publish);
        $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('job_show_user', $client->getRequest()->get('_route'));

    }

    public function testDelete()
    {
        // 3.4 - On the preview page, you can delete the job
        $client    = static::createClient();
        $crawler = $this->createJob($client, array(
            'job[position]' => 'FOO2',
        ));
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('job_show', $client->getRequest()->get('_route'));
        $this->assertTrue($crawler->filter('h3:contains("FOO2")')->count() > 0);
        $deleteForm = $crawler->selectButton('Delete')->form();
        $client->submit($deleteForm);
        $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('home', $client->getRequest()->get('_route'));
        $this->assertFalse($client->getCrawler()->filter('html:contains("FOO2")')->count() > 0);

    }

    /**
     * Test edit.
     */
    public function testEdit()
    {
        // 3.5 - When a job is published, it cannot be edited anymore
        $client    = static::createClient();
        $container = $client->getContainer();
        $crawler = $this->createJob($client, array(
            'job[position]' => 'FOO3',
        ));
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('job_show', $client->getRequest()->get('_route'));
        $this->assertTrue($crawler->filter('h3:contains("FOO3")')->count() > 0);
        $publish = $crawler->selectLink('Publish')->first()->link();
        $client->click($publish);
        $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('job_show_user', $client->getRequest()->get('_route'));
        $this->assertFalse($client->getCrawler()->selectLink('Publish')->count() > 0);
        $job = $this->getJobByPosition($container, 'FOO3');
        $crawler = $client->request('GET', sprintf('/job/%s/edit', $job->getToken()));
        $this->assertEquals(404, $client->getResponse()->getStatusCode());


    }

    public function testExtendForbidden()
    {
        // 3.6 - A job validity cannot be extended before the job expires soon
        $client    = static::createClient();
        $container = $client->getContainer();
        $crawler = $this->createJob($client, array(
            'job[position]' => 'FOO4',
        ));
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('job_show', $client->getRequest()->get('_route'));
        $this->assertFalse($crawler->selectLink('Extend')->count() > 0);
        $job = $this->getJobByPosition($container, 'FOO4');
        $crawler = $client->request('GET', sprintf('/job/%s/extend', $job->getToken()));
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }

    public function testExtend()
    {
        // 3.7 - A job validity can be extended when the job expires soon
        $client    = static::createClient();
        $container = $client->getContainer();
        $crawler = $this->createJob($client, array(
            'job[position]' => 'FOO5',
        ));
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('job_show', $client->getRequest()->get('_route'));
        $this->assertTrue($crawler->filter('h3:contains("FOO5")')->count() > 0);

        $job = $this->getJobByPosition($container, 'FOO5');
        $publish = $crawler->selectLink('Publish')->first()->link();
        $client->click($publish);
        $client->followRedirect();

        $job->setExpiresAt(new \DateTime(date('Y-m-d', time() + 86400 * 2)));
        $em = $container->get('doctrine')->getEntityManager();
        $em->persist($job);
        $em->flush();
        $crawler = $client->request('GET', sprintf('/job/%s/show', $job->getToken()));
        $this->assertTrue($client->getCrawler()->selectLink('Extend')->count() > 0);
        $publish = $crawler->selectLink('Extend')->first()->link();
        $client->click($publish);
        $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('job_show_user', $client->getRequest()->get('_route'));
    }

    /**
     * Fill a job form and submit the datas.
     *
     * @param Array $values
     */
    protected function createJob($client, $values = array(), $followRedirect = true)
    {
        $crawler = $client->request('GET', '/job/new');
        $form    = $crawler->selectButton('Preview your job')->form();

        $formDefaults = array(
            'job[category]'    => $crawler->filter('#job_category option')->eq(3)->attr('value'),
            'job[type]'        => $crawler->filter('#job_type_freelance')->first()->attr('value'),
            'job[company]'     => 'Sensio Labs',
            'job[url]'         => 'http://www.sensio.com/',
            'job[position]'    => 'Developer',
            'job[location]'    => 'Atlanta, USA',
            'job[description]' => 'You will work with symfony to develop websites for our customers.',
            'job[howToApply]'  => 'Send me an email',
            'job[email]'       => 'for.a.job@example.com',
            'job[isPublic]'    => false
        );


        $formDefaults = array_merge($formDefaults, $values);

        $form['job[category]']    = $formDefaults['job[category]'];
        $form['job[type]']        = $formDefaults['job[type]'];
        $form['job[company]']     = $formDefaults['job[company]'];
        $form['job[url]']         = $formDefaults['job[url]'];
        $form['job[position]']    = $formDefaults['job[position]'];
        $form['job[location]']    = $formDefaults['job[location]'];
        $form['job[description]'] = $formDefaults['job[description]'];
        $form['job[howToApply]']  = $formDefaults['job[howToApply]'];
        $form['job[email]']       = $formDefaults['job[email]'];
        $form['job[isPublic]']    = $formDefaults['job[isPublic]'];

        $crawler = $client->submit($form);

        if (true == $followRedirect)
        {
            $crawler = $client->followRedirect();
        }

        return $crawler;
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

    /**
     * Shortcut.
     *
     * @param  Container $container
     * @return Job
     */
    protected function getJobByPosition($container, $position)
    {
        $repo = $container->get('doctrine')->getEntityManager()->getRepository('Jobeet2Bundle:Job');

        return $repo->findOneByPosition($position);
    }
}