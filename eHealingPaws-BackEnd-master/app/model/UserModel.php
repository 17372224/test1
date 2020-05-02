<?php

use BunnyPHP\Model;

class UserModel extends Model
{
    public function register($firstName, $lastName, $password, $phone)
    {
        $salt = md5(uniqid(microtime(true), true));
        $hash = md5(md5($password . $salt) . $salt);

        if ($this->checkPhoneExist($phone)) {
            return $this->add([
                'user_firstName' => $firstName,
                'user_lastName' => $lastName,
                'user_password' => $hash,
                'user_salt' => $salt,
                'user_phone' => $phone]);
        } else {
            return false;
        }
    }

    private function checkPhoneExist($phone)
    {
        return !$this->where('user_phone = ?', [$phone])->fetch(['1']);
    }

    public function login($phone, $password)
    {
        if ($row = $this->where('user_phone = ?', [$phone])->fetch(['*'])) {
            $hash = md5(md5($password . $row['user_salt']) . $row['user_salt']);
            if ($hash == $row['user_password'])
                return [
                    'firstName' => $row['user_firstName'],
                    'lastName' => $row['user_lastName'],
                    'userId' => $row['user_id'],
                    'authority' => $this->getAuthority($row['user_id'])
                ];
            else
                return null;
        } else {
            return null;
        }
    }

    public function getAuthority($userId)
    {
        if ((new EmployeeModel())->isEmployee($userId))
            if ((new EmployeeModel())->isAdmin($userId))
                return "admin";
            else
                return "staff";
        else
            return "user";
    }

    public function getUser($userId)
    {
        return $this->where('user_id = ?', [$userId])->fetch([
            'user_firstName',
            'user_lastName',
            'user_phone',
            'user_email',
            'user_status']);
    }

    public function getAllUsers($page, $limit)
    {
        return $this->fetchAll([
            'user_firstName',
            'user_lastName',
            'user_phone',
            'user_email',
            'user_status']);
    }

    public function updatePhone($userId, $phone)
    {
        return $this->where('user_id =:u', ['u'=>$userId])->update(['user_phone' => $phone]);
    }

    public function updateEmail($userId, $email)
    {
        return $this->where('user_id =:u', ['u'=>$userId])->update(['user_email' => $email]);
    }
}