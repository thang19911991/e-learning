<?php
class CoursesController extends AppController{

	// コースのタグを変更
	public function update_tag_course(){
		$this->autoRender = false;
		$this->loadModel('Tag');
		$this->loadModel('CourseTag');
			
		if(isset($_POST['tags'])){
			$tags = $_POST['tags'];
		}

		if(isset($_POST['deleted_tags'])){
			$deleted_tags = $_POST['deleted_tags'];
		}

		if(isset($_POST['course_id'])){
			$course_id = $_POST['course_id'];
		}

		if(!isset($course_id)){
			return new CakeResponse(array('body' => 'error'));
		}
		
		if(empty($tags)){
			if(empty($deleted_tags)){
				return new CakeResponse(array('body' => 'ok'));
			}else{
				foreach ($deleted_tags as $deleted_tag){
					$this->Tag->unbindModel(array('hasAndBelongsToMany' => array('Course')));
					$tag = $this->Tag->find('first',array(
						'conditions' => array(
							'Tag.tag_name' => $deleted_tag
					)
					));

					if(!empty($tag)){
						try{
							$tag_id = $tag['Tag']['id'];
							//$sql = "DELETE FROM tags WHERE id=".$tag_id;
							//$this->Tag->query($sql);
	
							// courses_tagのテーブルにそのタグを削除
							$sql = "DELETE FROM courses_tags WHERE courses_tags.tag_id=".$tag_id;
							$this->CourseTag->query($sql);
						}catch(Exception $e){
							
						}
					}
				}
				return new CakeResponse(array('body' => 'ok'));
			}
		}else{ // tags配列がnot empty
			if(empty($deleted_tags)){
				foreach ($tags as $tag) {
					$this->Tag->unbindModel(array('hasAndBelongsToMany' => array('Course')));
					$_tag = $this->Tag->find('first', array(
						'conditions' => array(
							'Tag.tag_name' => $tag
					)
					));
					
					// tagsのテーブルのtag_nameをチェック、既存の場合、tag_idをとる。
					// 一方、新追加
					if(empty($_tag)){  // tagsの配列の中にtag_name が既存しない場合
						$this->Tag->create();
						$data['Tag']['tag_name'] = $tag;

						$t = $this->Tag->save($data);

						// courses_tagのテーブルにそのタグを追加
						$this->CourseTag->create();
						$data2 = null;
						$data2['CourseTag']['course_id'] = $course_id;
						$data2['CourseTag']['tag_id'] = $t['Tag']['id'];
						$this->CourseTag->save($data2);
					}else{ // tagsの配列の中にtag_name が既存の場合
						$data2 = null;

						$count = $this->CourseTag->find('count', array(
							'conditions' => array(
								'CourseTag.course_id' => $course_id,
								'CourseTag.tag_id' => $_tag['Tag']['id']
						)
						));

						if($count==0){
							$this->CourseTag->create();
							$data2['CourseTag']['course_id'] = $course_id;
							$data2['CourseTag']['tag_id'] = $_tag['Tag']['id'];
							$this->CourseTag->save($data2);
						}
					}
				} // end foreach ($tags as $tag);
				return new CakeResponse(array('body' => 'ok'));
			}else{ // tags, deleted_tagsの配列がnot empty
				$flag = FALSE;
				foreach($deleted_tags as $deleted_tag){
					$flag = FALSE;
					foreach ($tags as $tag){
						if($deleted_tag == $tag){
							$flag = TRUE;
							break;
						}
					}

					if($flag==FALSE){
						// tagsのテーブルにそのタグを削除
						$this->Tag->unbindModel(array('hasAndBelongsToMany' => array('Course')));
						$_tag = $this->Tag->find('first',array(
							'conditions' => array(
								'Tag.tag_name' => $deleted_tag
							)
						));
							
						if(!empty($_tag)){
							$tag_id = $_tag['Tag']['id'];
							//$sql = "DELETE FROM tags WHERE id=".$tag_id;
							//$this->Tag->query($sql);
								
							// courses_tagのテーブルにそのタグを削除
							$sql = "DELETE FROM courses_tags WHERE courses_tags.tag_id=".$tag_id;
							$this->CourseTag->query($sql);
						}
					}
				}
					
				// タグを追加
				foreach ($tags as $tag){
					$flag = FALSE;
					foreach($deleted_tags as $deleted_tag){
						if($deleted_tag == $tag){
							$flag = TRUE;
							break;
						}
					}

					if($flag==FALSE){
						// tagsのテーブルにそのタグを削除
						$_tag = $this->Tag->find('count', array(
						'conditions' => array(
							'Tag.tag_name' => $tag
						)
						));
							
						if(empty($_tag)){ // tags配列の中にtag_nameが既存しない場合
							$this->Tag->create();
							$data['Tag']['tag_name'] = $tag;

							$t = $this->Tag->save($data);

							// courses_tagのテーブルにそのタグを追加
							$this->CourseTag->create();
							$data2 = null;
							$data2['CourseTag']['course_id'] = $course_id;
							$data2['CourseTag']['tag_id'] = $t['Tag']['id'];
							$this->CourseTag->save($data2);
						}else{// tags配列の中にtag_nameが既存の場合
							$data2 = null;
							$count = $this->CourseTag->find('count', array(
							'conditions' => array(
								'CourseTag.course_id' => $course_id,
								'CourseTag.tag_id' => $_tag['Tag']['id']
							)
							));
							if($count==0){
								$this->CourseTag->create();
								$data2['CourseTag']['course_id'] = $course_id;
								$data2['CourseTag']['tag_id'] = $_tag['Tag']['id'];
								$this->CourseTag->save($data2);
							}
						}
					}
				}
			}
		}
	}
}