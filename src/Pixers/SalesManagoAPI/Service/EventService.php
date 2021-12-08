<?php

namespace Pixers\SalesManagoAPI\Service;

/**
 * @author Sylwester Łuczak <sylwester.luczak@pixers.pl>
 */
class EventService extends AbstractService
{
    /**
     * Creating a new external event.
     *
     * @param  array<string, mixed>  $data  Contact event data
     */
    public function create(string $owner, string $email, array $data): object
    {
        $data = self::mergeData($data, [
            'owner' => $owner,
            'email' => $email,
        ]);

        return $this->client->doPost('contact/addContactExtEvent', $data);
    }

    /**
     * Updating external event.
     *
     * @param  array<string, mixed>  $data    New event data
     */
    public function update(string $owner, string $eventId, array $data): object
    {
        $data = self::mergeData($data, [
            'owner' => $owner,
            'contactEvent' => [
                'eventId' => $eventId,
            ],
        ]);

        return $this->client->doPost('contact/updateContactExtEvent', $data);
    }

    /**
     * Deleting contact external event.
     */
    public function delete(string $owner, string $eventId): object
    {
        return $this->client->doPost('contact/deleteContactExtEvent', [
            'owner' => $owner,
            'eventId' => $eventId,
        ]);
    }
}
