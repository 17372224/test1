<?php

use BunnyPHP\Controller;

class NewsController extends Controller
{
    /**
     * @filter staff
     *
     * @param $newsCategoryId
     * @param $newsTitle
     * @param $newsContent
     */
    public function ac_add_post($newsCategoryId, $newsTitle, $newsContent)
    {
        $news_author = $_SESSION['userId'];
        if (!empty($newsCategoryId) && !empty($newsTitle) && !empty($news_author) && !empty($newsContent)) {
            if ((new NewsModel())->addNews($newsCategoryId, $newsTitle, $news_author, $newsContent)) {
                $this->assignAll(['message' => 'info.news.add.successful', 'code' => 200])->render();
            } else {
                $this->assignAll(['message' => 'info.request.badGateway', 'code' => 502])->render();
            }
        } else {
            $this->assignAll(['massage' => 'info.request.bad', 'code' => 400])->render();
        }
    }

    /**
     * @filter staff
     *
     * @param $newsId
     * @param $newsCategoryId
     * @param $newsTitle
     * @param $newsAuthor
     * @param $newsPublished
     * @param $newsContent
     */
    public function ac_update_post($newsId, $newsCategoryId, $newsTitle, $newsAuthor, $newsPublished, $newsContent)
    {
        if (!empty($newsId) && !empty($newsCategoryId) && !empty($newsTitle) && !empty($newsAuthor) && !empty($newsPublished) && !empty($newsContent)) {
            if ((new NewsModel())->updateNews($newsId, $newsCategoryId, $newsTitle, $newsAuthor, $newsPublished, $newsContent)) {
                $this->assignAll(['message' => 'info.news.update.successful', 'code' => 200])->render();
            } else {
                $this->assignAll(['message' => 'info.request.badGateway', 'code' => 502])->render();
            }
        } else {
            $this->assignAll(['massage' => 'info.request.bad', 'code' => 400])->render();
        }
    }

    /**
     * @filter staff
     *
     * @param $newsId
     */
    public function ac_delete_post($newsId)
    {
        if (!empty($newsId)) {
            if ((new NewsModel())->deleteNews($newsId)) {
                $this->assignAll(['massage' => 'info.news.delete.successful', 'code' => 200])->render();
            } else {
                $this->assignAll(['message' => 'info.request.badGateway', 'code' => 502])->render();
            }
        } else {
            $this->assignAll(['massage' => 'info.request.bad', 'code' => 400])->render();
        }
    }

    public function other()
    {
        $act = $this->getAction();
        if (is_numeric($act)) {
            if ($data = (new NewsModel())->getNews(intval($act))) {
                $this->assignAll(['message' => 'info.news.get.successful', 'code' => 200, 'data' => $data])->render();
            } else {
                $this->assignAll(['message' => 'info.request.badGateway', 'code' => 502])->render();
            }
        } else if ($act == 'all') {
            if ($data = (new NewsModel())->getAllNews()) {
                $this->assignAll(['message' => 'info.news.get.successful', 'code' => 200, 'data' => $data])->render();
            } else {
                $this->assignAll(['message' => 'info.request.badGateway', 'code' => 502])->render();
            }
        } else {
            $this->assignAll(['message' => 'info.request.bad'])->render();
        }
    }

}

?>
