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
     * @param  string $owner Contact owner e-mail address
     * @param  string $email Contact e-mail address
     * @param  array  $data  Contact event data
     */
    public function create($owner, $email, array $data): object
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
     * @param  string $owner   Contact owner e-mail address
     * @param  string $eventId Ext event identifier
     * @param  array  $data    New event data
     */
    public function update($owner, $eventId, array $data): object
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
     *
     * @param  string $owner   Contact owner e-mail address
     * @param  string $eventId Ext event identifier
     */
    public function delete($owner, $eventId): object
    {
        return $this->client->doPost('contact/deleteContactExtEvent', [
            'owner' => $owner,
            'eventId' => $eventId,
        ]);
    }
}
