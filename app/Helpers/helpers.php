<?php

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Route;

if (! function_exists('user')) {
    /**
     * Get currently logged in user
     *
     *
     * @return Authenticatable | User
     */
    function user(): Authenticatable
    {
        return auth()->user();
    }
}

if (!function_exists('current_route_is')) {
    /**
     * Check if current ulr matches a certain route pattern
     * @param $pattern
     * @return bool | string
     */
    function current_route_is($pattern): bool
    {
        return Route::is($pattern);
    }
}

if (!function_exists('get_validation_error')) {
    /**
     * Gets the validation error from error bag
     * @param $errorBag
     * @param $key
     * @return bool|string
     */
    function get_validation_error($errorBag, $key)
    {
        $errorBag = $errorBag->toArray();

        if (!empty($errorBag) && key_exists($key, $errorBag)) {
            return $errorBag[$key][0];
        }

        return null;
    }
}

if (!function_exists('get_model_instance')) {
    /**
     * Gets an empty instance of the model provided
     * @param string $model
     * @return object
     */
    function get_model_instance(string $model): ?object
    {
        $classPath = 'App\\Models\\' . $model;
        if (class_exists($classPath)) {
            return new $classPath();
        }

        return null;
    }
}
