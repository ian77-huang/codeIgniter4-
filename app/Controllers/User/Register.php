<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;

class Register extends BaseController
{
    public function index()
    {
        return view('user/register', [
            'csrf' => $this->csrf(),
        ]);
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
