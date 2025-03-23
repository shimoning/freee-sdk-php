<?php

namespace Shimoning\FreeeSdk\Webhook\Domains\Common\Entities;

use Shimoning\FreeeSdk\Webhook\Domains\Accounting\Entities\AccountingEvent;
use Shimoning\FreeeSdk\Webhook\Domains\Common\Constants\Action;
use Shimoning\FreeeSdk\Exceptions\{InvalidEventException, InvalidArgumentException};
use Shimoning\FreeeSdk\Webhook\Domains\Hr\Entities\HrEvent;

abstract class Event
{
    public readonly string $id;
    public readonly int $applicationId;
    public readonly string $resource;
    public readonly Action $action;
    public readonly string $createdAt;
    public readonly EventObject $eventObject;

    /**
     * @param string $objectName
     * @param array<string, string|int|array<string, string|int>> $payload
     * @return void
     */
    public function __construct(
        public readonly string $objectName,
        public readonly array $payload,
    ) {
        $action = Action::tryFrom($payload['action']);
        if ($action === null) {
            throw new InvalidArgumentException('Invalid action: ' . $payload['action']);
        }

        $this->id            = $payload['id'];
        $this->applicationId = (int)$payload['application_id'];
        $this->resource      = $payload['resource'];
        $this->action        = $action;
        $this->createdAt     = $payload['created_at'];
        /** @var array<string, string|int> $object */
        $object            = $payload[$objectName];
        $this->eventObject = EventObject::fromArray($objectName, $object);
    }

    /**
     * 配列 から Event を生成する
     * @param array<string, string|int|array<string, string|int>> $payload $payload
     * @return self
     */
    public static function fromArray(array $payload): self
    {
        if (empty($payload['resource']) || ! \str_contains($payload['resource'], ':')) {
            throw new InvalidEventException('Resource is empty');
        }
        // リソースをドメインとオブジェクト名に分割する
        [$domain, $object] = explode(':', $payload['resource'], 2);

        if ($domain === 'accounting') {
            return new AccountingEvent(
                $object,
                $payload,
            );
        }

        if ($domain === 'hr') {
            return new HrEvent(
                $object,
                $payload,
            );
        }

        throw new InvalidEventException('Invalid resource domain: ' . $domain);
    }

    /**
     * json から Event を生成する
     * @param string $json
     * @return self
     */
    public static function fromJson(string $json): self
    {
        return static::fromArray(json_decode($json, true));
    }

    /**
     * イベントの配列を返却する
     *
     * @return array<string, string|int|array<string, string|int>> $payload
     */
    public function toArray(): array
    {
        return [
            'id'              => $this->id,
            'application_id'  => $this->applicationId,
            'resource'        => $this->resource,
            'action'          => $this->action->value,
            'created_at'      => $this->createdAt,
            $this->objectName => $this->eventObject->toArray(),
        ];
    }

    /**
     * イベントのJSONを返却する
     *
     * @return string
     */
    public function toJson(): string
    {
        return json_encode($this->toArray()) ?: '';
    }
}
