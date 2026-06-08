<?php

namespace App\Controllers\Api\Message;

use App\Controllers\BaseController;
use App\Models\MessageModel;

class Create extends BaseController
{
    public function index()
    {
        try {
            if (session()->get('is_logged_in') !== true) {
                throw new \Exception(lang('Message.error.unauthorized'), 401);
            }

            $content = trim((string) $this->request->getPost('content'));

            if ($content === '') {
                throw new \Exception(lang('Message.error.emptyContent'), 422);
            }

            $messageModel = new MessageModel();
            $insertId = $messageModel->insert([
                'user_id' => session()->get('user_id'),
                'content' => $content,
                'ip_address' => $this->request->getIPAddress(),
                'user_agent' => substr($this->request->getUserAgent()->getAgentString(), 0, 255),
            ]);

            if ($insertId) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => lang('Message.success.create'),
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
