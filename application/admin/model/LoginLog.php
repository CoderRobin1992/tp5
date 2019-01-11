<?php
/**
 * @Filename: Login_log.php
 * @Author: 肖子恒
 * @Date: 2018/12/24
 * @Time:9:54
 */
namespace app\admin\model;
use think\Model;
use think\Db;

class LoginLog extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function login_info()
    {
        $admin_id = session('admin_id','','admin');
        $sum = Db::name('login_log')->where(['admin_id' => $admin_id])->count('id');
        $result = Db::name('login_log')->where(['admin_id' => $admin_id])->order('id desc')->find();
        if(!empty($sum)){
            return array('ip' => $result['ip'],'dtime' => $result['dtime'],'sum' => $sum);
        }else{
            $this->error = '非法登录！';
            return false;
        }
    }
}