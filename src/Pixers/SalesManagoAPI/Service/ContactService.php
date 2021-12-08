<?php

namespace Pixers\SalesManagoAPI\Service;

/**
 * @author Sylwester Łuczak <sylwester.luczak@pixers.pl>
 */
class ContactService extends AbstractService
{
    /**
     * Adding a new contact.
     *
     * @param  array<string, mixed>  $data  Contact data
     */
    public function create(string $owner, array $data): object
    {
        $data['owner'] = $owner;

        return $this->client->doPost('contact/insert', $data);
    }

    /**
     * Update contact data.
     *
     * @param  array<string, mixed>  $data  Contact data
     */
    public function update(string $owner, string $email, array $data): object
    {
        $data = self::mergeData($data, [
            'owner' => $owner,
            'email' => $email,
        ]);

        return $this->client->doPost('contact/update', $data);
    }

    /**
     * Deleting contact.
     *
     * @param  array<string, mixed>  $data  Contact data
     */
    public function upsert(string $owner, string $email, array $data): object
    {
        $data = self::mergeData($data, [
            'owner' => $owner,
            'contact' =>  [
                'email' =>  $email
            ]
        ]);
        return $this->client->doPost('contact/upsert', $data);
    }

    /**
     * Deleting contact.
     *
     * @param  array<string, mixed>  $data  Client data
     */
    public function delete(string $owner, string $email, array $data): object
    {
        $data = self::mergeData($data, [
            'owner' => $owner,
            'email' => $email,
        ]);

        return $this->client->doPost('contact/delete', $data);
    }

    /**
     * Checking whether the contact is already registered.
     */
    public function has(string $owner, string $email): object
    {
        return $this->client->doPost('contact/hasContact', [
            'email' => $email,
            'owner' => $owner,
        ]);
    }

    /**
     * Registering contact use discount code.
     */
    public function useCoupon(string $email, string $coupon): object
    {
        return $this->client->doPost('contact/useContactCoupon', [
            'email' => $email,
            'coupon' => $coupon,
        ]);
    }

    /**
     * Import contacts list by the e-mail addresses.
     *
     * @param  array<string, mixed>  $data  Request data
     */
    public function listByEmails(string $owner, array $data): object
    {
        $data['owner'] = $owner;

        return $this->client->doPost('contact/list', $data);
    }

    /**
     * Import contacts list by the SalesManago IDS.
     *
     * @param  array<string, mixed>  $data  Request data
     */
    public function listByIds(string $owner, array $data): object
    {
        $data['owner'] = $owner;

        return $this->client->doPost('contact/listById', $data);
    }

    /**
     * Import list of last modyfied contacts.
     *
     * @param  array<string, mixed>  $data  Request data
     */
    public function listRecentlyModified(string $owner, array $data): object
    {
        $data['owner'] = $owner;

        return $this->client->doPost('contact/modifiedContacts', $data);
    }

    /**
     * Import data about recently active contacts.
     *
     * @param  array<string, mixed> $data Request data
     */
    public function listRecentActivity(array $data): object
    {
        return $this->client->doPost('contact/recentActivity', $data);
    }
}
