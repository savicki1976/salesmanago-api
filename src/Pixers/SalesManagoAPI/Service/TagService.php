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
     * @param  string $owner Contact owner e-mail address
     * @param  array  $data  Request data
     */
    public function getAll($owner, array $data): object
    {
        $data['owner'] = $owner;

        return $this->client->doPost('contact/tags', $data);
    }

    /**
     * Manage contact tags.
     *
     * @param  string $owner Contact owner e-mail address
     * @param  string $email Contact e-mail address
     * @param  array  $data  Tags data
     */
    public function modify($owner, $email, array $data): object
    {
        $data = self::mergeData($data, [
            'email' => $email,
            'owner' => $owner,
        ]);

        return $this->client->doPost('contact/managetags', $data);
    }
}
