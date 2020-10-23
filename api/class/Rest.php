<?php

/**
 * Created by PhpStorm.
 * User: tanwb
 * Date: 2020/10/9
 * Time: 17:54
 */
class Rest
{
    /**
     * @var User
     */
    private $_user;

    /**
     * @var Article
     */
    private $_article;

    /**
     * @var请求方式
     */
    private $_requestMethod;

    /**
     * 请求资源
     * @var
     */
    private $requestResource;

    /**
     * 允许请求的资源
     * @var array
     */
    private $_allowResource = ['users', 'articles'];

    /**
     * 允许请求的方法
     * @var array
     */
    private $_allowMethod = ['GET', 'POST', 'PUT', 'DELETE'];

    /**
     * 版本号
     * @var
     */
    private $_version;

    /**
     * 资源标识
     * @var
     */
    private $_requestUri;

    /**
     * 常见的状态码
     * @var array
     */
    private $_statusCode = [
        200 => "OK",
        204 => "No Content",
        400 => "Bad Request",
        403 => "Forbidden",
        404 => "Not Found",
        405 => "Method Not Allowed",
        500 => "server Internal Error"
    ];

    /**
     * Rest constructor.
     * @param $_user
     * @param $_article
     */
    public function __construct(User $_user, Article $_article)
    {
        $this->_user = $_user;
        $this->_article = $_article;
    }

    /**
     * api 启动方法
     */
    public function run()
    {
        try {
            $this->setMethod();
            $this->setResource();
            if ($this->requestResource == 'users') {
                $this->sendUsers();
            } else {
                $this->sendArticles();
            }
        } catch (Exception $e) {
            $this->_json($e->getMessage(), $e->getCode());
        }
    }

    /**
     * 设置api请求方法
     * @throws Exception
     */
    private function setMethod()
    {
        $this->_requestMethod = $_SERVER['REQUEST_METHOD'];
        if (!in_array($this->_requestMethod, $this->_allowMethod)) {
            throw new Exception("请求方法不被允许", 405);
        }
    }

    /**
     * 处理资源
     * @throws Exception
     */
    private function setResource()
    {
        $path = $_SERVER['PATH_INFO'];
        $params = explode('/', $path);
        $this->requestResource = $params['2'];
        if (!in_array($this->requestResource, $this->_allowResource)) {
            throw new Exception("请求资源不被允许", 405);
        }
        $this->_version = $params[1];

        if (!empty($params[3])) {
            $this->_requestUri = $params[3];
        }
    }

    /**
     * 数据输出
     * @param $message string 提示信息
     * @param $code string 提示状态码
     */
    private function _json($message, $code)
    {
        if ($code !== 200 && $code > 200) {
            header('HTTP/1.1 ' . $code . ' ' . $this->_statusCode[$code]);
        }
        header("Content-type:application/json;charset:utf-8");
        if (!empty($message)) {
            echo json_encode(['message' => $message, 'code' => $code]);
        }
        die;
    }

    /**
     * 处理用户逻辑
     */
    private function sendUsers()
    {
        if ($this->_requestMethod !== "POST") {
            throw new Exception('请求方法不被允许', 405);
        }
        if (empty($this->_requestUri)) {
            throw new Exception('请求参数缺失', 400);
        }
        if ($this->_requestUri == 'login') {
            $this->dologin();
        } else if ($this->_requestUri == 'register') {
            $this->doregister();
        } else {
            throw new Exception('请求资源不被允许', 405);
        }
    }

    /**
     * 处理文章逻辑
     */
    private function sendArticles()
    {
        //分发请求
        switch($this->_requestMethod){
            case "POST":
                return $this->articleCreate();
            case "PUT":
                return $this->articleEdit();
            case "DELETE":
                return $this->articleDelete();
            case "GET":
                if($this->_requestUri == 'list'){
                    return $this->articleList();
                }else if($this->_requestUri > 0){
                    return $this->articleView();
                }else{
                    throw new Exception('请求资源不合法', 405);
                }
        }
    }

