<?php

namespace App\Controllers;

use App\Models\MessageModel;

class Home extends BaseController
{
    public function index(): string
    {
        $messageModel = new MessageModel();
        $messages = $messageModel
            ->select('messages.*, users.account')
            ->join('users', 'users.id = messages.user_id')
            ->where('messages.is_deleted', 0)
            ->orderBy('messages.created_at', 'DESC')
            ->findAll();

        return view('index', [
            'messages' => $messages,
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
