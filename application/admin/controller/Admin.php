<?php
/**
 * @Filename: admin.php
 * @Author: 肖子恒
 * @Date: 2018/10/22
 * @Time:16:11
 */
namespace app\admin\controller;
use think\Controller;
use think\Db;

class Admin extends Controller
{
    protected $admin_id;

    public function __construct()
    {
        parent::__construct();
        $this->update_login();
        //获取管理员id
        $admin_id = session('admin_id','','admin');
        if(empty($admin_id)){
            $this->redirect('admin/login/login');
        }
    }

    /**
     * @Function update_login 登录日志
     * @Author: Robin
     * @Date: 2019/1/8
     * @Time: 11:05
     * @Return: void
     */
    protected function update_login()
    {
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
            Db::name('page_log')->update(['id' => $result['id'],'total' => $result['total']+1]);
        }
    }
}