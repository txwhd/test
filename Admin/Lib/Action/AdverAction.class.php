<?php
// 本类由系统自动生成，仅供测试用途
class AdverAction extends AllowAction {
	public function __construct(){
		parent::__construct();
		$this->adver=M('Ads');
	}

    public function index(){
    	$this->rows=$this->adver->order('id')->select();
    	$this->display();
    }

    public function delete(){
    	$id=$_GET['id'];
        $sql="select img from ads where id=$id";
        $rows=$this->adver->query($sql);
        if($this->adver->delete($id)){
        unlink('./Public/uploads/'.$rows[0]['img']);
        unlink('./Public/uploads/thumb_'.$rows[0]['img']);
          $this->redirect('Adver/index');
      }
    }

    public function edit(){
    	$this->row=$this->adver->find($_GET['id']);
    	$this->display();
    }

    public function update(){
        $id=$_POST['id'];
        $info=$_POST['info'];
        $sql="select img from ads where id=$id";
        $row=$this->adver->query($sql);
        $oldimg=$row[0]['img'];

        import('ORG.Net.UploadFile');
        $upload = new UploadFile();
        $upload = new UploadFile();// 实例化上传类
        $upload->maxSize  = 3145728 ;// 设置附件上传大小
        $upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->thumb = true;
        $upload->thumbMaxWidth = '1366';
        $upload->thumbMaxHeight = '400';
        $upload->savePath = './Public/uploads/';
        if($upload->upload()){
            $info=$upload->getUploadFileInfo();
            $img=$info[0]['savename'];
            $sql="update ads set img='$img',info='$info' where id='$id'";
           if($this->adver->execute($sql)){
            unlink('./Public/uploads/thumb_'.$oldimg);
            unlink('./Public/uploads/'.$oldimg);
            $this->success('修改成功',U('index'));
            }else{
            $this->error('修改失败',U('index'));
            }
        }else{
           $sql="update ads set info='$info' where id='$id'";
           if($this->adver->execute($sql)){
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
        import('ORG.Net.UploadFile');
        $upload = new UploadFile();
        $upload = new UploadFile();// 实例化上传类
        $upload->maxSize  = 3145728 ;// 设置附件上传大小
        $upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->thumb = true;
        $upload->thumbMaxWidth = '1366';
        $upload->thumbMaxHeight = '400';
        $upload->savePath = './Public/uploads/';
        if($upload->upload()){
            $info=$upload->getUploadFileInfo();
              // echo '<pre>';
              // print_r($info);
              // echo '</pre>';
              // echo $info[0]['savename'];
              // exit;
             $img=$info[0]['savename'];
             $info=$_POST['info'];
             $sql="insert into ads (img,info) values('$img','$info')";
           if($this->adver->execute($sql)){
            $this->success('添加成功',U('index'));
            }
        }else{
            $this->error($upload->getErrorMsg());
        }
    	
    }
}