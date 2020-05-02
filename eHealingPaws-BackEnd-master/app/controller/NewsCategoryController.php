<?php

use BunnyPHP\Controller;

class NewsCategoryController extends Controller
{
    /**
     * @filter admin
     *
     * @param $categoryName
     * @param $categoryDescription
     */
    public function ac_add_post($categoryName, $categoryDescription)
    {
        if (!empty($categoryName) && !empty($categoryDescription)) {
            if ((new NewsCategoryModel())->addCategory($categoryName, $categoryDescription)) {
                $this->assignAll(['message' => 'info.news.category.add.successful', 'code' => 200])->render();
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
     * @param $categoryId
     * @param $categoryName
     * @param $categoryDescription
     */
    public function ac_update_post($categoryId, $categoryName, $categoryDescription)
    {
        if (!empty($categoryId) && !empty($categoryName) && !empty($categoryDescription)) {
            if ((new NewsCategoryModel())->updateCategory($categoryId, $categoryName, $categoryDescription)) {
                $this->assignAll(['message' => 'info.news.category.update.successful', 'code' => 200])->render();
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
     * @param $categoryId
     */
    public function ac_delete_post($categoryId)
    {
        if (!empty($categoryId)) {
            if ((new NewsCategoryModel())->deleteCategory($categoryId)) {
                $this->assignAll(['massage' => 'info.news.category.delete.successful', 'code' => 200])->render();
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
            if ($data = (new NewsCategoryModel())->getCategory(intval($act))) {
                $this->assignAll(['message' => 'info.news.category.add.successful', 'code' => 200, 'data' => $data])->render();
            } else {
                $this->assignAll(['message' => 'info.request.badGateway', 'code' => 502])->render();
            }
        } else if ($act == "all") {
            if ($data = (new NewsCategoryModel())->getCategories()) {
                $this->assignAll(['message' => 'info.news.category.get.successful', 'code' => 200, 'data' => $data])->render();
            } else {
                $this->assignAll(['message' => 'info.request.badGateway', 'code' => 502])->render();
            }
        } else {
            $this->assignAll(['message' => 'info.request.bad', 'code' => 400])->render();
        }

    }

}

?>
