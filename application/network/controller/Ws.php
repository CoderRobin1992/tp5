<?php
namespace app\network\controller;

/**
 * @Filename      :Ws_log.php
 * @CreateTime    :2019 2019/1/1 13:29
 * @Author        :Robin
 * @Description   :
 */
class Ws
{
    public $host = '0.0.0.0';
    public $ip = '127.0.0.1';
    public $port = 8812;
    public $username = 'root';
    public $password = 'Rwxp72tDM3GTRs5j';
    public $database = 'blog';
    public $ws;
    public $db;
    public function __construct()
    {
        $this->ws = new \swoole_websocket_server($this->host, $this->port);
        //面向对象的回调
        $this->ws->on('open',[$this,'onOpen']);
        $this->ws->on('message',[$this,'onMessage']);
        $this->ws->on('close',[$this,'onClose']);
        //开启websocket服务
        $this->ws->start();
    }


    /**
     * @FunctionName        :onOpen
     * @CreateTime          :2019 2019/1/1 13:31
     * @Author              :Robin
     * @Descript            监听ws连接事件
     * @param $ws
     * @param $request
     */
    public function onOpen($ws,$request)
    {
        $f_id = $request->fd;
        $info = $request->server;
        $ip = $info['remote_addr'];
        $request_uri = trim($info['request_uri'],'/');
        $data = explode('/',$request_uri);
        $dtime = date('Y-m-d H:i:s');
        $time = time();
        //连接数据库
        $this->db = mysqli_connect($this->ip,$this->username,$this->password) or die(mysqli_connect_error());
        mysqli_select_db($this->db,$this->database) or die();
        $sql = "insert into blog_ws_log(user_id,f_id,ip,dtime,time,is_online) values($data[0],$f_id,'$ip','$dtime',$time,1)";
        $this->db->query($sql);
        //如果有未读消息，进行消息展示
        $sql = "select count(id),from_id from blog_chats where to_id = $f_id and is_send = 0 group by from_id";
        $result = $this->db->query($sql);
        if($result->num_rows > 0){
            $data = mysqli_fetch_all($result);
            $ws->push($f_id,json_encode($data));
        }
        $this->db->close();
    }

    /**
     * @FunctionName        :onMessage
     * @CreateTime          :2019 2019/1/1 13:32
     * @Author              :Robin
     * @Descript            监听ws消息事件
     * @param $ws
     * @param $frame
     */
    public function onMessage($ws,$frame)
    {
        //$frame->fd;发送消息的线程
        $data = json_decode($frame->data,true);
        //连接数据库
        $this->db = mysqli_connect($this->ip,$this->username,$this->password) or die(mysqli_connect_error());
        mysqli_select_db($this->db,$this->database) or die();
        $content = htmlspecialchars($data['content']);
        if(strpos($content,'data:image') === false){
            $img = '';
        }else{
            //上传图片，另作处理
            $content = '';
            $img = '';
        }
        $dtime = date('Y-m-d H:i:s');
        $time = time();
        $sql = "insert into blog_chats(from_id,to_id,content,img,dtime,time) values($data[from_id],$data[to_id],'$content','$img','$dtime',$time)";
        $message_id = $this->db->query($sql);
        //如果消息接收方在线，向客户端发送消息
        $sql = "select f_id from blog_ws_log where is_online = 1 and user_id = $data[to_id] order by id desc limit 1";
        $res = $this->db->query($sql);
        if($res->num_rows){
            $to_id = mysqli_fetch_assoc($res)['f_id'];
            $push_data = json_encode(['from_id' => $data['from_id'],'content' => htmlspecialchars_decode($content),'img' => $img]);
            $ws->push($to_id,$push_data);
            $sql = "update blog_chats set is_send = 1 where id = $message_id";
            $this->db->query($sql);
        }
        $this->db->close();
    }

    /**
     * @FunctionName        :onClose
     * @CreateTime          :2019 2019/1/1 13:35
     * @Author              :Robin
     * @Descript            监听ws关闭事件
     * @param $ws
     * @param $fd
     */
    public function  onClose($ws,$fd)
    {
        $this->db = mysqli_connect($this->ip,$this->username,$this->password) or die(mysqli_connect_error());
        mysqli_select_db($this->db,$this->database) or die();
        $sql = "update blog_ws_log set is_online = 0 where f_id = $fd";
        $this->db->query($sql);
        $this->db->close();
    }

    public function __destruct()
    {
        $this->db = mysqli_connect($this->ip,$this->username,$this->password) or die(mysqli_connect_error());
        mysqli_select_db($this->db,$this->database) or die();
        $sql = "update blog_ws_log set is_online = 0";
        $this->db->query($sql);
        $this->db->close();
    }
}

$obj = new Ws();