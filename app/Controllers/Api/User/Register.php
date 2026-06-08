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

            $user = $authService->getUser($account);;

            if ($user) {
                // 帳號或密碼錯誤
                throw new \Exception(lang('Validation.users.errorCredentials3'), 401);
            }

            $insertId = $authService->register($account, $password);

            if ($insertId) {
                // 新增成功
                $session = session();
                $session->set([
                    'user_id'    => $insertId,
                    'account'    => $account,
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
                // 新增失敗
                // $errors = $userModel->errors();
                throw new \Exception(lang('Validation.server.error1'), 504);
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
