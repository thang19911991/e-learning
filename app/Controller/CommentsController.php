<?php
class CommentsController extends AppController{
	
	// ユーザのコメントを削除
	public function delete_comment(){
		$this->autoRender = false;
		
		$comment_id = $_POST['comment_id'];
		
		if($comment_id){
			$this->loadModel('Comment');
			
			try{
				$this->Comment->delete($comment_id);
			}catch (Exception $e){
				return new CakeResponse(array('body' => "not_ok"));
			}
			return new CakeResponse(array('body' => "ok"));
		}else{
			return new CakeResponse(array('body' => "not_ok"));
		}
	}
}