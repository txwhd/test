<?php
// 本类由系统自动生成，仅供测试用途
class CommitAction extends Action {
	public function __construct(){
		parent::__construct();
		$this->user=M('User');
        $this->commit=M('Commit');
	}

    public function index(){
        $user_id=$_SESSION['user_userid'];
        import('ORG.Util.Page');
        $tot=$this->commit->table('commit')->join('shop on commit.shop_id=shop.id')->join('user on commit.user_id=user.id')->where("user.id='$user_id'")->count();
        $page=new Page($tot,4);
        $this->show=$page->show();
        $this->rows=$this->commit->table('commit')->join('shop on commit.shop_id=shop.id')->join('user on commit.user_id=user.id')->field('shop.name as sname,shop.img as simg,shop.price as sprice,commit.id as cid,commit.info as cinfo,commit.time as ctime')->where("user.id='$user_id'")->order('commit.time')->limit($page->firstRow.','.$page->listRows)->select();
        $this->display();
    }

    public function delete(){
    	$id=$_GET['id'];

    	if($this->commit->delete($id)){
    		$this->redirect('Commit/index');
    	}
    }

    public function edit(){
    	$this->row=$this->commit->find($_GET['id']);
    	$this->display();
    }

    public function update(){
        $commit=D('Commit');
        $id=$_POST['id'];
    	$result=$commit->create();
        if(!$result){
            $this->error($commit->getError());
        }else{
          $data['info'] =$_POST['info'];
          $data['time'] = time();
    	 if($this->commit->where("id='$id'")->data($data)->save()){
    		$this->success('修改成功',U('index'));
    	    }else{
    		$this->error('修改失败',U('index'));
    	}
     }
    }

    public function add(){
        $this->img=$_GET['img'];
        $this->shop_id=$_GET['id'];
        $this->name=$_GET['name'];
        $this->price=$_GET['price'];
    	$this->display();
    }

    public function insert(){
        $commit=D('Commit');
        $user_id=$_SESSION['user_userid'];
        $shop_id=$_POST['shop_id'];
        $data['user_id'] = $user_id;
        $data['shop_id'] = $shop_id;
        $data['info'] = $_POST['info'];
        $data['time'] = time();
        $result = $commit->create();
        if (!$result){
            // 如果创建失败 表示验证没有通过 输出错误提示信息
             $this->error($commit->getError());
           }else{
             // 验证通过 可以进行其他数据操作
            if($commit->add($data)){

            $this->success('添加成功',U('index'));
        }else{
            $this->error('添加失败');
        }
      }

    }
}