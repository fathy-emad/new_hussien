<?php

namespace App\Support;

class StudentCardPassword
{
    public const LENGTH = 10;

    private const UPPER = 'ABCDEFGHJKLMNPQRSTUVWXYZ';

    private const LOWER = 'abcdefghijkmnpqrstuvwxyz';

    private const DIGITS = '23456789';

    private const SYMBOLS = '@#$%&*?';

    public static function generate(int $length = self::LENGTH): string
    {
        $length = max(4, $length);

        $pools = [self::UPPER, self::LOWER, self::DIGITS, self::SYMBOLS];
        $chars = implode('', $pools);
        $password = [];

        foreach ($pools as $pool) {
            $password[] = $pool[random_int(0, strlen($pool) - 1)];
        }

        for ($i = count($password); $i < $length; $i++) {
            $password[] = $chars[random_int(0, strlen($chars) - 1)];
        }

        for ($i = count($password) - 1; $i > 0; $i--) {
            $j = random_int(0, $i);
            [$password[$i], $password[$j]] = [$password[$j], $password[$i]];
        }

        return implode('', $password);
    }
}
