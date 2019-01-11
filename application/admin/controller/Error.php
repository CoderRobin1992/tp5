<?php
/**
 * @Filename      :Error.php
 * @CreateTime    :2018 2018/12/20 21:29
 * @Author        :Robin
 * @Description   :
 */
namespace app\admin\controller;
use think\Controller;

class Error extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->redirect('admin/login/login');
    }

    public function _empty()
    {
        $this->redirect('admin/login/login');
    }
}