<?php

namespace Shimoning\FreeeSdk\Webhook\Domains\Common\Entities;

use Shimoning\FreeeSdk\Webhook\Domains\Accounting\Entities\Objects\{
    ApprovalRequest,
    ExpenseApplication,
    PaymentRequest,
};
use Shimoning\FreeeSdk\Webhook\Domains\Hr\Entities\Objects\EmployeeObject;
use Shimoning\FreeeSdk\Exceptions\InvalidEventException;

abstract class EventObject
{
    /**
     * 配列からオブジェクトを作成する
     *
     * @param string $name
     * @param array<string, string|int> $object
     * @return self
     */
    public static function fromArray(string $name, array $object): self
    {
        // Accounting
        if ($name === 'approval_request') {
            return new ApprovalRequest($object);
        }
        if ($name === 'expense_application') {
            return new ExpenseApplication($object);
        }
        if ($name === 'payment_request') {
            return new PaymentRequest($object);
        }

        // Hr
        if ($name === 'employee') {
            return new EmployeeObject($object);
        }

        throw new InvalidEventException('Invalid event object name: ' . $name);
    }

    /**
     * @return array<string, string|int|null>
     */
    abstract public function toArray(): array;

    /**
     * @return string
     */
    public function toJson(): string
    {
        return json_encode($this->toArray()) ?: '';
    }
}
