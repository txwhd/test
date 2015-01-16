<?php 

class AllowAction extends Action{
	function _initialize(){
		if(!$_SESSION['admin_login']){
			$this->error('无权登录',U('Login/index'));	
			exit;
		}
	}
}

 ?>