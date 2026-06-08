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

            $user = $authService->getUser($account);

            if ($user && password_verify($password, $user['password'])) {
                $session = session();

                $session->set([
                    'user_id'    => $user['id'],
                    'account'    => $user['account'],
                    'is_logged_in' => true,
                ]);

                return $this->response->setJSON([
                    'success' => true,
                    'message' => '登入成功',
                    'data' => [
                        'account' => $account,
                    ],
                ]);
            } else {
                // 帳號或密碼錯誤
                throw new \Exception(lang('Validation.users.errorCredentials2'), 401);
            }
        } catch (\Throwable $e) {
            return $this->response
                ->setStatusCode($e->getCode())
                ->setJSON([
                    'success' => false,
                    'message' => $e->getMessage(),
                ]);
        }
    }
}
