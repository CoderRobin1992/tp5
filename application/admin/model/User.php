<?php
/**
 * @Filename      :User.php
 * @CreateTime    :2018 2018/12/23 19:34
 * @Author        :Robin
 * @Description   :
 */
namespace app\admin\Model;
use think\Model;
use think\captcha\Captcha;
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
     * @FunctionName        :login
     * @CreateTime          :2018 2018/12/23 23:21
     * @Author              :Robin
     * @Descript            :校验登录
     * @return bool
     */
    public function login()
    {
        $code = input('post.code','');
        $captch = new Captcha();
//        if(empty($code)){
//            $this->error = '验证码不能为空！';
//            return false;
//        }
//        if(!$captch->check($code)){
//            $this->error = '验证码错误！';
//            return false;
//        }
        $account = input('post.account','');
        $password = input('post.password','');
        $userInfo = Db::name('user')->where(['account' => $account])->find();
        if(!$userInfo){
            $this->error = '用户名不存在！';
            return false;
        }
        if(md5($userInfo['prefix'].$password) != $userInfo['pwd']){
            $this->error = '密码错误！';
            return false;
        }
        $online = input('post.online',0);
        if(empty($online)){
            $cacheTime = 3600;
        }else{
            $cacheTime = 7 * 24 * 3600;
        }
        //插入登录日志
        Db::name('login_log')->insert(['admin_id' => $userInfo['id'],'ip' => get_ip(),'dtime' => date('Y-m-d H:i:s')]);

        //更新访问日志
        $date = date('Y-m-d');
        $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
        if(strpos($agent,'windows nt')){
            $page_type = 0;
        }else if(strpos($agent,'iphone') || strpos($agent,'android')){
            $page_type = 1;
        }else{
            $page_type = 2;
        }
        $result = Db::name('page_log')->where(['date' => $date,'page_type' => $page_type,'type' => 1])->find();
        if(empty($result)){
            Db::name('page_log')->insert(['page_type' => $page_type,'type' => 1,'total' => 1,'date' => $date]);
        }else{
            Db::name('page_log')->update(['id' => $result['id'],'total' => $result['total'] + 1]);
        }
        return $userInfo;
    }
}
