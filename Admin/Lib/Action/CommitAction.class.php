<?php
// 本类由系统自动生成，仅供测试用途
class CommitAction extends AllowAction {
    public function __construct(){
        parent::__construct();
        $this->commit=M('Commit');
    }

    public function index(){
        import('ORG.Util.Page');
        $tot=$this->commit->count();
        $page=new Page($tot,8);
        $this->show=$page->show();
        $this->rows= $this->commit->table('commit')->join('user on commit.user_id=user.id')->join('shop on commit.shop_id=shop.id')->
        field('commit.*,user.username as uname,shop.name as sname')->order('commit.id')->limit($page->firstRow.','.$page->listRows)->select();
        $this->display();
    }

    public function delete(){
        $id=$_GET['id'];
        if($this->commit->delete($id)){
            $this->redirect('Commit/index');
        }
    }
}