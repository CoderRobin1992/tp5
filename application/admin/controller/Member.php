<?php
/**
 * @Filename: Member.php
 * @Author: 肖子恒
 * @Date: 2019/1/7
 * @Time:9:45
 */
namespace app\admin\controller;

/**
 * Class Member 会员管理
 * @package app\admin\controller
 */
class Member extends Admin
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @Function member_list 会员列表页
     * @return \think\response\View
     * @Author: Robin
     * @Date: 2019/1/7
     * @Time: 10:03
     * @Return: \think\response\View
     */
    public function member_list()
    {
        return view('member-list','');
    }

    /**
     * @Function member_del 删除的会员
     * @return \think\response\View
     * @Author: Robin
     * @Date: 2019/1/7
     * @Time: 10:08
     * @Return: \think\response\View
     */
    public function member_del()
    {
        return view('member-del','');
    }

    /**
     * @Function member_record_browse 浏览记录
     * @return \think\response\View
     * @Author: Robin
     * @Date: 2019/1/7
     * @Time: 10:08
     * @Return: \think\response\View
     */
    public function member_record_browse()
    {
        return view('member-record-browse','');
    }

    /**
     * @Function member_record_download 下载记录
     * @return \think\response\View
     * @Author: Robin
     * @Date: 2019/1/7
     * @Time: 10:09
     * @Return: \think\response\View
     */
    public function member_record_download()
    {
        return view('member-record-download','');
    }

    /**
     * @Function member_record_share 分享记录
     * @return \think\response\View
     * @Author: Robin
     * @Date: 2019/1/7
     * @Time: 10:09
     * @Return: \think\response\View
     */
    public function member_record_share()
    {
        return view('member-record-share','');
    }
}