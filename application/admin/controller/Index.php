<?php
/**
 * @Filename      :index.php
 * @CreateTime    :2018 2018/10/21 16:41
 * @Author       :xzh
 * @Description   :
 */
namespace app\admin\controller;

class Index extends Admin
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
     * @FunctionName    index
     * @CreateTime  2018 2018/10/20 12:15
     * @Author     xzh
     * @Descript    网站首页
     */
    public function index()
    {
        return view('index', '');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
    @FunctionName        welcome
     * @CreateTime  2018 2018/10/21 23:14
     * @Author     xzh
     * @Descript    后台默认首页
     */
    public function welcome()
    {
        $model = model('LoginLog');
        $login_info = $model->login_info();
        if(strpos(PHP_OS, 'WIN') !== false){
            //windows环境
            $system = 'Windows';
            $day = '0';
            $hour = '0';
            $minite = '0';
            $MemTotal = '';
            $MemFree = '';
            $hostname = 'localhost';
        }else{
            //Linux环境
            $system = 'Linux';
            $arRuntime = explode(",", shell_exec('uptime'))?:0;
            $day = explode(' ',$arRuntime[0])[3]?:0;
            $hour = explode(':',$arRuntime[1])[0]?:0;
            $minite = explode(':',$arRuntime[1])[1]?:0;
            $Mem = explode(' ',shell_exec('free'));
            $MemTotal = $Mem[49];
            $MemFree = $Mem[55];
            $hostname = exec('hostname');//计算机名
        }

        $data = array(
            'system' => $system,
            'client' => $_SERVER['REMOTE_ADDR'],//客户端IP
            'server' => isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : ''),//服务器IP地址
            'website' =>  $_SERVER['SERVER_NAME'],//域名
            'port' =>  $_SERVER['SERVER_PORT'],
            'software' =>  $_SERVER['SERVER_SOFTWARE'],//Web服务器软件
            'path' => __FILE__,//脚本路径
            'agent' =>  $_SERVER['HTTP_USER_AGENT'],//操作系统
            'max_time' => ini_get("max_execution_time"),
            'version' => PHP_VERSION,
            'time' => date('Y-m-d H:i:s'),
            'runtime' => $day . '天' . $hour . '小时' . $minite .'分钟',
            'MemTotal' => $MemTotal,
            'MemFree' => $MemFree,
            'hostname' => $hostname
        );
        $data = array_merge($data,$login_info);
        return view('welcome', $data);
    }
}
