<?php
/**
 * @Filename: Category.php
 * @Author: 肖子恒
 * @Date: 2018/12/24
 * @Time:11:12
 */
namespace app\admin\model;
use think\Db;
use think\Model;

class Category extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @Function show_list 无限级分类列表
     * @param int $p_id
     * @return array
     * @Author: 肖子恒
     * @Date: 2018/12/24
     * @Time: 14:14
     * @Return: array
     */
    public function show_list($p_id=0)
    {
        static $category = array();
        static $index = 0;
        $data = Db::name('category')->query('select id,category,lev,p_id from blog_category where is_del = 0 and p_id = '.$p_id);
        foreach($data as $v){
            $category[$index] = $v;
            $res = Db::name('category')->query('select id,category,lev,p_id from blog_category where is_del = 0 and p_id = '.$v['id']);
            $index++;
            if($res){
                $category[$index] = $this->show_list($v['id']);
            }
        }
        return $category;
    }

    /**
     * @Function add_category 添加分类
     * @return int|string
     * @Author: 肖子恒
     * @Date: 2018/12/24
     * @Time: 17:04
     * @Return: int|string
     */
    public function add_category()
    {
        $category = input('post.category','');
        $p_id = input('post.p_id',0);
        $descript = input('post.descript','');
        $admin_id = session('admin_id','','admin');
        $res = Db::name('category')->find($p_id);
        $res?$lev = $res['lev']+1:$lev = 0;
        $result = Db::name('category')->insert(['category' => $category,'p_id' => $p_id,'lev' => $lev,'descript' => $descript,'dtime' => date('Y-m-d H:i:s'),'time' => time(),'admin_id' => $admin_id]);
        return $result;
    }
}