<?php
namespace app\index\controller;
use think\Controller;
use think\Db;


class Index extends Controller
{
    protected $request;
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @FunctionName        :index 前台首页
     * @CreateTime          :2018 2018/12/20 22:15
     * @Author              :Robin
     * @Descript
     * @return \think\response\View
     */
    public function index()
    {
        return view('index');
    }

    public function test()
    {
        return view('test');
    }
}