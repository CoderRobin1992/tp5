<?php
/**
 * @Filename      :tcp_client.php
 * @CreateTime    :2019 2019/1/1 11:08
 * @Author        :Robin
 * @Description   :
 */
class Tcp_client
{
    public $host = '127.0.0.1';
    public $port = 9501;
    public $timeout = 0.5;
    public $client;

    public function __construct()
    {
        $this->client = new swoole_client(SWOOLE_SOCK_TCP);
        //连接到服务器
        if (!$this->client->connect($this->host,$this->port, $this->timeout))
        {
            die("connect failed.\n");
        }
        $this->send($this->client);
        $this->receive($this->client);
    }

    /**
     * @FunctionName        :send
     * @CreateTime          :2019 2019/1/1 21:39
     * @Author              :Robin
     * @Descript            向服务端发送数据
     * @param $tcp          obj 客户端服务
     */
    public function send($tcp)
    {
        fwrite(STDOUT,"请输入消息：");
        $msg = trim(fgets(STDIN));
        if(!$tcp->send($msg)){
            die("send failed.\n");
        }
    }

    /**
     * @FunctionName        :receive
     * @CreateTime          :2019 2019/1/1 21:39
     * @Author              :Robin
     * @Descript            接收服务端返回数据
     * @param $tcp          obj 客户端服务
     */
    public function receive($tcp)
    {
        $data = $tcp->recv();
        if(!$data){
            die("received failed.\n");
        }
        echo $data;
    }

    public function __destruct()
    {
        $this->client->close();
    }
}

$obj = new Tcp_client();