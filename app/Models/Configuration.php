<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 * @property int id
 * @property string key
 * @property int user_id
 * @property string datatype [string, int, bool]
 * @property string value
 */
class Configuration extends Model
{
    use HasFactory;

    public const DATATYPE_STRING = "string";
    public const DATATYPE_INT = "int";
    public const DATATYPE_BOOL = "bool";

    public static function storeString(string $key, string $value, ?User $user = null): void
    {
        $config = new Configuration();
        $config->key = $key;
        $config->user_id = -1;
        $config->datatype = self::DATATYPE_STRING;
        $config->value = $value;

        $config->save();
    }

    public static function getString (string $key, ?string $default): ?string
    {

    }

    public static function storeInt(string $key, int $value, ?User $user = null): void
    {

    }

    public static function getInt (string $key, ?int $default): ?int
    {

    }

    public static function storeBool(string $key, bool $value, ?User $user = null): void
    {

    }

    public static function getBool (string $key, ?bool $default): ?bool
    {

    }


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
