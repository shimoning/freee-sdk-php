<?php

namespace Tests\Webhook\Domains\Hr\Entities\Objects;

use PHPUnit\Framework\TestCase;
use Shimoning\FreeeSdk\Webhook\Domains\Hr\Entities\Objects\EmployeeObject;

class EmployeeObjectTest extends TestCase
{
    public function testConstructorValidPayload(): void
    {
        // Arrange
        $payload = [
            'id'         => 1,
            'company_id' => 2,
            'year'       => 2023,
            'month'      => 10,
        ];

        // Act
        $employeeObject = new EmployeeObject($payload);

        // Assert
        $this->assertSame(1, $employeeObject->id);
        $this->assertSame(2, $employeeObject->companyId);
        $this->assertSame(2023, $employeeObject->year);
        $this->assertSame(10, $employeeObject->month);
    }

    public function testToArray(): void
    {
        // Arrange
        $payload = [
            'id'         => 1,
            'company_id' => 2,
            'year'       => 2023,
            'month'      => 10,
        ];
        $employeeObject = new EmployeeObject($payload);

        // Act
        $result = $employeeObject->toArray();

        // Assert
        $this->assertSame([
            'id'         => 1,
            'company_id' => 2,
            'year'       => 2023,
            'month'      => 10,
        ], $result);
    }
}
