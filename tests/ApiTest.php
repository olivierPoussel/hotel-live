<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiTest extends WebTestCase
{
    public function testApi() 
    {
        $expected = '[{"id":92,"name":"ducimus","number":1,"price":109.28},{"id":93,"name":"porro","number":2,"price":65.12},{"id":94,"name":"id","number":3,"price":135.79},{"id":95,"name":"perspiciatis","number":4,"price":134.73},{"id":96,"name":"nihil","number":5,"price":112.36},{"id":97,"name":"ea","number":6,"price":111.31},{"id":98,"name":"iste","number":7,"price":79.75},{"id":99,"name":"odit","number":8,"price":55.67},{"id":100,"name":"doloremque","number":9,"price":123.19},{"id":101,"name":"laborum","number":10,"price":97.77}]';
        $client = static::createClient();

        $client->request('GET', '/api/rooms');

        $content = $client->getResponse()->getContent();

        $this->assertEquals($expected, $content);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
