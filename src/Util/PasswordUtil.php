<?php

namespace App\Util;

final class PasswordUtil {

	public static function generatePssword(int $length = 8):string
	{

		return \bin2hex(\random_bytes($length));

	}

}