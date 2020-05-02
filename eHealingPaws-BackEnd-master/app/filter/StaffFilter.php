<?php

use BunnyPHP\Filter;

class StaffFilter extends Filter
{
    public function doFilter($param = [])
    {
        session_start();
        if (isset($_SESSION['authority']) && $_SESSION['authority'] == 'staff') {
            return self::NEXT;
        } else {
            $this->error(['message' => 'info.auth.failed', 'code' => 403]);
            return self::STOP;
        }
    }
}