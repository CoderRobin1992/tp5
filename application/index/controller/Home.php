<?php
namespace app\index\controller;
use think\Controller;
/**
 * @Filename      :Home.php
 * @CreateTime    :2018 2018/12/19 21:17
 * @Author        :Robin
 * @Description   :
 */
class Home extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function params()
    {
        $this->redirect('index/index/index');
    }


    public function _empty()
    {
        echo '这是一个空操作!';
    }
}