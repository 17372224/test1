<?php

use BunnyPHP\Controller;

class PetController extends Controller
{
    /**
     * @filter login
     *
     * @param $petBirth
     * @param $petName
     * @param $petType
     * @param $petDescription
     */
    public function ac_add_post($petName, $petType, $petDescription, $petBirth = null)
    {
        $petUserId = $_SESSION['userId'];
        if (!empty($petUserId) && !empty($petName) && !empty($petType) && !empty($petDescription)) {
            if ((new PetModel())->addPet($petUserId, $petBirth, $petName, $petType, $petDescription)) {
                $this->assignAll(['message' => 'info.pet.add.successful', 'code' => 200])->render();
            } else {
                $this->assignAll(['message' => 'info.request.badGateway', 'code' => 502])->render();
            }
        } else {
            $this->assignAll(['massage' => 'info.request.bad', 'code' => 400])->render();
        }
    }

    /**
     * @filter login
     *
     * @param $petId
     * @param $petBirth
     * @param $petName
     * @param $petType
     * @param $petDescription
     */
    public function ac_update_post($petId, $petBirth, $petName, $petType, $petDescription)
    {
        if (!empty($petId) && !empty($petBirth) && !empty($petName) && !empty($petType) && !empty($petDescription)) {
            if ((new PetModel())->updatePet($petId, $petBirth, $petName, $petType, $petDescription)) {
                $this->assignAll(['message' => 'info.pet.update.successful', 'code' => 200])->render();
            } else {
                $this->assignAll(['message' => 'info.request.badGateway', 'code' => 502])->render();
            }
        } else {
            $this->assignAll(['massage' => 'info.request.bad', 'code' => 400])->render();
        }
    }

    /**
     * @filter login
     *
     * @param $petId
     */
    public function ac_delete_post($petId)
    {
        if (!empty($petId)) {
            if ((new PetModel())->deletePet($petId)) {
                $this->assignAll(['massage' => 'info.pet.delete.successful', 'code' => 200])->render();
            } else {
                $this->assignAll(['message' => 'info.request.badGateway', 'code' => 502])->render();
            }
        } else {
            $this->assignAll(['massage' => 'info.request.bad', 'code' => 400])->render();
        }
    }

    /**
     * @filter login
     *
     * @param $page integer Page number of the results.
     * @param $limit integer Number of rows for the results.
     */
    public function other($page, $limit)
    {
        $act = $this->getAction();
        if (empty($page)) {
            $page = 1;
        }
        if (empty($limit)) {
            $limit = 20;
        }

        if (is_numeric($act)) {
            if ($data = (new PetModel())->getPet(intval($act), $page, $limit)) {
                $this->assignAll(['message' => 'info.pet.get.successful', 'code' => 200, 'data' => $data])->render();
            } else {
                $this->assignAll(['message' => 'info.request.badGateway', 'code' => 502])->render();
            }
        } else if ($act == 'all') {
            if ($data = (new PetModel())->getAllPet($page, $limit)) {
                $this->assignAll(['message' => 'info.pet.get.successful', 'code' => 200, 'data' => $data])->render();
            } else {
                $this->assignAll(['message' => 'info.request.badGateway', 'code' => 502])->render();
            }
        } else {
            $this->assignAll(['message' => 'info.request.bad'])->render();
        }
    }

}

?>
