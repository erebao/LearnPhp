<?php

/**
 * Created by PhpStorm.
 * User: tanwb
 * Date: 2020/10/9
 * Time: 15:46
 */
require_once __DIR__ . '/ErrorCode.php';

class Article
{
    /**
     * 数据库连接对象
     * @var PDO
     */
    private $_db;

    /**
     * Article constructor.
     * @param PDO $_db
     */
    public function __construct(PDO $_db)
    {
        $this->_db = $_db;
    }

    /**
     * 文章发布
     * @param $title string 标题
     * @param $content string 内容
     * @param $user_id string 用户ID
     * @return array 文章信息
     * @throws Exception
     */
    public function create($title, $content, $user_id)
    {
        if (empty($title)) {
            throw new Exception("文章标题不能为空", ErrorCode::ARTICLE_TITLE_COMMOT_NULL);
        }
        if (empty($content)) {
            throw new Exception("文章内容不能为空", ErrorCode::ARTICLE_CONTENT_CONNOT_NULL);
        }
        $sql = "insert into `article`(`title`,`content`,`user_id`,`create_time`) value (:title, :content, :user_id, :create_time)";
        $time = date("Y-m-d H:i:s", time());
        $sm = $this->_db->prepare($sql);

        $sm->bindParam(':title', $title);
        $sm->bindParam(':content', $content);
        $sm->bindParam(':user_id', $user_id);
        $sm->bindParam(':create_time', $time);

        if (!$sm->execute()) {
            throw new Exception("发表文章失败", ErrorCode::ARTICLE_CREATE_FAIL);
        }
        return [
            'title' => $title,
            'content' => $content,
            'article_id' => $this->_db->lastInsertId(),
            'create_time' => $time,
            'user_id' => $user_id
        ];
    }

    /**
     * 查看文章
     * @param $article_id int 文章ID
     * @return mixed
     * @throws Exception
     */
    public function view($article_id)
    {
        if (empty($article_id)) {
            throw new Exception("文章ID不能为空", ErrorCode::ARTICLE_ID_CONNOT_NULL);
        }
        $sql = "select * from `article` where id = :id";
        $sm = $this->_db->prepare($sql);
        $sm->bindParam(":id", $article_id);
        if (!$sm->execute()) {
            throw new Exception("获取文章失败", ErrorCode::ARTICLE_GET_FAIL);
        }
        $article = $sm->fetch(PDO::FETCH_ASSOC);
        if (empty($article)) {
            throw new Exception("文章不存在", ErrorCode::ARTICLE_NOT_EXISTS);
        }
        return $article;
    }

    /**
     * 编辑文章
     * @param $article_id int 文章ID
     * @param $title string 标题
     * @param $content string 内容
     * @param $user_id int 用户ID
     * @return array|mixed
     * @throws Exception
     */
    public function edit($article_id, $title, $content, $user_id)
    {
        $article = $this->view($article_id);
        if ($user_id != intval($article['user_id'])) {
            throw new Exception("你无法操作此文章", ErrorCode::PREMISSION_NOT_ALLOW);
        }
        $title = empty($title) ? $article['title'] : $title;
        $content = empty($content) ? $article['content'] : $content;
        if ($title == $article['title'] && $content == $article['content']) {
            return $article;
        }
        $sql = "update `article` set `title` = :title, `content` = :content where `id` = :id";
        $sm = $this->_db->prepare($sql);
        $sm->bindParam(':title', $title);
        $sm->bindParam(':content', $content);
        $sm->bindParam(':id', $article_id);
        if (!$sm->execute()) {
            throw new Exception("编辑文章失败", ErrorCode::ARTICLE_EDIT_ERROR);
        }
        return [
            'title' => $title,
            'content' => $content,
            'article_id' => $article_id,
            'user_id' => $user_id
        ];
    }

    public function delete($article_id, $user_id)
    {
        $article = $this->view($article_id);
        if($user_id != intval($article['user_id'])){
            throw new Exception("无权操作此文章", ErrorCode::PREMISSION_NOT_ALLOW);
        }
        $sql = "delete from `article` where `id` = :id";
        $sm = $this->_db->prepare($sql);
        $sm->bindParam(':id', $article_id);
        if (!$sm->execute()) {
            throw new Exception("删除文章失败", ErrorCode::ARTICLE_EDIT_ERROR);
        }
        return $sm->execute();
    }

    public function _list($userId, $page = 1, $limit = 10)
    {
        $sql = 'SELECT * FROM `article` WHERE `user_id` = :userId ORDER BY `create_time` DESC LIMIT :offset, :limit';
        $offset = ($page - 1) * $limit;
        if ($offset < 0) {
            $offset = 0;
        }
        $sm = $this->_db->prepare($sql);
        $sm->bindParam(':userId', $userId, PDO::PARAM_INT);
        $sm->bindParam(':offset', $offset, PDO::PARAM_INT);
        $sm->bindParam(':limit', $limit, PDO::PARAM_INT);
        $sm->execute();
        return $sm->fetchAll(PDO::FETCH_ASSOC);
    }
}