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
     * @param  string $owner Contact owner e-mail address
     * @param  array  $data  Contact data
     */
    public function create($owner, array $data)
    {
        $data['owner'] = $owner;

        return $this->client->doPost('contact/insert', $data);
    }

    /**
     * Update contact data.
     *
     * @param  string $owner Contact owner e-mail address
     * @param  string $email Contact e-mail address
     * @param  array  $data  Contact data
     */
    public function update($owner, $email, array $data): object
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
     * @param  string $owner Contact owner e-mail address
     * @param  string $email Contact e-mail address
     * @param  array  $data  Contact data
     */
    public function upsert($owner, $email, array $data): object
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
     * @param  string $owner Contact owner e-mail address
     * @param  string $email Contact e-mail address
     * @param  array  $data  Client data
     */
    public function delete($owner, $email, array $data)
    {
        $data = self::mergeData($data, [
            'owner' => $owner,
            'email' => $email,
        ]);

        return $this->client->doPost('contact/delete', $data);
    }

    /**
     * Checking whether the contact is already registered.
     *
     * @param  string $owner Contact owner email address
     * @param  string $email Contact email address
     */
    public function has($owner, $email): object
    {
        return $this->client->doPost('contact/hasContact', [
            'email' => $email,
            'owner' => $owner,
        ]);
    }

    /**
     * Registering contact use discount code.
     *
     * @param  string $email  Contact email address
     * @param  string $coupon Coupon
     */
    public function useCoupon($email, $coupon): object
    {
        return $this->client->doPost('contact/useContactCoupon', [
            'email' => $email,
            'coupon' => $coupon,
        ]);
    }

    /**
     * Import contacts list by the e-mail addresses.
     *
     * @param  string $owner Contact owner e-mail address
     * @param  array  $data  Request data
     */
    public function listByEmails($owner, array $data): object
    {
        $data['owner'] = $owner;

        return $this->client->doPost('contact/list', $data);
    }

    /**
     * Import contacts list by the SalesManago IDS.
     *
     * @param  string $owner Contact owner e-mail address
     * @param  array  $data  Request data
     */
    public function listByIds($owner, array $data): object
    {
        $data['owner'] = $owner;

        return $this->client->doPost('contact/listById', $data);
    }

    /**
     * Import list of last modyfied contacts.
     *
     * @param  string $owner Contact owner e-mail address
     * @param  array  $data  Request data
     */
    public function listRecentlyModified($owner, array $data): object
    {
        $data['owner'] = $owner;

        return $this->client->doPost('contact/modifiedContacts', $data);
    }

    /**
     * Import data about recently active contacts.
     *
     * @param  array $data Request data
     */
    public function listRecentActivity(array $data): object
    {
        return $this->client->doPost('contact/recentActivity', $data);
    }
}
