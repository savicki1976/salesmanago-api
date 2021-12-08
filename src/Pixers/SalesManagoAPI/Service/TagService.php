<?php

namespace Pixers\SalesManagoAPI\Service;

/**
 * @author Sylwester Łuczak <sylwester.luczak@pixers.pl>
 */
class TagService extends AbstractService
{
    /**
     * Retriving all tags.
     *
     * @param  array<string, mixed>  $data  Request data
     */
    public function getAll(string $owner, array $data): object
    {
        $data['owner'] = $owner;

        return $this->client->doPost('contact/tags', $data);
    }

    /**
     * Manage contact tags.
     *
     * @param  array<string, mixed>  $data  Tags data
     */
    public function modify(string $owner, string $email, array $data): object
    {
        $data = self::mergeData($data, [
            'email' => $email,
            'owner' => $owner,
        ]);

        return $this->client->doPost('contact/managetags', $data);
    }
}
