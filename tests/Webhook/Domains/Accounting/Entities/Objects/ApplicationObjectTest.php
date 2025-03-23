<?php

namespace Tests\Webhook\Domains\Accounting\Entities\Objects;

use PHPUnit\Framework\TestCase;
use Shimoning\FreeeSdk\Webhook\Domains\Accounting\Entities\Objects\ApplicationObject;
use Shimoning\FreeeSdk\Webhook\Domains\Accounting\Constants\ApplicationStatus;
use Shimoning\FreeeSdk\Webhook\Domains\Accounting\Constants\ApplicationAction;
use Shimoning\FreeeSdk\Exceptions\InvalidArgumentException;

class ApplicationObjectTest extends TestCase
{
    public function testConstructorValidPayload(): void
    {
        // Arrange
        $payload = [
            'id'              => 1,
            'company_id'      => 2,
            'status'          => 'draft',
            'approval_action' => 'apply',
            'applicant_id'    => 3,
            'actor_id'        => 4,
        ];

        // Act
        $applicationObject = new ApplicationObject($payload);

        // Assert
        $this->assertSame(1, $applicationObject->id);
        $this->assertSame(2, $applicationObject->companyId);
        $this->assertSame(ApplicationStatus::DRAFT, $applicationObject->status);
        $this->assertSame(ApplicationAction::APPLY, $applicationObject->approvalAction);
        $this->assertSame(3, $applicationObject->applicantId);
        $this->assertSame(4, $applicationObject->actorId);
    }

    public function testConstructorInvalidStatus(): void
    {
        // Arrange
        $payload = [
            'id'              => 1,
            'company_id'      => 2,
            'status'          => 'invalid_status',
            'approval_action' => 'apply',
            'applicant_id'    => 3,
            'actor_id'        => 4,
        ];

        // Assert
        $this->expectException(InvalidArgumentException::class);

        // Act
        new ApplicationObject($payload);
    }

    public function testConstructorInvalidApprovalAction(): void
    {
        // Arrange
        $payload = [
            'id'              => 1,
            'company_id'      => 2,
            'status'          => 'draft',
            'approval_action' => 'invalid_action',
            'applicant_id'    => 3,
            'actor_id'        => 4,
        ];

        // Assert
        $this->expectException(InvalidArgumentException::class);

        // Act
        new ApplicationObject($payload);
    }

    public function testToArray(): void
    {
        // Arrange
        $payload = [
            'id'              => 1,
            'company_id'      => 2,
            'status'          => 'draft',
            'approval_action' => 'apply',
            'applicant_id'    => 3,
            'actor_id'        => 4,
        ];
        $applicationObject = new ApplicationObject($payload);

        // Act
        $result = $applicationObject->toArray();

        // Assert
        $this->assertSame([
            'id'              => 1,
            'company_id'      => 2,
            'status'          => 'draft',
            'approval_action' => 'apply',
            'applicant_id'    => 3,
            'actor_id'        => 4,
        ], $result);
    }
}
