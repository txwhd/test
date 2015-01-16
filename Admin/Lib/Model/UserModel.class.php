<?php 
class UserModel extends Model{
	protected $_auto=array(
		array('time','time',1,'function'),
	//	array('password','md5',1,'function') , // 对password字段在新增的时候使md5函数处理

	);

	// protected $_map=array(
	// 	'name'=>'username',
	// 	'pass'=>'password',
	// );

	protected $_validate=array(
		array('username','require','用户名不能为空!',1,'',3),
		//array('password','6,50','密码至少6位!',1,'length',3),
	    //array('repassword','password','确认密码不正确',0,'confirm'), // 验证确认密码是否和密码一致
		// array('email','email','邮箱格式不对!',1,'',3),
		// array('tel','/^\d{11}$/','手机格式不对!',1,'regex',3),
		// array('url','url','网址不对!',1,'',3),
	);

	// protected $patchValidate=true;
}
?>