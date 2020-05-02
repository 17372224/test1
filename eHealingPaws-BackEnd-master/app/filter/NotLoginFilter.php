<?php

use BunnyPHP\Filter;

class NotLoginFilter extends Filter
{
    public function doFilter($param = [])
    {
        session_start();
        if (isset($_SESSION['userId'])) {
            $this->error(['message' => 'info.auth.failed.already', 'code' => 403]);
            return self::STOP;
        } else {
            return self::NEXT;
        }
    }
}