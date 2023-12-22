<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $endpoint
 * @property string|null $public_key
 * @property string|null $auth_token
 * @property string|null $content_encoding
 *
 * @see /database/migrations/2023_07_31_183210_create_push_subscriptions_table.php
 */
class WebPushSubscription extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'logged_in',
        'endpoint',
        'public_key',
        'auth_token',
        'content_encoding',
    ];

    protected $casts = [
        'logged_in' => 'boolean',
        'upcoming_event' => 'boolean',
        'push_event' => 'boolean',
        'push_news' => 'boolean',
        'push_attendance_poll' => 'boolean',
    ];

    /**
     * Create a new model instance.
     *
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        if (! isset($this->connection)) {
            $this->setConnection(config('webpush.database_connection'));
        }

        if (! isset($this->table)) {
            $this->setTable(config('webpush.table_name'));
        }

        parent::__construct($attributes);
    }

    /**
     * Find a subscription by the given endpint.
     *
     * @param  string  $endpoint
     * @return static|null
     */
    public static function findByEndpoint($endpoint)
    {
        return static::where('endpoint', $endpoint)->first();
    }
}
