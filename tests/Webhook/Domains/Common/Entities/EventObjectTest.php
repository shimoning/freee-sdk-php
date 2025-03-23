<?php

namespace Tests\Webhook\Domains\Common\Entities;

use PHPUnit\Framework\TestCase;
use Shimoning\FreeeSdk\Webhook\Domains\Common\Entities\EventObject;
use Shimoning\FreeeSdk\Webhook\Domains\Accounting\Entities\Objects\{
    ApprovalRequest,
    ExpenseApplication,
    PaymentRequest
};
use Shimoning\FreeeSdk\Webhook\Domains\Hr\Entities\Objects\EmployeeObject;
use Shimoning\FreeeSdk\Exceptions\InvalidEventException;

class EventObjectTest extends TestCase
{
    public function testFromArrayWithApprovalRequest(): void
    {
        // Arrange
        $object = [
            'id'           => 1,
            'company_id'   => 2,
            'status'       => 'draft',
            'applicant_id' => 3,
        ];

        // Act
        $result = EventObject::fromArray('approval_request', $object);

        // Assert
        $this->assertInstanceOf(ApprovalRequest::class, $result);
        $this->assertSame(1, $result->id);
    }

    public function testFromArrayWithExpenseApplication(): void
    {
        // Arrange
        $object = [
            'id'           => 1,
            'company_id'   => 2,
            'status'       => 'draft',
            'applicant_id' => 3,
        ];

        // Act
        $result = EventObject::fromArray('expense_application', $object);

        // Assert
        $this->assertInstanceOf(ExpenseApplication::class, $result);
        $this->assertSame(1, $result->id);
    }

    public function testFromArrayWithPaymentRequest(): void
    {
        // Arrange
        $object = [
            'id'           => 1,
            'company_id'   => 2,
            'status'       => 'draft',
            'applicant_id' => 3,
        ];

        // Act
        $result = EventObject::fromArray('payment_request', $object);

        // Assert
        $this->assertInstanceOf(PaymentRequest::class, $result);
        $this->assertSame(1, $result->id);
    }

    public function testFromArrayWithEmployee(): void
    {
        // Arrange
        $object = [
            'id'         => 1,
            'company_id' => 2,
            'year'       => 2023,
            'month'      => 10,
        ];

        // Act
        $result = EventObject::fromArray('employee', $object);

        // Assert
        $this->assertInstanceOf(EmployeeObject::class, $result);
        $this->assertSame(1, $result->id);
    }

    public function testFromArrayWithInvalidName(): void
    {
        // Arrange
        $object = [
            'id'         => 1,
            'company_id' => 2,
        ];

        // Assert
        $this->expectException(InvalidEventException::class);

        // Act
        EventObject::fromArray('invalid_name', $object);
    }

    public function testToJson(): void
    {
        // Arrange
        $object = [
            'id'         => 1,
            'company_id' => 2,
            'year'       => 2023,
            'month'      => 10,
        ];
        $employeeObject = EventObject::fromArray('employee', $object);

        // Act
        $result = $employeeObject->toJson();

        // Assert
        $expectedJson = json_encode([
            'id'         => 1,
            'company_id' => 2,
            'year'       => 2023,
            'month'      => 10,
        ]);
        $this->assertJson($result);
        $this->assertSame($expectedJson, $result);
    }
}
