<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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

    public const DATATYPE_STRING = 'string';

    public const DATATYPE_INT = 'int';

    public const DATATYPE_BOOL = 'bool';

    private static function getKeyQuery(ConfigurationKey $key, ?User $user): Builder
    {
        $query = self::query()->where('key', $key);

        if ($user) {
            return $query->where(function ($query) use ($user) {
                $query->whereNull('user_id');
                $query->orWhere('user_id', $user->id);
            })
                ->orderByDesc('user_id');
        }

        return $query->whereNull('user_id');
    }

    private static function getSingleKeyQuery(ConfigurationKey $key, ?User $user): Builder
    {
        $query = self::query()
            ->where('key', $key);
        if ($user) {
            return $query->where('user_id', $user->id);
        }

        return $query->whereNull('user_id');
    }

    public static function storeString(ConfigurationKey $key, string $value, User $user = null): ?string
    {
        /** @var Configuration $config */
        $config = self::getSingleKeyQuery($key, $user)->firstOrNew();
        $oldValue = $config->value;
        $config->key = $key;
        $config->value = $value;
        $config->datatype = self::DATATYPE_STRING;
        $config->user()->associate($user);

        $config->save();

        return $oldValue;
    }

    public static function getString(ConfigurationKey $key, User $user = null, string $default = null): ?string
    {
        /** @var Configuration $configValue */
        $configValue = self::getKeyQuery($key, $user)->first('value');

        if ($configValue) {
            return $configValue->value;
        }

        return $default;
    }

    public static function storeInt(ConfigurationKey $key, int $value, User $user = null): ?int
    {
        /** @var Configuration $config */
        $config = self::getSingleKeyQuery($key, $user)->firstOrNew();
        $oldValue = $config->value;
        $config->key = $key;
        $config->value = (string) $value;
        $config->datatype = self::DATATYPE_INT;
        $config->user()->associate($user);

        $config->save();

        return $oldValue ? (int) $oldValue : null;
    }

    public static function getInt(ConfigurationKey $key, User $user = null, int $default = null): ?int
    {
        /** @var Configuration $configValue */
        $configValue = self::getKeyQuery($key, $user)->first('value');

        if ($configValue) {
            return (int) $configValue->value;
        }

        return $default;
    }

    public static function storeBool(ConfigurationKey $key, bool $value, User $user = null): ?bool
    {
        /** @var Configuration $config */
        $config = self::getSingleKeyQuery($key, $user)->firstOrNew();
        $oldValue = $config->value;
        $config->key = $key;
        $config->value = (string) $value;
        $config->datatype = self::DATATYPE_BOOL;

        $config->user()->associate($user);

        $config->save();

        return $oldValue ? (bool) $oldValue : null;
    }

    public static function getBool(ConfigurationKey $key, User $user = null, bool $default = null): ?bool
    {
        /** @var Configuration $configValue */
        $configValue = self::getKeyQuery($key, $user)->first('value');

        if ($configValue) {
            return (bool) $configValue->value;
        }

        return $default;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
