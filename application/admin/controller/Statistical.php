<?php
/**
 * @Filename: Category.php
 * @Author: 肖子恒
 * @Date: 2018/12/24
 * @Time:10:39
 */
namespace app\admin\controller;
/**
 * Class Statistical 系统统计
 * @package app\admin\controller
 */
class Statistical extends Admin
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index1()
    {
        return view('charts-1','');
    }
    public function index2()
    {
        return view('charts-2','');
    }
    public function index3()
    {
        return view('charts-3','');
    }
    public function index4()
    {
        return view('charts-4','');
    }
    public function index5()
    {
        return view('charts-5','');
    }
    public function index6()
    {
        return view('charts-6','');
    }
    public function index7()
    {
        return view('charts-7','');
    }
}