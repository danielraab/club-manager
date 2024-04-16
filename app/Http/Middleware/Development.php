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
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     *
     * @throws NotFoundHttpException
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Configuration::getBool(ConfigurationKey::DEVELOPMENT_PAGE_AVAILABLE, default: false)) {
            return $next($request);
        }
        throw new NotFoundHttpException();
    }
}
