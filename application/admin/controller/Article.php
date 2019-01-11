<?php
/**
 * @Filename: Category.php
 * @Author: 肖子恒
 * @Date: 2018/12/24
 * @Time:10:39
 */
namespace app\admin\controller;

class Article extends Admin
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return view('product-list','');
    }
}