<?php

namespace App\NotificationMessage;

class Item implements \JsonSerializable, \Serializable
{
    public string $timestamp;

    public ItemType $type;

    public ?string $title;

    public string $message;

    public int $displayedSeconds;

    public function __construct(string $message, ItemType $type = ItemType::INFORMATION, $title = null, int $displayedSeconds = 8)
    {
        $this->timestamp = hrtime(true);
        $this->message = $message;
        $this->type = $type;
        $this->title = $title;
        $this->displayedSeconds = $displayedSeconds;
    }

    public function serialize(): array|string|null
    {
        return $this->__serialize();
    }

    public function unserialize(string $data): void
    {
        $this->__unserialize($data);
    }

    public function __serialize(): array
    {
        return [
            'timestamp' => $this->timestamp,
            'type' => $this->type->name,
            'title' => $this->title,
            'message' => $this->message,
            'displayedSeconds' => $this->displayedSeconds,
        ];
    }

    public function __unserialize(array $data): void
    {
        $this->timestamp = $data['timestamp'];
        $this->type = ItemType::getTypeForName($data['type']) ?: ItemType::INFORMATION;
        $this->title = $data['title'] ?? null;
        $this->message = $data['message'];
        $this->displayedSeconds = $data['displayedSeconds'];
    }

    public function jsonSerialize(): mixed
    {
        return $this->serialize();
    }
}
