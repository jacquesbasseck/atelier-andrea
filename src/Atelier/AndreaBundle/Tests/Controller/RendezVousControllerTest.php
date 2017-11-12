<?php

namespace Atelier\AndreaBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RendezVousControllerTest extends WebTestCase
{
    public function testEmploidutemps()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'emploidutemps');
    }

}
