<?php
header('content-type:text/html;charset=utf-8');
// 本类由系统自动生成，仅供测试用途
class CartAction extends Action {
	public function __construct(){
		parent::__construct();
    $this->shop=M('Shop');
    $this->class=M('Class');
    $this->user=M('User');
    $this->relation=M('Relation');
	}
    public function index(){     
      $allclass=$this->class->query("select * from class");
      $this -> assign("ClassRows",$allclass);
      $username=$_SESSION['user_username'];
      $id=$this->user->query("select id from user where username='$username'");
      $condition->user_id=$id[0]["id"];
      $this->rows=$this->relation->where($condition)->select();
 	  $this->display();
    }
    public function dec(){
       $shop_id=$_GET['shop_id'];
       if($_SESSION['shops'][$shop_id]['num']<=1){
	     $_SESSION['shops'][$shop_id]['num']=1;
        }else{
	      $_SESSION['shops'][$shop_id]['num']--;
         }
        $this->redirect('Cart/index');
    }
    public function inc(){
       $shop_id=$_GET['shop_id'];
       if($_SESSION['shops'][$shop_id]['num']>=$_SESSION['shops'][$shop_id]['stock']){
	    $_SESSION['shops'][$shop_id]['num']=$_SESSION['shops'][$shop_id]['stock'];
         }else{
	    $_SESSION['shops'][$shop_id]['num']++;
         }
        $this->redirect('Cart/index');
     }
    public function delete(){
         $shop_id=$_GET['shop_id'];
         unset($_SESSION['shops'][$shop_id]);
         $this->redirect('Cart/index');     
    }
    public function clear(){
       unset($_SESSION['shops']);
       $this->redirect('Cart/index');
    }
    public function insert(){
        $orders=M('Orders');
        $relation_id=$_POST['relation_id'];
        $status_id=1;
        $user_id=$_SESSION['user_userid'];
        $time=time();
        $code=time().mt_rand();
        if(!$relation_id || !$_SESSION['shops']){
          $this->error('您是否选择了商品或收货地址'); 
          exit;
        }
        foreach($_SESSION['shops'] as $shop){
        $shop_id=$shop['id'];
        $price=$shop['price'];
        $num=$shop['num'];
        $sqlnum="update shop set stock=stock-'$num' where id='$shop_id'";
        $this->shop->execute($sqlnum);      
        $sql="insert into orders(code,user_id,shop_id,price,num,time,relation_id,status_id) values('{$code}','{$user_id}','{$shop_id}','{$price}','{$num}','{$time}','{$relation_id}','{$status_id}')"; 
        $orders->execute($sql);
       }
       unset($_SESSION['shops']);
       $this->success('请记住您的订单号'.$code,U("Person/index"));
    }
}