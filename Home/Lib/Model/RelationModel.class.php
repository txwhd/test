<?php 
class RelationModel extends Model{
	// protected $_map=array(
	// 	'name'=>'username',
	// 	'pass'=>'password',
	// );

	protected $_validate=array(
		array('name','require','用户名不能为空!',1,'',3),
	//	array('password','6,50','密码至少6位!',1,'length',3),
	//    array('repassword','password','确认密码不正确',0,'confirm'), // 验证确认密码是否和密码一致
	    array('email','email','邮箱格式不对!',1,'',3),
	    array('tel','/^\d{11}$/','手机格式不对!',1,'regex',3),
	);

	// protected $patchValidate=true;
}
?>