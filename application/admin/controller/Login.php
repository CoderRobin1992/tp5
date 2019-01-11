<?php
/**
 * @Filename: Login.php
 * @Author: 肖子恒
 * @Date: 2018/10/22
 * @Time:17:18
 */
namespace app\admin\controller;
use think\Controller;
use think\captcha\Captcha;

class Login extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
     * @FunctionName        login
     * @CreateTime  2018 2018/10/21 18:21
     * @Author     xzh
     * @Descript    后台登录界面
     */
    public function login()
    {
        return view('login', '');
    }

    /**
     * @Function getCaptcha 生成验证码
     * @return \think\Response
     * @Author: 肖子恒
     * @Date: 2018/10/22
     * @Time: 17:51
     * @Return: \think\Response
     */
    public function getCaptcha()
    {
        $captch = new Captcha(['imageH' => 40,'imageW' => 200,'fontSize' => 20]);
        $code = $captch->entry();
        return $code;
    }

    /**
     * @Function validated 校验登录
     * @Author: Robin
     * @Date: 2019/1/7
     * @Time: 10:09
     * @Return: void
     */
    public function validated()
    {
        $model = model('User');
        //调用自定义的方法实现登录
        $result = $model->login();
        if($result === false){
            $this->error($model->getError());
        }else{
            session('admin_id',$result['id'],'admin');
            session('admin_nickname',$result['nickname'],'admin');
        }
        $this->success('登录成功','index/index');
    }

    /**
     * @Function _empty 空操作
     * @Author: Robin
     * @Date: 2019/1/7
     * @Time: 10:09
     * @Return: void
     */
    public function _empty()
    {
        $this->redirect('admin/login/login');
    }
}