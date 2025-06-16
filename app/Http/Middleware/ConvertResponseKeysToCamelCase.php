<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class ConvertResponseKeysToCamelCase
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if ($response instanceof JsonResponse) {
            $originalData = $response->getData(true);
            $camelCased = $this->camelizeArray($originalData);
            $response->setData($camelCased);
        }

        return $response;
    }

    private function camelizeArray($data)
    {
        if (is_array($data)) {
            return collect($data)->mapWithKeys(function ($value, $key) {
                $key = is_string($key) ? Str::camel($key) : $key;
                return [$key => $this->camelizeArray($value)];
            })->all();
        }

        return $data;
    }
}
