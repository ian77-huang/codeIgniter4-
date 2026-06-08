<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Services\AuthService;

class Logout extends BaseController
{
    public function index()
    {
        $authService = new AuthService();
        if ($authService->isLoggedIn()) {
            $authService->logout();
            return redirect()->to("/user/login");
        }
    }
}
