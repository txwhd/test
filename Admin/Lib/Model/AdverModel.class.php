<?php 
class AdverModel extends Model{
	protected $_auto=array(
	//	array('time','time',1,'function'),
	//	array('password','md5',1,'function') , // 对password字段在新增的时候使md5函数处理

	);

	// protected $_map=array(
	// 	'name'=>'username',
	// 	'pass'=>'password',
	// );

	protected $_validate=array(
		array('info','6,50','标题内容在6到50字之间!',1,'length',3),
	);

	// protected $patchValidate=true;
}
?>