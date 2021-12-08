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
     * @param  string $owner Contact owner e-mail address
     * @param  array $data  Rule data
     */
    public function create($owner, array $data): object
    {
        $data = self::mergeData($data, [
            'owner' => $owner,
        ]);

        return $this->client->doPost('rule/insert', $data);
    }
}
