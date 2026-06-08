<?php

namespace App\Controllers\Api\User;

use App\Controllers\BaseController;
use App\Services\AuthService;

class Register extends BaseController
{
    public function index()
    {
        try {
            $account = $this->request->getPost('account');
            $password = $this->request->getPost('password');
            $confirmPassword = $this->request->getPost('confirmPassword');
            if (empty($account) || empty($password)) {
                throw new \Exception(lang('Validation.users.errorCredentials1'), 422);
            }
            if (empty($confirmPassword)) {
                throw new \Exception(lang('Validation.users.errorConfirmPassword1'), 422);
            }
            if ($confirmPassword !== $password) {
                throw new \Exception(lang('Validation.users.errorConfirmPassword2'), 422);
            }

            $authService = new AuthService();

            $user = $authService->getUser($account);

            if ($user) {
                throw new \Exception(lang('Validation.users.errorCredentials3'), 401);
            }

            $insertId = $authService->register($account, $password);

            if ($insertId) {
                $session = session();
                $session->set([
                    'user_id'    => $insertId,
                    'account'    => $account,
                    'is_logged_in' => true,
                ]);
                return $this->response->setJSON([
                    'success' => true,
                    'message' => lang('Auth.message.registerSuccess'),
                    'data' => [
                        'account' => $account,
                    ],
                    'csrf' => $this->csrf(),
                ]);
            } else {
                throw new \Exception(lang('Validation.server.error1'), 504);
            }
        } catch (\Throwable $e) {
            $statusCode = $this->normalizeStatusCode($e->getCode());

            return $this->response
                ->setStatusCode($statusCode)
                ->setJSON([
                    'success' => false,
                    'message' => $e->getMessage(),
                    'csrf' => $this->csrf(),
                ]);
        }
    }

    private function normalizeStatusCode(int $statusCode): int
    {
        return ($statusCode >= 100 && $statusCode <= 599) ? $statusCode : 500;
    }

    private function csrf(): array
    {
        return [
            'headerName' => csrf_header(),
            'tokenName' => csrf_token(),
            'hash' => csrf_hash(),
        ];
    }
}
