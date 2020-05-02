<?php

use BunnyPHP\Model;

class PetModel extends Model
{

    //addpet
    public function addPet($petUserId, $petBirth, $petName, $petType, $petDescription)
    {
        return $this->add([
            'pet_user_id' => $petUserId,
            'pet_birth' => $petBirth,
            'pet_name' => $petName,
            'pet_type' => $petType,
            'pet_description' => $petDescription,
        ]);
    }

    //getpet
    public function getPet($petId, $page, $limit)
    {
        return $this->where('pets_id = :p and pet_user_id = :pu', ['p' => $petId, 'pu' => $_SESSION['userId']])
            ->limit($limit, ($page - 1) * $limit)
            ->fetchAll();
    }

    public function getAllPet($page, $limit)
    {
        if ($_SESSION['authority'] == 'user') {
            return $this->where('pet_user_id = :pu', ['pu' => $_SESSION['userId']])
                ->limit($limit, ($page - 1) * $limit)
                ->fetchAll();
        } else {
            return $this->limit($limit, ($page - 1) * $limit)->fetchAll();
        }
    }

    //updatepet
    public function updatePet($petId, $petBirth, $petName, $petType, $petDescription)
    {
        return $this->where('pet_id = :n', ['n' => $petId])
            ->update([
                'pet_birth' => $petBirth,
                'pet_name' => $petName,
                'pet_type' => $petType,
                'pet_description' => $petDescription,
            ]);
    }

    //deletepet
    public function deletePet($petId)
    {
        return $this->where('pet_id = :p', ['p' => $petId])->delete();
    }
}

?>
