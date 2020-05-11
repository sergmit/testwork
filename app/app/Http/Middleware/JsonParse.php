<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class JsonParse
{
    protected const PARSED_METHODS = [
        Request::METHOD_POST, Request::METHOD_PUT
    ];

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $content = json_decode($request->getContent(), true);

        if (in_array($request->getMethod(), self::PARSED_METHODS, true)) {
            if (!empty($content)) {
                $request->merge($content);
            }

            $request->merge(['users' => explode(',', $request->users)]);
        }

        return $next($request);
    }
}
