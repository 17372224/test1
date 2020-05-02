<?php

use BunnyPHP\Filter;

class AdminFilter extends Filter
{
    public function doFilter($param = [])
    {
        session_start();
        if (isset($_SESSION['authority']) && $_SESSION['authority'] == 'admin') {
            return self::NEXT;
        } else {
            $this->error(['message' => 'info.auth.failed', 'code' => 403]);
            return self::STOP;
        }
    }
}