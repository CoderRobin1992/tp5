<?php
/**
 * @Filename      :http_server.php
 * @CreateTime    :2019 2019/1/1 12:39
 * @Author        :Robin
 * @Description   :
 */
//静态文件发生变动 ，http服务端必须重启，因为服务本身是常驻内存的，如果不重启，那么http服务就还停留在修改前的状态
class Http_server
{
    public $host = '127.0.0.1';
    public $port = 9911;
    public $http;

    public function __construct()
    {
        $this->http = new swoole_http_server($this->host,$this->port);
        $this->http->set([
            'enable_static_handler' => true,//开启静态文件分发
            'document_root' => '/www/data'//静态文件根目录
        ]);
        $this->http->on('request',[$this,'onRequest']);
        $this->http->start();
    }

    /**
     * @FunctionName        :onRequest
     * @CreateTime          :2019 2019/1/1 22:15
     * @Author              :Robin
     * @Descript            监听http请求事件
     * @param $request      mixed 接收的数据
     * @param $response     mixed 返回的数据
     */
    public function onRequest($request,$response)
    {
        echo '<pre>';
        var_dump($request->get);
        $response->end("<h1>httpserver</h1>");
    }
}

$obj = new Http_server();