<?php

namespace Shimoning\FreeeSdk\Webhook\Domains\Hr\Entities\Objects;

use Shimoning\FreeeSdk\Webhook\Domains\Common\Entities\EventObject;

class EmployeeObject extends EventObject
{
    public readonly int $id;
    public readonly int $companyId;
    public readonly int $year;
    public readonly int $month;

    /**
     * 従業員イベントオブジェクト
     *
     * @param array<string, string|int> $object
     */
    public function __construct(array $object)
    {
        $this->id        = (int)$object['id'];
        $this->companyId = (int)$object['company_id'];
        $this->year      = (int)$object['year'];
        $this->month     = (int)$object['month'];
    }

    /**
     * 配列で返す
     *
     * @return array<string, int>
     */
    public function toArray(): array
    {
        return [
            'id'         => $this->id,
            'company_id' => $this->companyId,
            'year'       => $this->year,
            'month'      => $this->month,
        ];
    }
}
