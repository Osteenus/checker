<?php

namespace App\components;

include_once(ROOT . 'config/core.php');

use App\components\Db;
use App\Models\User;
use \Firebase\JWT\JWT;
use \Firebase\JWT\BeforeValidException;
use \Firebase\JWT\ExpiredException;
use \Firebase\JWT\SignatureInvalidException;

class Auth
{
    public static function login():int
    {

    }
}

