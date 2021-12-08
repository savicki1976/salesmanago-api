<?php

namespace Pixers\SalesManagoAPI\Service;

/**
 * @author Sylwester Łuczak <sylwester.luczak@pixers.pl>
 */
class RuleService extends AbstractService
{
    /**
     * Add automation rule.
     *
     * @param  array<string, mixed> $data  Rule data
     */
    public function create(string $owner, array $data): object
    {
        $data = self::mergeData($data, [
            'owner' => $owner,
        ]);

        return $this->client->doPost('rule/insert', $data);
    }
}
