<?php

use App\Services\AuthService;

if (!function_exists('auth_service')) {
    function auth_service(): AuthService
    {
        return new AuthService();
    }
}
