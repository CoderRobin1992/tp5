<?php
/**
 * @Filename      :Error.php
 * @CreateTime    :2018 2018/12/20 21:29
 * @Author        :Robin
 * @Description   :
 */
namespace app\index\controller;
use think\Controller;

class Error extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return 'this is an empty controller!';
    }

    public function _empty()
    {
        return 'this is an empty action!';
    }
}