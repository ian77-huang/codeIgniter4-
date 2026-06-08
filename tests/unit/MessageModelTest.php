<?php

use App\Models\MessageModel;
use App\Services\AuthService;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;

/**
 * @internal
 */
final class MessageModelTest extends CIUnitTestCase
{
    use DatabaseTestTrait;

    protected $namespace = 'App';

    public function testCreateMessageWithSecurityFields(): void
    {
        $authService = new AuthService();
        $userId = $authService->register('message-user', 'secret123');

        $messageModel = new MessageModel();
        $insertId = $messageModel->insert([
            'user_id' => $userId,
            'content' => '第一則留言',
            'ip_address' => '127.0.0.1',
            'user_agent' => 'PHPUnit',
        ]);

        $message = $messageModel->find($insertId);

        $this->assertSame($userId, (int) $message['user_id']);
        $this->assertSame('第一則留言', $message['content']);
        $this->assertSame('127.0.0.1', $message['ip_address']);
        $this->assertSame('PHPUnit', $message['user_agent']);
        $this->assertSame(0, (int) $message['is_deleted']);
    }
}
