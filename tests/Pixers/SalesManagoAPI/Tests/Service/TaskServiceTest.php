<?php

namespace Pixers\SalesManagoAPI\Tests\Service;

use Pixers\SalesManagoAPI\Service\TaskService;

/**
 * @author Sylwester Łuczak <sylwester.luczak@pixers.pl>
 */
class TaskServiceTest extends AbstractServiceTest
{
    const TEST_NOTE = 'Call to client.';
    const TEST_NOTE_NEW = 'Call to client - its very important.';
    const TEST_REMINDER = '_15_MIN';
    const TEST_REMINDER_NEW = '_30_MIN';

    /**
     * @var TaskService
     */
    protected static $taskService;

    /**
     * Setup task service.
     */
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        self::$taskService = new TaskService(self::$salesManagoClient);

        self::createContact();
    }

    public function testCreate(): string
    {
        $data = [
            'smContactTaskReq' => [
                'note' => self::TEST_NOTE,
                'date' => date('c', time()),
                'cc' => self::$config['owner'],
                'reminder' => self::TEST_REMINDER
            ]
        ];

        $response = self::$taskService->create($data);

        $this->assertInstanceOf(\stdClass::class, $response);

        $this->assertObjectHasAttribute('success', $response);
        $this->assertIsBool($response->success);
        $this->assertTrue($response->success);

        $this->assertObjectHasAttribute('message', $response);
        $this->assertIsArray($response->message);

        $this->assertObjectHasAttribute('taskId', $response);
        $this->assertIsString($response->taskId);
        $this->assertNotEmpty($response->taskId);

        return $response->taskId;
    }

    /**
     * @depends testCreate
     */
    public function testUpdate(string $taskId): string
    {
        $data = [
            'smContactTaskReq' => [
                'id' => $taskId,
                'note' => self::TEST_NOTE_NEW,
                'date' => date('c', time()),
                'reminder' => self::TEST_REMINDER_NEW
            ]
        ];

        $response = self::$taskService->update($taskId, $data);

        $this->assertInstanceOf(\stdClass::class, $response);

        $this->assertObjectHasAttribute('success', $response);
        $this->assertIsBool($response->success);
        $this->assertTrue($response->success);

        $this->assertObjectHasAttribute('message', $response);
        $this->assertIsArray($response->message);

        $this->assertObjectHasAttribute('taskId', $response);
        $this->assertIsString($response->taskId);
        $this->assertNotEmpty($response->taskId);
        $this->assertEquals($taskId, $response->taskId);

        $data = [
            'email' => [
                self::$config['contactEmail']
            ]
        ];

        $response = self::$contactService->listByEmails(self::$config['owner'], $data);

        $this->assertInstanceOf(\stdClass::class, $response);

        $this->assertObjectHasAttribute('success', $response);
        $this->assertIsBool($response->success);
        $this->assertTrue($response->success);

        $this->assertObjectHasAttribute('message', $response);
        $this->assertIsArray($response->message);

        $this->assertObjectHasAttribute('contacts', $response);
        $this->assertIsArray($response->contacts);
        $this->assertNotEmpty($response->contacts);
        $this->assertCount(1, $response->contacts);

        $contactData = $response->contacts[0];

        $this->assertInstanceOf(\stdClass::class, $contactData);
        $this->assertObjectHasAttribute('contactTasks', $contactData);
        $this->assertIsArray($contactData->contactTasks);
        $this->assertNotEmpty($contactData->contactTasks);

        $contactTask = $contactData->contactTasks[0];

        $this->assertInstanceOf(\stdClass::class, $contactTask);

        $this->assertObjectHasAttribute('id', $contactTask);
        $this->assertIsString($contactTask->id);
        $this->assertEquals($taskId, $contactTask->id);

        $this->assertObjectHasAttribute('note', $contactTask);
        $this->assertIsString($contactTask->note);
        $this->assertEquals(self::TEST_NOTE_NEW, $contactTask->note);

        $this->assertObjectHasAttribute('date', $contactTask);
        $this->assertIsFloat($contactTask->date);

        $this->assertObjectHasAttribute('cc', $contactTask);
        $this->assertIsString($contactTask->cc);

        $this->assertObjectHasAttribute('reminder', $contactTask);
        $this->assertIsFloat($contactTask->reminder);
        $this->assertEquals(self::TEST_REMINDER_NEW, $contactTask->reminder);

        return $response->taskId;
    }

    /**
     * @depends testUpdate
     */
    public function testDelete(string $taskId): void
    {
        $response = self::$taskService->delete($taskId);

        $this->assertInstanceOf(\stdClass::class, $response);

        $this->assertObjectHasAttribute('success', $response);
        $this->assertIsBool($response->success);
        $this->assertTrue($response->success);

        $this->assertObjectHasAttribute('message', $response);
        $this->assertIsArray($response->message);

        $this->assertObjectHasAttribute('taskId', $response);
        $this->assertIsString($response->taskId);
        $this->assertNotEmpty($response->taskId);
        $this->assertEquals($taskId, $response->taskId);
    }

    /**
     * Removing contact.
     */
    public static function tearDownAfterClass(): void
    {
        self::removeContact();
    }
}
