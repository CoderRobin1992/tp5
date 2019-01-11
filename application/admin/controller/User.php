<?php
/**
 * @Filename: User.php
 * @Author: 肖子恒
 * @Date: 2019/1/7
 * @Time:9:39
 */
namespace app\admin\controller;

/**
 * Class User 管理员
 * @package app\admin\controller
 */
class User extends Admin
{
    public function __construct()
    {
        parent::__construct();
    }

    public function role()
    {
        return view('admin-role','');
    }

    public function permission()
    {
        return view('admin-permission','');
    }

    public function admin_list()
    {
        return view('admin-list','');
    }

}