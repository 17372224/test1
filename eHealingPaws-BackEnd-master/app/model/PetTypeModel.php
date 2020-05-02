<?php

use BunnyPHP\Model;

class PetTypeModel extends Model
{

    //add petType
    public function addType($petTypeName)
    {
        return $this->add([
            'pet_type_name' => $petTypeName,
        ]);

    }

    //get petType
    public function getType($petTypeId)
    {
        return $this->where('pet_type_id = :p', ['p' => $petTypeId])->fetch();
    }

    public function getAllType()
    {
        return $this->fetchAll();
    }

    //update petType
    public function updateType($petTypeId, $petTypeName)
    {
        return $this->where('pet_type_id = :p', ['p' => $petTypeId])
            ->update([
                '$pet_type_name' => $petTypeName,
            ]);
    }

    //delete petType
    public function deleteType($petTypeId)
    {
        return $this->where('pet_type_id = :p', ['p' => $petTypeId])->delete();
    }
}

?>
