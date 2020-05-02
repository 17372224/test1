<?php

use BunnyPHP\Controller;

class PetTypeController extends Controller
{
    /**
     * @filter admin
     *
     * @param $petTypeName
     */
    public function ac_add_post($petTypeName)
    {
        if (!empty($petTypeName)) {
            if ((new PetTypeModel())->addType($petTypeName)) {
                $this->assignAll(['message' => 'info.pet.type.add.successful', 'code' => 200])->render();
            } else {
                $this->assignAll(['message' => 'info.request.badGateway', 'code' => 502])->render();
            }
        } else {
            $this->assignAll(['message' => 'info.request.bad', 'code' => 400])->render();
        }
    }

    /**
     * @filter admin
     *
     * @param $petTypeId
     * @param $petTypeName
     */
    public function ac_update_post($petTypeId, $petTypeName)
    {
        if (!empty($petTypeId) && !empty($petTypeName)) {
            if ((new PetTypeModel())->updateType($petTypeId, $petTypeName)) {
                $this->assignAll(['message' => 'info.pet.type.update.successful', 'code' => 200])->render();
            } else {
                $this->assignAll(['message' => 'info.request.badGateway', 'code' => 502])->render();
            }
        } else {
            $this->assignAll(['message' => 'info.request.bad', 'code' => 400])->render();
        }
    }

    /**
     * @filter admin
     *
     * @param $petTypeId
     */
    public function ac_delete_post($petTypeId)
    {
        if (!empty($petTypeId)) {
            if ((new PetTypeModel())->deleteType($petTypeId)) {
                $this->assignAll(['massage' => 'info.pet.type.delete.successful', 'code' => 200])->render();
            } else {
                $this->assignAll(['message' => 'info.request.badGateway', 'code' => 502])->render();
            }
        } else {
            $this->assignAll(['message' => 'info.request.bad', 'code' => 400])->render();
        }
    }

    public function others()
    {
        $act = $this->getAction();
        if (is_numeric($act)) {
            // get type info
            if ($data = (new PetTypeModel())->getType(intval($act))) {
                $this->assignAll(['message' => 'info.pet.type.get.successful', 'code' => 200, 'data' => $data])->render();
            } else {
                $this->assignAll(['message' => 'info.request.badGateway', 'code' => 502])->render();
            }
        } else if ($act == "all") {
            // get all type info as array
            if ($data = (new PetTypeModel())->getAllType()) {
                $this->assignAll(['message' => 'info.pet.type.get.successful', 'code' => 200, 'data' => $data])->render();
            } else {
                $this->assignAll(['message' => 'info.request.badGateway', 'code' => 502])->render();
            }
        } else {
            $this->assignAll(['message' => 'info.request.bad', 'code' => 400])->render();
        }

    }

}

?>
