<?php
// 本类由系统自动生成，仅供测试用途
class OrdersAction extends Action {
	public function __construct(){
		parent::__construct();
		$this->user=M('User');
        $this->relation=M('Relation');
        $this->orders=M('Orders');
        $this->shop=M('Shop');
	}

    public function index(){
        $userid=$_SESSION['user_userid'];
        $tot=$this->orders
        ->table('orders')->join('user on orders.user_id=user.id')->where("user.id='$userid'")
        ->count();
        import('ORG.Util.Page');
        $page=new Page($tot,8);
        $this->show=$page->show(); 
        $this->rows=$this->orders->table('orders')
        ->join('status on orders.status_id=status.id')
        ->field('orders.id oid,orders.time as otime,orders.code as ocode, status.name as sname')
        ->where("user_id='$userid'")
        ->order('time')
        ->limit($page->firstRow.','.$page->listRows)
        ->select();
        // echo "<pre>";
        // print_r($this->rows);
        // echo "</pre>";
        $this->display();
    }

    public function orderinfo(){
        $id=$_GET['id'];
        $this->rows= $this->orders->table('orders')->join('shop on orders.shop_id=shop.id')->
        field('orders.num as onum,orders.price as oprice,shop.id as shop_id,shop.name as sname,shop.img as simg')->where("orders.id='$id'")->order('shop.id')->select();
        $this->display();
    }
    public function edit(){
        $status=M('Status');
        $this->statuses=$status->order('id')->select();
        $this->row=$this->orders->find($_GET['id']);
        $this->display();
    }
    public function update(){
      $id=$_POST['id'];
      $status_id=$_POST['status_id'];
     $sql="update orders set status_id='{$status_id}' where id={$id}";
        if($this->orders->execute($sql)){
            $this->success('修改成功',U('sendorders'));
        }else{
            $this->error('修改失败',U('sendorders'));
        }
    }
    public function relation(){
        $order_code=$_GET['id'];  
        $this->rows= $this->orders->table('orders')
        ->join('relation on orders.relation_id=relation.id')
        ->field('relation.*')->where("orders.code='$order_code'")
        ->group('relation.id')
        ->select();
        $this->display();
    }
    public function sendorders(){
        $user_in_id=$_SESSION['user_userid'];
        $tot=$this->orders
        ->table('orders')->join('shop on orders.shop_id=shop.id')->where("shop.user_in_id='$user_in_id'")
        ->count();
        import('ORG.Util.Page');
        $page=new Page($tot,8);
        $this->show=$page->show(); 
        $this->rows=$this->orders->table('orders')
        ->join('status on orders.status_id=status.id')
        ->join('shop on orders.shop_id=shop.id')
        ->field('orders.id as oid,orders.time as otime,orders.code as ocode, status.name as sname')
        ->where("shop.user_in_id='$user_in_id'")
        ->order('orders.time')
        ->limit($page->firstRow.','.$page->listRows)
        ->select();
        $this->display();
    }
    public function sendcode(){
        $id=$_GET['id'];
        $this->rows= $this->shop->table('shop')->join('orders on orders.shop_id=shop.id')->
        field('orders.num as onum,orders.price as oprice,shop.id as shop_id,shop.name as sname,shop.img as simg')
        ->where("orders.id='$id'")->order('shop.id')->select();
        $this->display();
    }
    public function sendrelation(){
        $order_code=$_GET['id'];  
        $this->rows= $this->orders->table('orders')
        ->join('relation on orders.relation_id=relation.id')
        ->field('relation.*')->where("orders.code='$order_code'")
        ->group('relation.id')
        ->select();
        $this->display();
    }
}