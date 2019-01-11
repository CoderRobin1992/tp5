<?php
/**
 * @Filename      :Svnupdate.php
 * @CreateTime    :2018 2018/12/23 9:55
 * @Author        :Robin
 * @Description   :
*/

namespace app\index\controller;
use think\Controller;

class Svnupdate extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
//        $output = @shell_exec("svn up /www/wwwroot/tp5 --username robin --password Robin1992 --no-auth-cache 2>&1");
        $output = @shell_exec("svn co svn://47.105.156.119/robin /www/wwwroot/tp5/ --username robin --password Robin1992 --no-auth-cache 2>&1");
        echo '<pre>';
        var_dump($output);
        echo "If it is locked, please open this link to cleanup:<a href='http://tp.xiaoziheng.club/svncleanup'>点击清理svn</a>";

    }

    public function cleanup()
    {
        $output = @shell_exec("svn cleanup /www/wwwroot/tp5 --username robin --password Robin1992 --no-auth-cache 2>&1");
        echo '<pre>';
        var_dump($output);
    }
}