<?php

use BunnyPHP\Model;

class EmployeeModel extends Model
{
    public function isEmployee($userId)
    {
        return $this->where('employee_id = :u', ['u' => $userId])->fetch('1');
    }

    public function isAdmin($userId)
    {
        return $this->where('employee_id = :u AND employee_type = 1', ['u' => $userId])->fetch('1');
    }
}