<?php
// 本类由系统自动生成，仅供测试用途
class ShopAction extends Action {
	public function __construct(){
		parent::__construct();
		$this->shop=M('shop');
    $this->user=M('user');
	}

    public function index(){
        $user_id=$_SESSION['user_userid'];
        import('ORG.Util.Page');
        $tot=$this->shop->where("user_in_id='$user_id'")->count();
        $page=new Page($tot,4);
        $this->show=$page->show();
        $this->rows = $this->shop->table('shop')->join('brand on shop.brand_id=brand.id')->field('shop.*,brand.name as bname')->where("user_in_id='$user_id'")->order('shop.id')->limit($page->firstRow.','.$page->listRows)->select();
       // echo $this->shop->getlastSql();
        $this->display();
   }

    public function delete(){
    	  $id=$_GET['id'];
        $sql="select img from shop where id=$id";
        $rows=$this->shop->query($sql);
        if($this->shop->delete($id)){
        unlink('./Public/uploads/'.$rows[0]['img']);
        unlink('./Public/uploads/thumb_'.$rows[0]['img']);
          $this->redirect('Shop/index');
      }
    }

    public function edit(){
    	$this->row=$this->shop->find($_GET['id']);
    	$this->display();
    }

    public function update(){
        $id=$_POST['id'];
        $name=$_POST['name'];
        $price=$_POST['price'];
        $stock=$_POST['stock'];
        $shelf=$_POST['shelf'];
        $brand_id=$_POST['brand_id'];
        $sql="select img from shop where id=$id";
        $row=$this->shop->query($sql);
        $oldimg=$row[0]['img'];

        import('ORG.Net.UploadFile');
        $upload = new UploadFile();
        $upload = new UploadFile();// 实例化上传类
        $upload->maxSize  = 3145728 ;// 设置附件上传大小
        $upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->thumb = true;
        $upload->thumbMaxWidth = '200';
        $upload->thumbMaxHeight = '200';
        $upload->savePath = './Public/uploads/';
        if($upload->upload()){
            $info=$upload->getUploadFileInfo();
            $img=$info[0]['savename'];
            $sql="update shop set name='{$name}',price='{$price}',stock='{$stock}',shelf='{$shelf}',brand_id='{$brand_id}',img='{$img}' where id={$id}";
           if($this->shop->execute($sql)){
            unlink('./Public/uploads/thumb_'.$oldimg);
            unlink('./Public/uploads/'.$oldimg);
            $this->success('修改成功',U('index'));
            }else{
            $this->error('修改失败',U('index'));
            }
        }else{
           $sql="update shop set name='{$name}',price='{$price}',stock='{$stock}',shelf='{$shelf}',brand_id='{$brand_id}' where id={$id}";
           if($this->shop->execute($sql)){
                 $this->success('修改成功',U('index'));
           }else{
                 $this->error('修改失败',U('index'));
           }
        }
    }
    public function add(){
        $id=$_SESSION['user_userid'];
        $flag=$this->user->where("id='$id'")->find();
        if(($flag['flag'])==0){
           $this->error('请等待审核后再发布商品',U('index'));
        }
        // echo "<pre>";
        // print_r($flag);
        // echo "</pre>";
        // exit;
    	  $this->display();
    }

    public function insert(){
        import('ORG.Net.UploadFile');
        $upload = new UploadFile();
        $upload = new UploadFile();// 实例化上传类
        $upload->maxSize  = 3145728 ;// 设置附件上传大小
        $upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->thumb = true;
        $upload->thumbMaxWidth = '200';
        $upload->thumbMaxHeight = '200';
        $upload->savePath = './Public/uploads/';
        if($upload->upload()){
            $info=$upload->getUploadFileInfo();
             $img=$info[0]['savename'];
              $name=$_POST['name'];
              $price=$_POST['price'];
              $stock=$_POST['stock'];
              $shelf=$_POST['shelf'];
              $brand_id=$_POST['brand_id'];    
              $time=time();    
              $info=$_POST['info'];
              $user_id=$_SESSION['user_userid'];   
              $totpraise=0;    
              $sql="insert into shop(name,price,stock,shelf,brand_id,img,time,info,user_in_id,totpraise) values('{$name}','{$price}','{$stock}','{$shelf}','{$brand_id}','$img','$time','$info','$user_id','$totpraise')";
           if($this->shop->execute($sql)){
            $this->success('添加成功',U('index'));
            }
        }else{
            $this->error($upload->getErrorMsg());
        }
    	
    }
}