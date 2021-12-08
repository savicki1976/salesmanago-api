<?php

namespace Pixers\SalesManagoAPI\Service;

/**
 * @author Sylwester Łuczak <sylwester.luczak@pixers.pl>
 */
class TaskService extends AbstractService
{
    /**
     * Create new task.
     *
     * @param  array $data Task data
     */
    public function create(array $data): object
    {
        $data = self::mergeData($data, [
            'finished' => false,
            'smContactTaskReq' => [
                'id' => false,
            ],
        ]);

        return $this->client->doPost('contact/updateTask', $data);
    }

    /**
     * Update task.
     *
     * @param  string $taskId Task internal ID
     * @param  array  $data   Task data
     */
    public function update($taskId, array $data): object
    {
        $data = self::mergeData($data, [
            'finished' => false,
            'smContactTaskReq' => [
                'id' => $taskId,
            ],
        ]);

        return $this->client->doPost('contact/updateTask', $data);
    }

    /**
     * Delete task.
     *
     * @param  string $taskId Task internal ID
     */
    public function delete($taskId): object
    {
        return $this->client->doPost('contact/updateTask', [
            'finished' => true,
            'smContactTaskReq' => [
                'id' => $taskId,
            ],
        ]);
    }
}
