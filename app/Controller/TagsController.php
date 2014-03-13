<?php
class TagsController extends AppController{
	
	// 	tagをsuggestするために、autocompleteを使用
	public function key(){
	    $this->autoRender = false;
	    $this->loadModel("Tag");
	    
	    $keyword = $this->params['url']['term'];
	    
	    $codes = $this->Tag->find('all', array('conditions' => array('tag_name LIKE' => "%".$keyword."%")));	    
	    return new CakeResponse(array('body' => json_encode($codes)));
	}
	
	// タグを編集
	public function edit_tag(){
		$this->autoRender = false;
		$tag_id = $_POST['tag_id'];
		$content = $_POST['content'];
		
		if($tag_id && $content){
			$this->loadModel('Tag');
			
			try{
				// タグを編集
				$this->Tag->id = $tag_id;
				$this->Tag->saveField('tag_name', $content);
				return new CakeResponse(array('body' => "ok"));
			}catch (Exception $e){
				return new CakeResponse(array('body' => "not_ok"));
			}
		}else{
			return new CakeResponse(array('body' => "not_ok"));
		}
	}
	
	// タグを削除
	public function delete_tag(){
		$this->autoRender = false;
		$tag_id = $_POST['tag_id'];
		$course_id = $_POST['course_id'];
		
		if($tag_id){
			$this->loadModel('Tag');
			$this->loadModel('CourseTag');
			
			try{
				// テストを削除
				//$this->Tag->delete($tag_id);
				
				// courses_tagのテーブルの中に削除
				$sql = "DELETE FROM courses_tags WHERE tag_id=".$tag_id. " AND course_id=".$course_id;
				$this->CourseTag->query($sql);
				return new CakeResponse(array('body' => "ok"));
			}catch (Exception $e){
				return new CakeResponse(array('body' => "not_ok"));
			}
		}else{
			return new CakeResponse(array('body' => "not_ok"));
		}
	}
}