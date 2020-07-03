<?php


namespace App\Tests\Functional\Api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{
    public function testCreate()
    {
        $data = [
            'name' => 'Name',
            'status' => 'new',
        ];

        $client = static::createClient();

        $client->request('POST', '/api/task', [], [], [
            'CONTENT_TYPE' => 'application/json',
        ], json_encode($data));

        $this->assertEquals(201, $client->getResponse()->getStatusCode());
        $task = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals($task['name'], $data['name']);
        $this->assertEquals($task['status'], $data['status']);
        return $task;
    }

    /**
     * @depends testCreate
     */
    public function testGet(array $task)
    {
        $client = static::createClient();
        $id = $task['id'];

        $client->request('GET', "/api/task/{$id}");

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * @depends testCreate
     */
    public function testList(array $task)
    {
        $client = static::createClient();
        $client->request('GET', "/api/tasks");
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertIsArray($data);
        $this->assertContains($task, $data);
    }

    /**
     * @depends testCreate
     */
    public function testUpdate(array $task)
    {
        $id = $task['id'];
        $task['name'] = 'New name';

        $client = static::createClient();

        $client->request('PUT', "/api/task/{$id}", [], [], [
            'CONTENT_TYPE' => 'application/json',
        ], json_encode($task));

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $task = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals($task['name'], 'New name');
    }

    /**
     * @depends testCreate
     */
    public function testDelete(array $task)
    {
        $id = $task['id'];
        $client = static::createClient();

        $client->request('DELETE', "/api/task/{$id}");
        $this->assertEquals(204, $client->getResponse()->getStatusCode());
    }

    public function testGetNonExistingTaskShouldTriggerException()
    {
        $client = static::createClient();
        $client->request('GET', "/api/tasks");
        $data = json_decode($client->getResponse()->getContent(), true);
        $existingIds = array_map(function ($item) {
            return $item['id'];
        }, $data);
        $nonExistingId = $this->getRandomId($existingIds);
        $client->request('GET', "/api/task/{$nonExistingId}");
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }

    protected function getRandomId(array $except = [])
    {
        do {
            $id = mt_rand(1, 10000);
        } while (in_array($id, $except));
        return $id;
    }
}