    private function dologin()
    {
        $data = $this->getBody();
        if (empty($data['name'])) {
            throw new Exception('用户名不能为空', 400);
        }
        if (empty($data['password'])) {
            throw new Exception('用户密码不能为空', 400);
        }
        $user = $this->_user->login($data['name'], $data['password']);
        $data = [
            'data' => [
                'user_id' => $user['id'],
                'name' => $user['name'],
                'token' => session_id()
            ],
            'message' => '登录成功',
            'code' => 200
        ];
        //用SESSION保存登录用户的ID
        $_SESSION['userInfo']['id'] = $user['id'];
        echo json_encode($data);
    }

    /**
     * 用户注册接口
     * @throws Exception
     */
    private function doregister()
    {
        $data = $this->getBody();
        if (empty($data['name'])) {
            throw new Exception('用户名不能为空', 400);
        }
        if (empty($data['password'])) {
            throw new Exception('用户密码不能为空', 400);
        }
        $user = $this->_user->register($data['name'], $data['password']);
        if ($user) {
            $this->_json('注册成功', 200);
        }
    }

    private function getBody()
    {
        $data = file_get_contents("php://input");
        if (empty($data)) {
            throw new Exception('请求参数错误', 400);
        }
        return json_decode($data, true);
    }

    private function articleCreate()
    {
        $data = $this->getBody();
        if(empty($data['title'])){
            throw new Exception('文章的标题不能为空', 400);
        }
        if(empty($data['content'])){
            throw new Exception('文章的内容不能为空', 400);
        }

        if(!$this->isLogin($data['token'])){
            throw new Exception('请重新登录', 403);
        }
        $user_id = $_SESSION['userInfo']['id'];
        $return = $this->_article->create($data['title'], $data['content'], $user_id);
        if(!empty($return)){
            $this->_json('文章发表成功', 200);
        }
    }

    /**
     * 判断用户是否登录
     * @param $token
     */
    private function isLogin($token){
        $sessionID = session_id();
        if($sessionID != $token){
            return false;
        }
        return true;
    }

    /**
     * 文章修改API
     */
    private function articleEdit()
    {
        $data = $this->getBody();
        if(!$this->isLogin($data['token'])){
            throw new Exception('请重新登录', 403);
        }
        $article = $this->_article->view($this->_requestUri);
        if($article['user_id'] != $_SESSION['userInfo']['id']){
            throw new Exception('您无权限修改此文章', 403);
        }
        $return = $this->_article->edit($this->_requestUri, $data['title'], $data['content'], $_SESSION['userInfo']['id']);
        if($return) {
            $data = [
                'data' => [
                    'title'=>$data['title'],
                    'content'=>$data['content'],
                    'user_id'=>$article['user_id'],
                    'create_time'=>$article['create_time']
                ],
                'message'=>'修改成功',
                'code'=>200
            ];
            echo json_encode($data);
            die;
        }
        $data = [
            'data' => [
                'title'=>$article['title'],
                'content'=>$article['content'],
                'user_id'=>$article['user_id'],
                'create_time'=>$article['create_time']
            ],
            'message' => '文章修改失败',
            'code'=>500
        ];
        echo json_encode($data);
        die;
    }

    /**
     * 文章删除API接口
     */
    private function articleDelete()
    {
        $data = $this->getBody();
        if(!$this->isLogin($data['token'])){
            throw new Exception('请重新登录', 403);
        }
        $article = $this->_article->view($this->_requestUri);
        if($article['user_id'] != $_SESSION['userInfo']['id']){
            throw new Exception('您无权限删除此文章', 403);
        }
        $return = $this->_article->delete($this->_requestUri, $_SESSION['userInfo']['id']);
        if($return){
            $this->_json('删除文章成功', 200);
        }
        $this->_json('删除失败', 500);
    }

    /**
     * 查看文章API接口
     */
    private function articleView()
    {
        //获取请求头信息中用户携带的token
        $token = $_SERVER['HTTP_TOKEN'];
        //判断用户是否已经登录
        if(!$this->isLogin($token)){
            throw new Exception('请重新登录', 403);
        }
        $article = $this->_article->view($this->_requestUri);
        if($article['user_id'] != $_SESSION['userInfo']['id']){
            //文章权限限创建用户查看
            throw new Exception('您无权查看此文章', 403);
        }
        //组赚数据并返回
        $data = [
            'data' => [
                'title'=>$article['title'],
                'content'=>$article['content'],
                'user_id'=>$article['user_id'],
                'create_time'=>$article['create_time']
            ],
            'message'=>'获取成功',
            'code'=>200
        ];
        echo json_encode($data);
    }

}