<?php 
class ShopModel extends Model{


	// protected $_map=array(
	// 	'name'=>'username',
	// 	'pass'=>'password',
	// );

	protected $_validate=array(
		array('info','require','商品描述不能为空!',1,'',3),
		array('name','require','商品名字不能为空!',1,'',3),
		array('price','require','商品价格不能为空!',1,'',3),
		array('stock','require','商品库存不能为空!',1,'',3),
		array('img','require','商品图片不能为空!',1,'',3),
		array('shelf','require','商品上下架不能为空!',1,'',3),
	    array('brand_id','require','商品品牌不能为空!',1,'',3),
	);

	// protected $patchValidate=true;
}
?>