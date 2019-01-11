<?php
/**
 * @Filename: Category.php
 * @Author: 肖子恒
 * @Date: 2018/12/24
 * @Time:10:39
 */
namespace app\admin\controller;

class Category extends Admin
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @Function ajax_list 分类列表页数据
     * @Author: 肖子恒
     * @Date: 2018/12/24
     * @Time: 17:03
     * @Return: void
     */
    public function ajax_list()
    {
        $model = model('Category');
        $arr = $model->show_list();
        $list = array();
        foreach($arr as $k => $v){
            $list[$k]['id'] = $v['id'];
            $list[$k]['pId'] = $v['p_id'];
            $list[$k]['name'] = $v['category'];
        }
        echo json_encode($list);
    }

    /**
     * @Function index 分类管理页
     * @Author: 肖子恒
     * @Date: 2018/12/24
     * @Time: 17:04
     * @Return: \think\response\View
     */
    public function index()
    {
        return view('product-category');
    }

    /**
     * @Function add 新增分类
     * @Author: 肖子恒
     * @Date: 2018/12/24
     * @Time: 17:04
     * @Return: \think\response\View
     */
    public function add()
    {
        $admin_id = session('admin_id','','admin');
        $model = model('Category');
        $arr = $model->show_list();
        return view('product-category-add',['admin_id' => $admin_id,'arr' => $arr]);
    }

    /**
     * @Function add_do 添加分类
     * @Author: 肖子恒
     * @Date: 2018/12/24
     * @Time: 17:03
     * @Return: void
     */
    public function add_do()
    {
        $category = input('post.category','');
        if(empty($category)){
            echo json_encode(['code' => 500,'msg' => '分类名称不能为空!']);
            exit;
        }
        $result = model('Category')->add_category();
        if($result){
            echo json_encode(['code' => 200,'msg' => '添加成功!']);
            exit;
        }else{
            echo json_encode(['code' => 500,'msg' => '系统错误!']);
            exit;
        }
    }
}