<?php
// 本类由系统自动生成，仅供测试用途
class UserAction extends AllowAction {
	public function __construct(){
		parent::__construct();
		$this->user=M('User');
		
	}

    public function index(){
        import('ORG.Util.Page');
        $tot=$this->user->count();
        $page=new Page($tot,8);
        $this->show=$page->show();
        $this->rows=$this->user->order('id')->limit($page->firstRow.','.$page->listRows)->select();
    	$this->display();
    }

    public function delete(){
    	$id=$_GET['id'];
    	if($this->user->delete($id)){
    		$this->redirect('User/index');
    	}
    }

    public function edit(){
    	$this->row=$this->user->find($_GET['id']);
    	$this->display();
    }

    public function update(){
        $user=D('User');
    	$result=$user->create();
        if(!$result){
            $this->error($user->getError());
        }else{
            //$password=md5($_POST['password']);
            $username=$_POST['username'];
            $flag=$_POST['flag'];
            $sql="update user set flag='$flag' where username='$username'";
    	     // echo "<pre>";
          //    print_r($sql);
          //    echo "</pre>";
          //    exit;
        if($user->execute($sql)){
    		$this->success('修改成功',U('index'));
    	}else{
    		$this->error('修改失败',U('index'));
    	}
     }
    }
    
    public function uploadFile(){
        $tmp_file = $_FILES ['file_stu'] ['tmp_name'];
    	$file_types = explode ( ".", $_FILES ['file_stu'] ['name'] );
    	$file_type = $file_types [count ( $file_types ) - 1];
    	
    	/*判别是不是.xls文件，判别是不是excel文件*/
    	if (strtolower ( $file_type ) != "xlsx" && strtolower ( $file_type ) != "xls")
    	{
    		$this->error ( '不是Excel文件，重新上传' );
    	}
    	
    	/*设置上传路径*/
    	$savePath = 'Public/uploads/';
    	
    	/*以时间来命名上传的文件*/
    	$str = date ( 'Ymdhis' );
    	$file_name = $str . "." . $file_type;
    	
    	
    	/*是否上传成功*/
    	if (! copy ( $tmp_file, $savePath . $file_name ))
    	{
    		$this->error ( '上传失败' );
    	}
    	$filetmpname = $savePath . $file_name;
    	Vendor('Classes.PHPExcel');
    	$objPHPExcel = PHPExcel_IOFactory::load($filetmpname);
    	$arrExcel = $objPHPExcel->getSheet(0)->toArray();
        //删除不要的表头部分，我的有三行不要的，删除三次
    	/* if($arrExcel[0][0]!='学号' || $arrExcel[0][1]!='姓名' || $arrExcel[0][2]!='密码' || $arrExcel[0][3]!='时间' || $arrExcel[0][4]!='电话'|| $arrExcel[0][5]!='邮箱'||$arrExcel[0][6]!='交易'){
    		$this->error('导入文件格式错误，请参照图例');
    	} */
    	
    	array_shift($arrExcel);
    	/*array_shift($arrExcel);
    	array_shift($arrExcel);现在可以打印下$arrExcel，就是你想要的数组啦 */
        //查询数据库的字段
        $m = M('User');
    	$fieldarr = $m->query("describe user");
    	foreach($fieldarr as $v){
    		$field[] = $v['Field'];
    	}
    	//删除自动增长的ID  array_shift($field);
    	//循环给数据字段赋值
    	foreach($arrExcel as $v){
    		$fields[] = array_combine($field,$v);//将excel的一行数据赋值给表的字段
    	}
    	//批量插入
    	
    	// $ids = $m->addAll($fields);
    	if($m->addAll($fields)){
    		$this->success('添加成功');
    	}
    	else
    		$this->error("没有添加数据");
    	
    	 
    	
    	}
    
    
    
    public function add(){
    	$this->display();
    }

    public function insert(){
        $user=D('User');
        $result = $user->create();
        if (!$result){
            // 如果创建失败 表示验证没有通过 输出错误提示信息
             $this->error($user->getError());
           }else{
             // 验证通过 可以进行其他数据操作
            if($user->add()){
            $this->success('添加成功',U('index'));
        }else{
            $this->error('添加失败');
        }
      }

    }
}