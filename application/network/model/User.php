<?php
/**
 * @Filename: User.php
 * @Author: 肖子恒
 * @Date: 2019/1/7
 * @Time:9:28
 */
namespace app\network\model;
use think\Model;
use think\Db;
/**
 * Class User
 * @package app\admin\controller 用户模型
 */
class User extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @Function get_user_list 获取除本人外的其他管理员id，昵称
     * @param $admin_id
     * @return false|\PDOStatement|string|\think\Collection
     * @Author: Robin
     * @Date: 2019/1/7
     * @Time: 11:15
     * @Return: false|\PDOStatement|string|\think\Collection
     */
    public function get_user_list($admin_id)
    {
        return Db::name('user')->where("id != $admin_id")->field('id,nickname')->select();
    }
}