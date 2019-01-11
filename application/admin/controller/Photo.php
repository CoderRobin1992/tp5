<?php
/**
 * @Filename: Category.php
 * @Author: 肖子恒
 * @Date: 2018/12/24
 * @Time:10:39
 */
namespace app\admin\controller;

class Photo extends Admin
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @Function index 相册管理
     * @return \think\response\View
     * @Author: Robin
     * @Date: 2019/1/7
     * @Time: 10:09
     * @Return: \think\response\View
     */
    public function index()
    {
        return view('picture-list','');
    }
}