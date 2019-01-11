<?php
/**
 * @Filename: chat.php
 * @Author: 肖子恒
 * @Date: 2019/1/7
 * @Time:9:01
 */
namespace app\network\controller;



/**
 * Class Chat 聊天功能
 * @package app\network\controller
 */
class Chat extends \app\admin\controller\Admin
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @Function index 在线聊天首页
     * @return \think\response\View
     * @Author: Robin
     * @Date: 2019/1/7
     * @Time: 11:14
     * @Return: \think\response\View
     */
    public function index()
    {
        $admin_id = session('admin_id','','admin');
        $nickname = session('admin_nickname','','admin');
        $mold = model('user');
        $user_list = $mold->get_user_list($admin_id);
        $data = array(
            'admin_id' => $admin_id,
            'nickname' => $nickname,
            'user_list' => $user_list
        );
        return view('index', $data);
    }

    /**
     * @Function message_list 获取聊天信息
     * @Author: Robin
     * @Date: 2019/1/8
     * @Time: 11:11
     * @Return: void
     */
    public function message_list()
    {
        $model = model('chats');
        $result = $model->message_list();
        if($result){
            echo json_encode($result);exit;
        }else{
            echo json_encode($model->getError());exit;
        }
    }
}
