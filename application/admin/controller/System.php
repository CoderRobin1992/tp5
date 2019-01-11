<?php
/**
 * @Filename: System.php
 * @Author: 肖子恒
 * @Date: 2019/1/7
 * @Time:9:55
 */
namespace app\admin\controller;

/**
 * Class System 系统管理
 * @package app\admin\controller
 */
class System extends Admin
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @Function setting 系统设置
     * @return \think\response\View
     * @Author: Robin
     * @Date: 2019/1/7
     * @Time: 10:12
     * @Return: \think\response\View
     */
    public function setting()
    {
        return view('system-base');
    }

    /**
     * @Function system_category 栏目设置
     * @return \think\response\View
     * @Author: Robin
     * @Date: 2019/1/7
     * @Time: 10:12
     * @Return: \think\response\View
     */
    public function system_category()
    {
        return view('system-category');
    }

    /**
     * @Function system_data 数据字典
     * @return \think\response\View
     * @Author: Robin
     * @Date: 2019/1/7
     * @Time: 10:12
     * @Return: \think\response\View
     */
    public function system_data()
    {
        return view('system-data');
    }

    /**
     * @Function system_shielding 屏蔽词
     * @return \think\response\View
     * @Author: Robin
     * @Date: 2019/1/7
     * @Time: 10:13
     * @Return: \think\response\View
     */
    public function system_shielding()
    {
        return view('system-shielding');
    }

    /**
     * @Function system_log 系统日志
     * @return \think\response\View
     * @Author: Robin
     * @Date: 2019/1/7
     * @Time: 10:13
     * @Return: \think\response\View
     */
    public function system_log()
    {
        return view('system-log');
    }
}