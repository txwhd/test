<?php 

class AllowAction extends Action{
	function _initialize(){
		if(!$_SESSION['user_login']){
			$this->error('请您先登录或者注册！',U('Index/login'));	
			exit;
		}
	}
}

 ?>