<?php

use BunnyPHP\Model;

class NewsModel extends Model
{

    //addnews
    public function addNews($category_id, $title, $author, $content)
    {
        return $this->add([
            'news_category_id' => $category_id,
            'news_title' => $title,
            'news_author' => $author,
            'news_content' => $content,
        ]);
    }

    //getnews
    public function getNews($news_id)
    {
        return $this->where('news_id = :n', ['n' => $news_id])->fetch();
    }

    public function getAllNews()
    {
        return $this->fetchAll();
    }

    //updatenews
    public function updateNews($news_id, $category_id, $title, $author, $time, $content)
    {
        return $this->where('news_id = :n', ['n' => $news_id])
            ->update([
                'news_category_id' => $category_id,
                'news_title' => $title,
                '$news_author' => $author,
                '$news_published' => $time,
                '$news_content' => $content
            ]);
    }

    //deletenews
    public function deleteNews($news_id)
    {
        return $this->where('news_id = :n', ['n' => $news_id])->delete();
    }
}

?>
