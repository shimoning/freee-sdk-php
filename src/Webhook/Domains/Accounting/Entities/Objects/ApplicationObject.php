<?php

namespace Shimoning\FreeeSdk\Webhook\Domains\Accounting\Entities\Objects;

use Shimoning\FreeeSdk\Webhook\Domains\Common\Entities\EventObject;
use Shimoning\FreeeSdk\Webhook\Domains\Accounting\Constants\{
    ApplicationStatus,
    ApplicationAction,
};
use Shimoning\FreeeSdk\Exceptions\InvalidArgumentException;

class ApplicationObject extends EventObject
{
    public readonly int $id;
    public readonly int $companyId;
    public readonly ApplicationStatus $status;
    public readonly ?ApplicationAction $approvalAction;
    public readonly int $applicantId;
    public readonly ?int $actorId;

    /**
     * @param array<string, string|int> $object
     * @return void
     * @throws InvalidArgumentException
     */
    public function __construct(array $object)
    {
        $status = ApplicationStatus::tryFrom($object['status']);
        if ($status === null) {
            throw new InvalidArgumentException('Invalid status: ' . $object['status']);
        }
        $approvalAction = ApplicationAction::tryFrom($object['approval_action'] ?? '');
        if (!empty($object['approval_action']) && $approvalAction === null) {
            throw new InvalidArgumentException('Invalid approval action: ' . $object['approval_action']);
        }

        $this->id             = (int)$object['id'];
        $this->companyId      = (int)$object['company_id'];
        $this->status         = $status;
        $this->approvalAction = $approvalAction;
        $this->applicantId    = (int)$object['applicant_id'];
        $this->actorId        = !empty($object['actor_id']) ? (int)$object['actor_id'] : null;
    }

    /**
     * 配列で返す
     *
     * @return array<string, string|int|null>
     */
    public function toArray(): array
    {
        return array_filter([
            'id'              => $this->id,
            'company_id'      => $this->companyId,
            'status'          => $this->status->value,
            'approval_action' => $this->approvalAction->value ?? null,
            'applicant_id'    => $this->applicantId,
            'actor_id'        => $this->actorId,
        ], fn ($value) => $value !== null);
    }
}
