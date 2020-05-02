<?php

use BunnyPHP\Filter;

class LoginFilter extends Filter
{
    public function doFilter($param = [])
    {
        session_start();
        if (isset($_SESSION['userId'])) {
            return self::NEXT;
        } else {
            $this->error(['message' => 'info.auth.failed', 'code' => 403]);
            return self::STOP;
        }
    }
}