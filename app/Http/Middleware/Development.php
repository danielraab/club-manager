<?php

namespace App\Http\Middleware;

use App\Models\Configuration;
use App\Models\ConfigurationKey;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Development
{
    const DEVELOPMENT_MODE_UP_TIME_SEC = 60 * 10;

    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     *
     * @throws NotFoundHttpException
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (self::isAvailableInSec() > 0) {
            return $next($request);
        }
        throw new NotFoundHttpException();
    }

    public static function isAvailableInSec(): int
    {
        return Configuration::getInt(ConfigurationKey::DEVELOPMENT_PAGE_AVAILABLE, default: 0)
            + self::DEVELOPMENT_MODE_UP_TIME_SEC
            - now()->getTimestamp();
    }
}
