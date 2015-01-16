<?php
// 本类由系统自动生成，仅供测试用途
class BrandAction extends AllowAction {
    public function __construct(){
        parent::__construct();
        $this->brand=M('Brand');
    }

    public function index(){
        $sql="select brand.*,class.name cname from brand,class where brand.class_id=class.id order by brand.id";
        $this->rows=$this->brand->query($sql);
        $this->display();
    }

    public function delete(){
        $id=$_GET['id'];
        if($this->brand->delete($id)){
            $this->redirect('Brand/index');
        }
    }

    public function edit(){
        $class=M('Class');
        $this->classes=$class->order('id')->select();
        
        $this->row=$this->brand->find($_GET['id']);
        $this->display();
    }

    public function update(){
        $this->brand->create();
        if($this->brand->save()){
            $this->success('修改成功',U('index'));
        }else{
            $this->error('修改失败',U('index'));
        }
    }

    public function add(){
        $class=M('Class');
        $this->classes=$class->order('id')->select();
        $this->display();
    }

    public function insert(){
        $this->brand->create();
        if($this->brand->add()){
            $this->success('添加成功',U('index'));
        }

    }
}