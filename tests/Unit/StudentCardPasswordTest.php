<?php

namespace Tests\Unit;

use App\Support\StudentCardPassword;
use PHPUnit\Framework\TestCase;

class StudentCardPasswordTest extends TestCase
{
    public function test_it_generates_a_complex_ten_character_password(): void
    {
        $password = StudentCardPassword::generate();

        $this->assertSame(10, strlen($password));
        $this->assertMatchesRegularExpression('/[A-Z]/', $password);
        $this->assertMatchesRegularExpression('/[a-z]/', $password);
        $this->assertMatchesRegularExpression('/[0-9]/', $password);
        $this->assertMatchesRegularExpression('/[@#$%&*?]/', $password);
    }

    public function test_it_does_not_reuse_the_same_password(): void
    {
        $passwords = [];
        for ($i = 0; $i < 20; $i++) {
            $passwords[] = StudentCardPassword::generate();
        }

        $this->assertSame(count($passwords), count(array_unique($passwords)));
    }
}
