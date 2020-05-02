<?php

use BunnyPHP\Model;

class EmployeeTypeModel extends Model
{
    /**
     * @param $typeId integer Employee type id
     */
    public function getTypeName($typeId)
    {
        return $this->where('employee_type_id = :t', ['t' => $typeId])->fetch('employee_type_name')['employee_type_name'];
    }
}