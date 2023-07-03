<?php

namespace App\Models\Import;

use App\Models\Member;
use Carbon\Carbon;

class ImportedMember implements \Iterator, \JsonSerializable
{
    public const MEMBER_IMPORT_PERMISSION = 'memberImport';

    public const ATTRIBUTE_LABEL_ARRAY = [
        "title_pre" => "Prefixed Title",
        "firstname" => "Firstname",
        "lastname" => "Lastname",
        "title_post" => "Postfixed Title",
        "external_id" => "External Id",
        "birthday" => "Birthday",
        "phone" => "Phone number",
        "email" => "Email",
        "entrance_date" => "Entrance date",
        "leaving_date" => "Leaving date",
        "street" => "Street",
        "zip" => "ZIP",
        "city" => "City",
    ];

    public const ADDITIONAL_ALLOWED_ATTRIBUTES = [
        "id",
        "creator_id",
        "last_updater_id",
        "deleted_at",
        "created_at",
        "updated_at",
        "last_import_date"
    ];

    private array $attributes;
    private int $position = 0;

    public function __construct(array $attributes = [])
    {
        $invalidNames = array_diff(array_keys($attributes), self::possibleAttributeNames());
        if (count($invalidNames) > 0)
            throw new \InvalidArgumentException("Invalid attribute name(s): " . json_encode($invalidNames));
        $this->attributes = $attributes;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function hasAttribute(string $attributeName): bool
    {
        return in_array($attributeName, array_keys($this->attributes));
    }

    public function getAttribute(string $attributeName): string|Carbon|null
    {
        if (!$this->hasAttribute($attributeName)) return null;

        $value = $this->attributes[$attributeName];

        return match ($attributeName) {
            "birthday", "entrance_date", "leaving_date", "last_import_date" => Carbon::parse($value),
            default => $value
        };
    }

    public function setAttribute(string $name, string|Carbon|bool $value): void
    {
        if (!in_array($name, self::possibleAttributeNames()))
            throw new \InvalidArgumentException("Invalid attribute name: $name");

        switch($name) {
            case "birthday":
                if(is_string($value) && strlen(trim($value)) > 0)
                    $this->attributes[$name] = $value;
                break;
            default:
                $this->attributes[$name] = $value;
        }
    }

    /**
     * @param Member $member
     * @return string[]
     */
    public function getDifferences(Member $member): array
    {
        $keysWithDifference = [];
        foreach (self::possibleAttributeNames() as $key) {
            if ($this->hasAttribute($key)) {
                $attr = $this->getAttribute($key);
                if ($attr instanceof Carbon && $attr->equalTo($member->getAttributeValue($key))) {
                    continue;
                }
                if ($member->getAttributeValue($key) !== $this->getAttribute($key)) {
                    $keysWithDifference[] = $key;
                }
            }
        }
        return $keysWithDifference;
    }

    public function toMember(): Member
    {
        return new Member($this->attributes);
    }

    public function current(): string|Carbon
    {
        $key = $this->key();
        return $this->getAttribute($key);
    }

    public function next(): void
    {
        $this->position++;
    }

    public function key(): string
    {
        return array_keys($this->attributes)[$this->position];
    }

    public function valid(): bool
    {
        return $this->position < count($this->attributes);
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    /**
     * @return string[]
     */
    public static function possibleAttributeNames(): array
    {
        return array_merge(
            array_keys(self::ATTRIBUTE_LABEL_ARRAY),
            self::ADDITIONAL_ALLOWED_ATTRIBUTES);
    }

    public function jsonSerialize(): mixed
    {
        return $this->attributes;
    }
}
