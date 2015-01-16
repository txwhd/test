<?php
// 本类由系统自动生成，仅供测试用途
class UserAction extends Action {
	public function __construct(){
		parent::__construct();
		$this->user=M('User');
	}

    public function edit(){
        $id=$_SESSION['user_userid'];
    	$this->row=$this->user->find($id);
    	$this->display();
    }

    public function update(){
        $password=md5($_POST['password']);
        $username=$_POST['username'];
        $sql="update user set password='$password' where username='$username'";
    	     // echo "<pre>";
          //    print_r($sql);
          //    echo "</pre>";
          //    exit;
        if($this->user->execute($sql)){
            // 1.清空session数组
            $_SESSION=array();
            // 2.删除客户端cookie文件
            setcookie('PHPSESSID','',time()-1,'/');
            // 3.删除服务器session文件
            session_destroy();
            $this->success('修改成功，请重新登录！');

    	}else{
    		$this->error('修改失败',U('index'));
    	}
    }
}