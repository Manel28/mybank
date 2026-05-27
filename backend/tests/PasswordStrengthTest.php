<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;

class PasswordStrengthTest extends TestCase
{
    private function isStrongPassword(string $password): bool
    {
        return preg_match(
            '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z\d]).{8,}$/',
            $password
        ) === 1;
    }

    public function testStrongPasswordIsValid(): void
    {
        $this->assertTrue($this->isStrongPassword('Test123!'));
    }

    public function testWeakPasswordIsInvalid(): void
    {
        $this->assertFalse($this->isStrongPassword('test'));
        $this->assertFalse($this->isStrongPassword('password123'));
        $this->assertFalse($this->isStrongPassword('PASSWORD123!'));
    }
}