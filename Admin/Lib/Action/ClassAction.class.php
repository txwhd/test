<?php
// 本类由系统自动生成，仅供测试用途
class ClassAction extends AllowAction {
	public function __construct(){
		parent::__construct();
		$this->class=M('Class');
	}

    public function index(){
    	$this->rows=$this->class->order('id')->select();
    	$this->display();
    }

    public function delete(){
    	$id=$_GET['id'];
    	if($this->class->delete($id)){
    		$this->redirect('Class/index');
    	}
    }

    public function edit(){
    	$this->row=$this->class->find($_GET['id']);
    	$this->display();
    }

    public function update(){
    	$this->class->create();
    	if($this->class->save()){
    		$this->success('修改成功',U('index'));
    	}else{
    		$this->error('修改失败',U('index'));
    	}
    }

    public function add(){
    	$this->display();
    }

    public function insert(){
    	$this->class->create();
    	if($this->class->add()){
    		$this->success('添加成功',U('index'));
    	}

    }
}