<?php

use BunnyPHP\Model;

class NewsCategoryModel extends Model
{

    //add category
    public function addCategory($category_name, $category_description)
    {
        return $this->add([
            'category_name' => $category_name,
            'category_description' => $category_description
        ]);

    }

    //get category
    public function getCategory($category_id)
    {
        return $this->where('category_id = :c', ['c' => $category_id])->fetch();
    }

    public function getCategories()
    {
        return $this->fetchAll();
    }

    //update category
    public function updateCategory($category_id, $category_name, $category_description)
    {
        return $this->where('category_id = :c', ['c' => $category_id])
            ->update([
                'category_name' => $category_name,
                '$category_description' => $category_description,
            ]);
    }

    //delete category
    public function deleteCategory($category_id)
    {
        return $this->where('category_id = :c', ['c' => $category_id])->delete();
    }
}

?>
