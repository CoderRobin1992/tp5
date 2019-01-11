<?php
/**
 * @Filename: Chats.php
 * @Author: Robin
 * @Date: 2019/1/8
 * @Time:11:01
 */
namespace app\network\model;

use think\Db;
use think\Model;

class Chats extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @Function message_list 获取消息列表
     * @return bool|false|\PDOStatement|string|\think\Collection
     * @Author: Robin
     * @Date: 2019/1/8
     * @Time: 11:05
     * @Return: bool|false|\PDOStatement|string|\think\Collection
     */
    public function message_list()
    {
        $from_id = input('post.from_id','');
        $to_id = input('post.to_id','');
        if(!$from_id || !$to_id){
            $this->error = '系统错误！';
            return false;
        }
        $data = Db::name('chats')->where("is_del = 0 and ((from_id = $from_id and to_id = $to_id) or to_id = $from_id and from_id = $to_id)")->select();
        $arr = array();
        foreach($data as $k => $v){
            $arr[$k] = $v;
            $arr[$k]['content'] = htmlspecialchars_decode($v['content']);
            $arr[$k]['img'] = htmlspecialchars_decode($v['img']);
        }
        return $arr;
    }
}