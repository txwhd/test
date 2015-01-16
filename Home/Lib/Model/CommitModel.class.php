<?php 
class CommitModel extends Model{
	protected $_auto=array(
		array('time','time',1,'function'),
	);

	// protected $_map=array(
	// 	'name'=>'username',
	// 	'pass'=>'password',
	// );

	protected $_validate=array(
		array('info','require','留言不能为空!',1,'',3),
		array('info','6,100','留言内容至少6个字!',1,'length',3),
	);

	// protected $patchValidate=true;
}
?>