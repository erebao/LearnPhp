<?php

#测试 http://localhost/back/10/Page?username=goudan&page=7
/*$page = new Page(5, 60);
var_dump($page->allUrl());*/

/**
 * 分页
 */
class Page
{
    //没业显示多少条数据
    protected $number;
    //一共有多少条数据
    protected $totalCount;
    //当前页
    protected $page;
    //总页数
    protected $totalPage;
    //url
    protected $url;

    public function __construct($number, $totalCount)
    {
        $this->number = $number;
        $this->totalCount = $totalCount;
        //得到总页数
        $this->totalPage = $this->getTotalPage();
        //得到当前页数
        $this->page = $this->getPage();
        //得到url
        $this->url = $this->getUrl();
        echo $this->url;
    }

    protected function getTotalPage()
    {
        return ceil($this->totalCount / $this->number);
    }

    protected function getPage()
    {
        if (empty($_GET['page'])) {
            $page = 1;
        } else if ($_GET['page'] > $this->totalPage) {
            $page = $this->totalPage;
        } else if ($_GET['page'] < 1) {
            $page = 1;
        } else {
            $page = $_GET['page'];
        }
        return $page;
    }

    protected function getUrl()
    {
        //得到协议名
        $scheme = $_SERVER['REQUEST_SCHEME'];
        //得到主机名
        $host = $_SERVER['SERVER_NAME'];
        //得到端口号
        $port = $_SERVER['SERVER_PORT'];
        //得到路径和请求字符串
        $uri = $_SERVER['REQUEST_URI'];

        //中间做处理，要将page=5等这种字符串拼接url中，所以如果原来url中有page这个参数，我们首先需要先将原来的page参数给清空
        $uriArray = parse_url($uri);
        $path = $uriArray['path'];

        if (!empty($uriArray['query'])) {
            //首先将请求字符串变为关联数组
            parse_str($uriArray['query'], $array);
            //清除掉关联数组中的page键值对
            unset($array['page']);
            //将剩下的参数拼接为请求字符串
            $query = http_build_query($array);
            //再将请求字符串拼接到路径的后面
            if ($query != '') {
                $path = $path . '?' . $query;
            }
        }
        return $scheme . '//' . $host . ':' . $port . $path;
    }

    protected function setUrl($str)
    {
        if (strstr($this->url, '?')) {
            $url = $this->url . '&' . $str;
        } else {
            $url = $this->url . '?' . $str;
        }
        return $url;
    }

    public function allUrl()
    {
        return [
            'first' => $this->first(),
            'prev' => $this->prev(),
            'next' => $this->next(),
            'end' => $this->end()
        ];
    }

    public function first()
    {
        return $this->setUrl('page=1');
    }

    public function next()
    {
        //根据当前page得到下一页的页码
        if ($this->page + 1 > $this->totalPage) {
            $page = $this->totalPage;
        } else {
            $page = $this->page + 1;
        }
        return $this->setUrl('page=' . $page);
    }

    public function prev()
    {
        if ($this->page - 1 < 1) {
            $page = 1;
        } else {
            $page = $this->page - 1;
        }
        return $this->setUrl('page=' . $page);
    }

    public function end()
    {
        return $this->setUrl('page=' . $this->totalPage);
    }

    public function limit()
    {
        //limit 0,5 limit 5,5
        $offset = ($this->page - 1) * $this->number;
        return $offset . ',' . $this->number;
    }
}