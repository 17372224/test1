<?php

use BunnyPHP\Controller;


class UserController extends Controller
{
    /**
     * @filter notLogin
     *
     * @param $firstName string first name
     * @param $lastName string last name
     * @param $password string password in plaintext
     * @param $phone string phone number
     */
    public function ac_register_post($firstName, $lastName, $password, $phone)
    {
        if (!empty($firstName) && !empty($lastName) && !empty($password) && !empty($phone)) {
            if ((new UserModel())->register($firstName, $lastName, $password, $phone)) {
                $this->assignAll(['message' => 'info.register.successful', 'code' => 200])->render();
            } else {
                $this->assignAll(['message' => 'info.register.exists', 'code' => 403])->render();
            }
        } else {
            $this->assignAll(['message' => 'info.request.bad', 'code' => 400])->render();
        }
    }

    /**
     * @filter login
     *
     * @param $phone
     * @param $email
     */
    public function ac_update_post($phone, $email)
    {
        if (!empty($phone)) {
            if (!(new UtilityModel())->isValidPhone($phone)) {
                $this->assignAll(['message' => 'info.phone.invalid', 'code' => 200])->render();
            } else
                if ((new UserModel())->updatePhone($_SESSION['userId'], $phone)) {
                    $this->assignAll(['message' => 'info.profile.update.successful', 'code' => 200])->render();
                } else {
                    $this->assignAll(['message' => 'info.request.unchanged', 'code' => 502])->render();
                }
        } else if (!empty($email)) {
            if (!(new UtilityModel())->isValidEmail($email)) {
                $this->assignAll(['message' => 'info.email.invalid', 'code' => 200])->render();
            } else if ((new UserModel())->updateEmail($_SESSION['userId'], $email)) {
                $this->assignAll(['message' => 'info.profile.update.successful', 'code' => 200])->render();
            } else {
                $this->assignAll(['message' => 'info.request.unchanged', 'code' => 502])->render();
            }
        } else {
            $this->assignAll(['message' => 'info.request.bad', 'code' => 400])->render();
        }
    }

    /**
     * @filter notLogin
     *
     * @param $phone string phone number
     * @param $password string password in plaintext
     * @param $zoneId integer the id of service location
     */
    public function ac_login_post($phone, $password, $zoneId)
    {
        if (!empty($phone) && !empty($password) && !empty($zoneId) && (new ZoneModel())->isZoneAvailable($zoneId)) {
            if ($phone[0] != '+')
                $phone = "+" . $phone;
            $data = (new UserModel())->login($phone, $password);
            if ($data == null) {
                $this->assignAll(['message' => 'info.login.failed', 'code' => 403])->render();
            } else {
                $data['zoneId'] = intval($zoneId);
                $data['zoneName'] = (new ZoneModel())->getZoneName($zoneId);

                $_SESSION['zoneId'] = $data['zoneId'];
                $_SESSION['zoneName'] = $data['zoneName'];
                $_SESSION['userId'] = $data['userId'];
                $_SESSION['authority'] = $data['authority'];

                $this->assignAll(['message' => 'info.login.successful', 'code' => 200, 'data' => $data])->render();
            }
        } else {
            $this->assignAll(['message' => 'info.request.bad', 'code' => 400])->render();
        }
    }

    /**
     * @filter login
     */
    public function ac_logout()
    {
        session_destroy();
        $this->assignAll(['message' => 'info.logout.successful', 'code' => 200])->render();
    }

    /**
     * @filter employee
     *
     * @param $page integer Page number of the results.
     * @param $limit integer Number of rows for the results.
     */
    public function ac_all_post($page, $limit)
    {
        if (empty($page))
            $page = 1;
        if (empty($limit))
            $limit = 20;

        $data = (new UserModel())->getAllUsers($page, $limit);
        if ($data) {
            $this->assignAll(['message' => 'OK', 'code' => 200, 'data' => $data])->render();
        } else {
            $this->assignAll(['message' => 'info.request.badGateway', 'code' => 502])->render();
        }
    }

    /**
     * @filter login
     */
    public function other()
    {
        $act = $this->getAction();
        if (is_numeric($act)) {
            // userId
            switch ($_SESSION['authority']) {
                case "user":
                    if ($act == $_SESSION['userId']) {
                        if ($data = (new UserModel())->getUser($act)) {
                            $this->assignAll(['message' => 'info.user.get.successful', 'code' => 200, 'data' => $data])->render();
                        } else {
                            $this->assignAll(['message' => 'info.request.badGateway', 'code' => 502])->render();
                        }
                    } else {
                        $this->assignAll(['message' => 'info.auth.failed', 'code' => 403])->render();
                    }

                    break;

                case "admin" || "staff":
                    if ($data = (new UserModel())->getUser($act)) {
                        $this->assignAll(['message' => 'info.user.get.successful', 'code' => 200, 'data' => $data])->render();
                    } else {
                        $this->assignAll(['message' => 'info.request.badGateway', 'code' => 502])->render();
                    }
                    break;

                default:
                    $this->assignAll(['message' => 'info.auth.failed', 'code' => 403])->render();
                    break;
            }
        } else {
            $this->assignAll(['message' => 'info.request.bad', 'code' => 400])->render();
        }
    }

}