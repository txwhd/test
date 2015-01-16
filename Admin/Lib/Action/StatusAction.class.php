<?php
// 本类由系统自动生成，仅供测试用途
class StatusAction extends AllowAction {
	public function __construct(){
		parent::__construct();
		$this->status=M('Status');
	}

    public function index(){
    	$this->rows=$this->status->order('id')->select();
    	$this->display();
    }

    public function delete(){
    	$id=$_GET['id'];
    	if($this->status->delete($id)){
    		$this->redirect('Status/index');
    	}
    }

    public function edit(){
    	$this->row=$this->status->find($_GET['id']);
    	$this->display();
    }

    public function update(){
    	$this->status->create();
    	if($this->status->save()){
    		$this->success('修改成功',U('index'));
    	}else{
    		$this->error('修改失败',U('index'));
    	}
    }

    public function add(){
    	$this->display();
    }

    public function insert(){
    	$this->status->create();
    	if($this->status->add()){
    		$this->success('添加成功',U('index'));
    	}

    }
}