<?php
/**
 * @Filename      :tcp_server.php
 * @CreateTime    :2019 2019/1/1 10:53
 * @Author        :Robin
 * @Description   :
 */
//创建Server对象，监听 127.0.0.1:9501端口
class Tcp_server
{
    public $host = '127.0.0.1';
    public $port = 9501;
    public $server;

    public function __construct()
    {
        $this->server = new swoole_server($this->http,$this->port);
        //面向对象的回调函数写法
        $this->server->on('connect',[$this,'onConnect']);
        $this->server->on('receive',[$this,'onReceive']);
        $this->server->on('close',[$this,'onClose']);
        $this->server->start();
    }

    /**
     * @FunctionName        :onConnect
     * @CreateTime          :2019 2019/1/1 21:36
     * @Author              :Robin
     * @Descript            监听建立连接事件
     * @param $server       object TCP服务
     * @param $fd           int 客户端标识
     */
    public function onConnect($server,$fd)
    {
        echo "Client-{$fd}: Connect.\n";
    }

    /**
     * @FunctionName        :onReceive
     * @CreateTime          :2019 2019/1/1 21:36
     * @Author              :Robin
     * @Descript            监听数据接收事件
     * @param $server       object TCP服务
     * @param $fd           int 客户端标识
     * @param $from_id      int 客户端标识
     * @param $data         mixed 客户端数据
     */
    public function onReceive($server,$fd,$from_id,$data)
    {
        $server->send($fd, "I have received from Client-{$fd}!");
        echo $data;
    }

    /**
     * @FunctionName        :onClose
     * @CreateTime          :2019 2019/1/1 21:38
     * @Author              :Robin
     * @Descript            监听连接断开事件
     * @param $server       object TCP服务
     * @param $fd           int 客户端标识
     */
    public function onClose($server,$fd)
    {
        echo "Client-{$fd}: Close.\n";
    }
}

$obj = new tcp_server();