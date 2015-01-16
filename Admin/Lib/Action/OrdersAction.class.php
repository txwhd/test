<?php
// 本类由系统自动生成，仅供测试用途
class OrdersAction extends AllowAction {
    public function __construct(){
        parent::__construct();
        $this->orders=M('Orders');
    }

    public function index(){
        import('ORG.Util.Page');
        $tot=$this->orders->group('orders.code')->count();
        // echo $this->orders->getLastSql();
        // exit;
        $page=new Page($tot,8);
        $this->show=$page->show();
        $this->rows= $this->orders->table('orders')
        ->join('user on orders.user_id=user.id')
        ->join('status on orders.status_id=status.id')
        ->field('orders.*,user.username as uname,status.name as tname')
        ->order('orders.id')
        ->group('orders.code')
        ->limit($page->firstRow.','.$page->listRows)->select();
        $this->display();
    }

    public function delete(){
        $id=$_GET['id'];
        if($this->orders->delete($id)){
            $this->redirect('Orders/index');
        }
    }
    public function code(){
        $code=$_GET['code'];  
        $this->rows= $this->orders->table('orders')
        ->join('shop on orders.shop_id=shop.id')
        ->field('shop.name as sname,shop.img as simg,orders.*')->where("orders.code='$code'")
        ->order('orders.id')->select();
        $this->display();
    }
    public function relation(){
        $rid=$_GET['relation_id'];  
        $this->rows= $this->orders->table('orders')
        ->join('relation on orders.relation_id=relation.id')
        ->field('relation.*')->where("orders.relation_id='$rid'")
        ->group('relation.id')
        ->select();
        $this->display();
    }
    public function edit(){
        $status=M('Status');
        $this->statuses=$status->order('id')->select();
        $this->row=$this->orders->find($_GET['id']);
        $this->display();
    }
    public function update(){
      $code=$_POST['code'];
      $status_id=$_POST['status_id'];
     $sql="update orders set status_id='{$status_id}' where code={$code}";
        if($this->orders->execute($sql)){
            $this->success('修改成功',U('index'));
        }else{
            $this->error('修改失败',U('index'));
        }
    }
}