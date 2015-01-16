<?php
header('content-type:text/html;charset=utf-8');
// 本类由系统自动生成，仅供测试用途
class IndexAction extends Action {
	public function __construct(){
		parent::__construct();
		$this->class=M('Class');
		$this->brand=M('Brand');
    $this->shop=M('Shop');
    $this->commit=M('Commit');
    $this->user=M('User');
    $this->praise=M('Praise');
    $this->ads=M('Ads');
	}
    public function index(){
     $arr=$this->class->query("select * from class order by id ");
          foreach ($arr as $key => $value) {
            $arr1 = $this -> brand -> query("select b.id,b.name from brand b,class c where c.id = b.class_id and c.id = ".$value["id"]." limit 4");
              $arr[$key]["brand"] = $arr1;
          foreach ($arr[$key]['brand'] as $key2 => $value2) {
            $arr2 = $this -> shop -> query("select s.id sid,s.name sname from brand b,shop s where b.id = s.brand_id and b.id = ".$value2["id"]." limit 2 ");
             $arr[$key]['brand'][$key2]['shop'] = $arr2;
          }
        }
     $this ->assign("all",$arr); 
     $this ->assign("ClassRows",$arr);  
     $this->adsrow=$this->ads->select();
     $this->recentshop=$this->shop->order('time desc')->limit('10')->select();
     $this->praiseshop=$this->shop->order('totpraise desc')->limit('10')->select();
 	   $this->display();
    }
    public function classes(){
      $id=$_GET['id'];
      $arrclass=$this->class->query("select * from class where id='$id'");
      $this -> assign("curclass",$arrclass); 
       $arr=$this->brand->query("select b.id,b.name bname from brand b,class c where 
        b.class_id=c.id and c.id='$id'");
          foreach ($arr as $key => $value) {
            $arr1 = $this -> shop -> query("select s.id sid,s.name sname,s.price sprice,s.img simg,s.totpraise stotpraise from brand b,shop s where b.id = s.brand_id and b.id = ".$value["id"]);
              $arr[$key]["shop"] = $arr1;
        }
      $this -> assign("allbrand",$arr);

      $allclass=$this->class->query("select * from class");
      $this -> assign("ClassRows",$allclass);
      $this->display();
    }

    public function brandes(){
      $id=$_GET['id'];
      $arr = $this -> shop -> query("select s.id sid,s.totpraise as stotpraise,s.name sname,s.price sprice,s.img simg from brand b,shop s where b.id = s.brand_id and b.id ='$id'");
      $this -> assign("allshop",$arr);
      $allclass=$this->class->query("select * from class");
      $this -> assign("ClassRows",$allclass);
      $arrbrand=$this->class->query("select * from brand where id='$id'");
      $this -> assign("curbrand",$arrbrand); 
      $this->display();
    }
    public function login(){
        $allclass=$this->class->query("select * from class");
        $this -> assign("ClassRows",$allclass);
        $this->display();
    }

    public function verify(){
        import('ORG.Util.Image');
        Image::buildImageVerify(5,5,'png',100,30); 
    }

    public function check(){
        $fcode=md5(strtolower($_POST['fcode']));
        $vcode=$_SESSION['verify'];

        if($fcode===$vcode){
            $user=M('User');
            $condition[password]=md5($_POST['password']);
            $condition[username]=$_POST['username'];
            $row=$user->where($condition)->select();
            if($row){
                $_SESSION['user_username']=$_POST['username'];
                $_SESSION['user_userid']=$row[0]['id'];
                $_SESSION['user_login']=1;
                $this->success('登录成功',U('Index/index'));
            }else{
                $this->error('登录失败!',U('login'));
            }
        }else{
            $this->error('验证码错误!',U('login'));
        }

    }

    public function logout(){
        // 1.清空session数组
        $_SESSION=array();
        // 2.删除客户端cookie文件
        setcookie('PHPSESSID','',time()-1,'/');
        // 3.删除服务器session文件
        session_destroy();
        $this->success('退出成功',U('index'));
    }
    public function regist(){
        $allclass=$this->class->query("select * from class");
        $this -> assign("ClassRows",$allclass);      
        $this->display();
    }
    public function insert(){
        $user=D('User');
        $result = $user->create();
        if (!$result){
            // 如果创建失败 表示验证没有通过 输出错误提示信息
             $this->error($user->getError());
           }else{
             // 验证通过 可以进行其他数据操作
            if($user->add()){
            $_SESSION['user_userid']=mysql_insert_id();
            $_SESSION['user_username']=$_POST['username'];
            $_SESSION['user_login']=1;
            $this->success('注册成功',U('index'));
        }else{
            $this->error('添加失败');
        }
      }

    }
    public function shopes(){
      $id=$_GET['id'];
      $arr = $this -> shop -> query("select * from shop where id='$id'");
      $this->assign("shopinfo",$arr);
      import('ORG.Util.Page');
      $tot=$this->commit->table('commit')->join('shop on commit.shop_id=shop.id')->join('user on commit.user_id=user.id')->where("shop.id='$id'")->count();
      $page=new Page($tot,10);
      $this->show=$page->show();
      $this->rows=$this->commit->table('commit')->join('shop on commit.shop_id=shop.id')->join('user on commit.user_id=user.id')->field('commit.id as cid,commit.info as cinfo,commit.time as ctime,user.username as uname')->where("shop.id='$id'")->order('commit.time')->limit($page->firstRow.','.$page->listRows)->select();
      $allclass=$this->class->query("select * from class");
      $this->assign("ClassRows",$allclass);
      $this->display();
    }
    public function addcart(){
      $shoprst=$this->shop->find($_GET['shop_id']);
      $_SESSION['shops'][$_GET['shop_id']]=$shoprst;
      $_SESSION['shops'][$_GET['shop_id']]['num']=1;
      $this->redirect('Cart/index');
    }
     public function totpraise(){
          if($_SESSION['user_userid']){
               $user_id=$_SESSION['user_userid'];
               $shop_id=$_GET['id'];
               $praise_time=$this->praise->query("select time,shop_id from praise where user_id ='$user_id' and shop_id ='$shop_id' order by id desc limit 1");
               if(time()>$praise_time[0]['time']+3||$praise_time[0]['time']==""){
                  //插入数据
                  $time = time();
                  $praiserow=$this->praise->query("insert into praise(shop_id,user_id,time) value('$shop_id','$user_id','$time')");
                  //更新数据
                   $totpraiserow=$this->shop->query("update shop set totpraise= totpraise + 1 where id='$shop_id'");
                   
                  //  //读取跟新以后的数据
                   $totpraise=$this->shop->query("select totpraise from shop where id='$shop_id'");
                   echo $totpraise[0]["totpraise"]."赞";
               }else{
                echo 1;  //如果未超过规定时间，返回1
               }
              
          }else{
              echo 0;   //如果未登录，返回0
         }
    }

    public function search(){
      $allclass=$this->class->query("select * from class");
      $this -> assign("ClassRows",$allclass);
      $name=$_POST['search'];
      $sql="select * from shop where name like '%$name%'";
      $this->rst=$this->shop->query($sql);
      if($this->rst){
        $this->display();
      }else{
         $this->error('对不起，暂无此商品！');
      }
    }
}