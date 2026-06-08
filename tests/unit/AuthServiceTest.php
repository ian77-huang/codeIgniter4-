<?php

use App\Models\UserModel;
use App\Services\AuthService;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;

/**
 * @internal
 */
final class AuthServiceTest extends CIUnitTestCase
{
    use DatabaseTestTrait;

    protected $namespace = 'App';

    public function testRegisterCreatesUserWithHashedPassword(): void
    {
        $service = new AuthService();

        $insertId = $service->register('new-user', 'secret123');

        $this->assertIsInt($insertId);

        $user = (new UserModel())->find($insertId);

        $this->assertSame('new-user', $user['account']);
        $this->assertNotSame('secret123', $user['password']);
        $this->assertTrue(password_verify('secret123', $user['password']));
    }

    public function testLoginSetsSessionAndReturnsUser(): void
    {
        $service = new AuthService();
        $insertId = $service->register('login-user', 'secret123');

        $user = $service->login('login-user', 'secret123');

        $this->assertIsArray($user);
        $this->assertSame($insertId, (int) $user['id']);
        $this->assertSame($insertId, (int) session()->get('user_id'));
        $this->assertSame('login-user', session()->get('account'));
        $this->assertTrue(session()->get('is_logged_in'));
    }

    public function testLoginReturnsNullForInvalidPassword(): void
    {
        $service = new AuthService();
        $service->register('wrong-password-user', 'secret123');

        $this->assertNull($service->login('wrong-password-user', 'bad-password'));
        $this->assertFalse($service->isLoggedIn());
    }

    public function testRegisterRejectsDuplicateAccount(): void
    {
        $service = new AuthService();
        $service->register('duplicate-user', 'secret123');

        $this->expectException(Exception::class);
        $this->expectExceptionCode(401);

        $service->register('duplicate-user', 'secret456');
    }
}
