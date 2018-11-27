<?php

/*
 * This file is part of the "Send And Get" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Util;

final class PasswordUtil
{
    public static function generatePssword(int $length = 8): string
    {
        return \bin2hex(\random_bytes($length));
    }
}
