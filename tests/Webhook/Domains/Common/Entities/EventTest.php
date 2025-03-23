<?php

namespace Tests\Webhook\Domains\Common\Entities;

use PHPUnit\Framework\TestCase;
use Shimoning\FreeeSdk\Webhook\Domains\Common\Entities\Event;
use Shimoning\FreeeSdk\Webhook\Domains\Common\Constants\Action;
use Shimoning\FreeeSdk\Exceptions\InvalidArgumentException;
use Shimoning\FreeeSdk\Exceptions\InvalidEventException;
use Shimoning\FreeeSdk\Webhook\Domains\Accounting\Entities\AccountingEvent;
use Shimoning\FreeeSdk\Webhook\Domains\Hr\Entities\HrEvent;

class EventTest extends TestCase
{
    public function testConstructorValidPayload(): void
    {
        // Arrange
        $payload = [
            'id'                  => '123',
            'application_id'      => 456,
            'resource'            => 'accounting:expense_application',
            'action'              => 'created',
            'created_at'          => '2023-10-01T00:00:00Z',
            'expense_application' => [
                'id'           => 1,
                'company_id'   => 2,
                'status'       => 'draft',
                'applicant_id' => 3,
            ],
        ];

        // Act
        $event = new AccountingEvent('expense_application', $payload);

        // Assert
        $this->assertSame('123', $event->id);
        $this->assertSame(456, $event->applicationId);
        $this->assertSame('accounting:expense_application', $event->resource);
        $this->assertSame(Action::CREATED, $event->action);
        $this->assertSame('2023-10-01T00:00:00Z', $event->createdAt);
        $this->assertSame(1, $event->eventObject->id);
    }

    public function testConstructorInvalidAction(): void
    {
        // Arrange
        $payload = [
            'id'                  => '123',
            'application_id'      => 456,
            'resource'            => 'accounting:expense_application',
            'action'              => 'invalid_action',
            'created_at'          => '2023-10-01T00:00:00Z',
            'expense_application' => [
                'id'           => 1,
                'company_id'   => 2,
                'status'       => 'draft',
                'applicant_id' => 3,
            ],
        ];

        // Assert
        $this->expectException(InvalidArgumentException::class);

        // Act
        new AccountingEvent('expense_application', $payload);
    }

    public function testFromArrayValidPayload(): void
    {
        // Arrange
        $payload = [
            'id'                  => '123',
            'application_id'      => 456,
            'resource'            => 'accounting:expense_application',
            'action'              => 'created',
            'created_at'          => '2023-10-01T00:00:00Z',
            'expense_application' => [
                'id'           => 1,
                'company_id'   => 2,
                'status'       => 'draft',
                'applicant_id' => 3,
            ],
        ];

        // Act
        $event = Event::fromArray($payload);

        // Assert
        $this->assertInstanceOf(AccountingEvent::class, $event);
        $this->assertSame('123', $event->id);

        // Arrange for HR event
        $payload = [
            'id'             => 'hr-123',
            'application_id' => 456,
            'resource'       => 'hr:employee',
            'action'         => 'created',
            'created_at'     => '2023-10-01T00:00:00Z',
            'employee'       => [
                'id'         => 1,
                'company_id' => 2,
                'year'       => 2023,
                'month'      => 10,
            ],
        ];

        // Act
        $event = Event::fromArray($payload);

        // Assert
        $this->assertInstanceOf(HrEvent::class, $event);
        $this->assertSame('hr-123', $event->id);
    }

    public function testFromArrayInvalidResource(): void
    {
        // Arrange
        $payload = [
            'id'             => '123',
            'application_id' => 456,
            'resource'       => 'invalid_resource',
            'action'         => 'created',
            'created_at'     => '2023-10-01T00:00:00Z',
        ];

        // Assert
        $this->expectException(InvalidEventException::class);

        // Act
        Event::fromArray($payload);
    }

    public function testFromArrayInvalidResourceDomain(): void
    {
        // Arrange
        $payload = [
            'id'             => '123',
            'application_id' => 456,
            'resource'       => 'domain:resource',
            'action'         => 'created',
            'created_at'     => '2023-10-01T00:00:00Z',
        ];

        // Assert
        $this->expectException(InvalidEventException::class);

        // Act
        Event::fromArray($payload);
    }

    public function testFromJsonValidPayload(): void
    {
        // Arrange
        $json = json_encode([
            'id'                  => '123',
            'application_id'      => 456,
            'resource'            => 'accounting:expense_application',
            'action'              => 'created',
            'created_at'          => '2023-10-01T00:00:00Z',
            'expense_application' => [
                'id'           => 1,
                'company_id'   => 2,
                'status'       => 'draft',
                'applicant_id' => 3,
            ],
        ]);

        // Act
        $event = Event::fromJson($json);

        // Assert
        $this->assertInstanceOf(AccountingEvent::class, $event);
        $this->assertSame('123', $event->id);
    }

    public function testFromJsonInvalidJson(): void
    {
        // Arrange
        $invalidJson = '{invalid_json}';

        // Assert
        $this->expectException(InvalidArgumentException::class);

        // Act
        Event::fromJson($invalidJson);
    }

    public function testFromJsonNotArray(): void
    {
        // Arrange
        $invalidJson = true;

        // Assert
        $this->expectException(InvalidArgumentException::class);

        // Act
        Event::fromJson($invalidJson);
    }

    public function testToArray(): void
    {
        // Arrange
        $payload = [
            'id'                  => '123',
            'application_id'      => 456,
            'resource'            => 'accounting:expense_application',
            'action'              => 'created',
            'created_at'          => '2023-10-01T00:00:00Z',
            'expense_application' => [
                'id'           => 1,
                'company_id'   => 2,
                'status'       => 'draft',
                'applicant_id' => 3,
            ],
        ];
        $event = new AccountingEvent('expense_application', $payload);

        // Act
        $result = $event->toArray();

        // Assert
        $this->assertSame([
            'id'                  => '123',
            'application_id'      => 456,
            'resource'            => 'accounting:expense_application',
            'action'              => 'created',
            'created_at'          => '2023-10-01T00:00:00Z',
            'expense_application' => [
                'id'           => 1,
                'company_id'   => 2,
                'status'       => 'draft',
                'applicant_id' => 3,
            ],
        ], $result);
    }

    public function testToJson(): void
    {
        // Arrange
        $payload = [
            'id'                  => '123',
            'application_id'      => 456,
            'resource'            => 'accounting:expense_application',
            'action'              => 'created',
            'created_at'          => '2023-10-01T00:00:00Z',
            'expense_application' => [
                'id'           => 1,
                'company_id'   => 2,
                'status'       => 'draft',
                'applicant_id' => 3,
            ],
        ];
        $event = new AccountingEvent('expense_application', $payload);

        // Act
        $result = $event->toJson();

        // Assert
        $this->assertJson($result);
        $this->assertSame(json_encode($payload), $result);
    }

    public function testFromArrayMissingResource(): void
    {
        // Arrange
        $payload = [
            'id'             => '123',
            'application_id' => 456,
            'action'         => 'created',
            'created_at'     => '2023-10-01T00:00:00Z',
        ];

        // Assert
        $this->expectException(InvalidEventException::class);

        // Act
        Event::fromArray($payload);
    }
}
