<?php

namespace App\Services;

use App\Models\UserModel;

class AuthService
{
    public function login(string $account, string $password): ?array
    {
        $user = $this->getUser($account);

        if (! $user) {
            return null;
        }

        if (! password_verify($password, $user['password'])) {
            return null;
        }

        session()->set([
            'user_id'      => $user['id'],
            'account'      => $user['account'],
            'is_logged_in' => true,
        ]);

        return $user;
    }

    public function register(string $account, string $password): ?int
    {
        $user = $this->getUser($account);

        if ($user) {
            // 帳號或密碼錯誤
            throw new \Exception(lang('Validation.users.errorCredentials3'), 401);
        }

        $data = [
            'account' => $account,
            'password' => password_hash($password, PASSWORD_DEFAULT),
        ];

        $userModel = new UserModel();

        return $userModel->insert($data);
    }

    public function getUser(string $account)
    {
        $userModel = new UserModel();

        $user = $userModel
            ->where('account', $account)
            ->first();

        return $user;
    }

    public function logout(): void
    {
        session()->destroy();
    }

    public function isLoggedIn(): bool
    {
        return session()->get('is_logged_in') === true;
    }

    public function userId(): ?int
    {
        return session()->get('user_id');
    }
}
