<?php

namespace Tests\Unit;

use App\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UserModelTest extends TestCase
{
    #[Test]
    public function is_admin_returns_true_only_for_admin_role(): void
    {
        $admin = new User(['rol' => 'admin']);
        $operador = new User(['rol' => 'operador']);

        $this->assertTrue($admin->isAdmin());
        $this->assertFalse($operador->isAdmin());
    }
}
