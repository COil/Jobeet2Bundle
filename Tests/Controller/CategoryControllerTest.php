<?php

namespace COil\Jobeet2Bundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CategoryControllerTest extends WebTestCase
{
    public function testShow()
    {
        $client = static::createClient();

        // 1 - The category page
        $crawler   = $client->request('GET', '/');
        $container = $client->getContainer();

        // 1.1 - Categories on homepage are clickable
        $link    = $crawler->filter('.category h1 a')->first()->link();
        $crawler = $client->click($link);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('category_show', $client->getRequest()->get('_route'));
        $this->assertEquals('design', $client->getRequest()->get('slug'));

        // 1.2 - Categories with more than 10 jobs also have a "more" link'
        $crawler = $client->request('GET', '/');
        $maxJobsOnHomepage = $container->getParameter('jobeet2.max_jobs_on_homepage');
        $this->assertEquals($crawler->filter('.category_programming tr')->count(), $maxJobsOnHomepage);

        // 1.3 - Only 20 jobs are listed
        $maxJobsOnCategoryPage = $container->getParameter('jobeet2.max_jobs_on_category');
        $link    = $crawler->filter('h1 a:contains("Programming")')->first()->link();
        $crawler = $client->click($link);
        $this->assertEquals($crawler->filter('.jobs tr')->count(), $maxJobsOnCategoryPage);

        // 1.4 - The job list is paginated
        $this->assertRegExp('/<strong>33<\/strong>/', $client->getResponse()->getContent());
        $this->assertRegExp('/<strong>1\/2<\/strong>/', $client->getResponse()->getContent());

        // 1.5 - We can access the second page with the pager
        $link = $crawler->filter('.pagination .page a')->first()->link();
        $crawler = $client->click($link);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('category_show', $client->getRequest()->get('_route'));
        $this->assertEquals('programming', $client->getRequest()->get('slug'));
        $this->assertEquals(2, $client->getRequest()->get('page'));
        $this->assertRegExp('/<strong>2\/2<\/strong>/', $client->getResponse()->getContent());
    }
}