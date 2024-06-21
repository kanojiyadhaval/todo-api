<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TodoTest extends WebTestCase
{
    public function testCreateTodo()
    {
        $client = static::createClient();
        $client->request('POST', '/todos', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'title' => 'Test Todo',
            'description' => 'This is a test todo',
            'status' => 'pending',
        ]));

        $this->assertEquals(201, $client->getResponse()->getStatusCode());
    }

    public function testGetAllTodos()
    {
        $client = static::createClient();
        $client->request('GET', '/todos');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testGetTodoById()
    {
        $client = static::createClient();
        $client->request('GET', '/todos/1');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testUpdateTodo()
    {
        $client = static::createClient();
        $client->request('PUT', '/todos/1', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'title' => 'Updated Test Todo',
            'description' => 'This is an updated test todo',
            'status' => 'completed',
        ]));

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testDeleteTodo()
    {
        $client = static::createClient();
        $client->request('DELETE', '/todos/1');

        $this->assertEquals(204, $client->getResponse()->getStatusCode());
    }
}
