<?php
// 本类由系统自动生成，仅供测试用途
class RelationAction extends Action {
	public function __construct(){
		parent::__construct();
		$this->user=M('User');
        $this->relation=M('Relation');
	}

    public function index(){
        $username=$_SESSION['user_username'];
        $id=$this->user->query("select id from user where username='$username'");
        import('ORG.Util.Page');
        $condition->user_id=$id[0]["id"];
        $tot=$this->relation->where($condition)->count();
        $page=new Page($tot,8);
        $this->show=$page->show();
        $this->rows=$this->relation->where($condition)->order('id')->limit($page->firstRow.','.$page->listRows)->select();
        $this->display();
    }

    public function delete(){
    	$id=$_GET['id'];
    	if($this->relation->delete($id)){
    		$this->redirect('Relation/index');
    	}
    }

    public function edit(){
    	$this->row=$this->relation->find($_GET['id']);
    	$this->display();
    }

    public function update(){
        $relation=D('Relation');
        $id=$_POST['id'];
    	$result=$relation->create();
        if(!$result){
            $this->error($relation->getError());
        }else{
          $data['name'] =$_POST['name'];
          $data['tel'] =$_POST['tel'];
          $data['addr'] =$_POST['addr'];
          $data['email'] =$_POST['email'];
    	 if($this->relation->where("id='$id'")->data($data)->save()){
    		$this->success('修改成功',U('index'));
    	    }else{
    		$this->error('修改失败',U('index'));
    	}
     }
    }

    public function add(){
    	$this->display();
    }

    public function insert(){
        $username=$_SESSION['user_username'];
        $id=$this->user->query("select id from user where username='$username'");
        $relation=D("Relation");
        $data['name'] = $_POST['name'];
        $data['addr'] = $_POST['addr'];
        $data['tel'] = $_POST['tel'];
        $data['email'] = $_POST['email'];
        $data['user_id'] =$id[0]["id"];
        $result = $relation->create();
        if (!$result){
            // 如果创建失败 表示验证没有通过 输出错误提示信息
             $this->error($relation->getError());
           }else{
             // 验证通过 可以进行其他数据操作
            if($relation->add($data)){
            $this->success('添加成功',U('index'));
        }else{
            $this->error('添加失败');
        }
      }

    }
}