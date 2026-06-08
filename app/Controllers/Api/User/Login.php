<?php

namespace App\Controllers\Api\User;

use App\Controllers\BaseController;
use App\Services\AuthService;

class Login extends BaseController
{
    public function index()
    {
        try {
            $account = $this->request->getPost('account');
            $password = $this->request->getPost('password');
            if (empty($account) || empty($password)) {
                throw new \Exception(lang('Validation.users.errorCredentials1'), 422);
            }

            $authService = new AuthService();

            if ($authService->login($account, $password)) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => lang('Auth.message.loginSuccess'),
                    'data' => [
                        'account' => $account,
                    ],
                ]);
            } else {
                throw new \Exception(lang('Validation.users.errorCredentials2'), 401);
            }
        } catch (\Throwable $e) {
            $statusCode = $this->normalizeStatusCode($e->getCode());

            return $this->response
                ->setStatusCode($statusCode)
                ->setJSON([
                    'success' => false,
                    'message' => $e->getMessage(),
                ]);
        }
    }

    private function normalizeStatusCode(int $statusCode): int
    {
        return ($statusCode >= 100 && $statusCode <= 599) ? $statusCode : 500;
    }
}
