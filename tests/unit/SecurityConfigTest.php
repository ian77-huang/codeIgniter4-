<?php

use CodeIgniter\Test\CIUnitTestCase;
use Config\App;
use Config\Filters;

/**
 * @internal
 */
final class SecurityConfigTest extends CIUnitTestCase
{
    public function testCsrfAndSecureHeadersAreEnabled(): void
    {
        $filters = new Filters();

        $this->assertContains('csrf', $filters->globals['before']);
        $this->assertContains('secureheaders', $filters->globals['after']);
    }

    public function testHttpsIsNotForcedDuringTests(): void
    {
        $config = new App();

        $this->assertFalse($config->forceGlobalSecureRequests);
    }
}
