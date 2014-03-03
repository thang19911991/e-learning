<?php
class TeachersController extends AppController{
	function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow();
	}
	var $name = "Teachers";
	//	var $layout = true;
	var $helpers = array (
			"Html",
			"Session",
			"Form",
			"Paginator",
			"Js" => array ("JQuery")
	);
	var $components = array ("Session", "RequestHandler", "Auth");

	//pdf, doc, docx, ppt, pptx
	const TEXT_SIZE = 5000000;
	//image
	const IMAGE_SIZE = 5000000;
	//video
	const VIDEO_SIZE = 200000000;
	//audio
	const AUDIO_SIZE = 50000000;
	//test file
	const TEST_SIZE = 2000000;

	//tao bai giang moi
	public function create_new_course(){
		if ($this->request->is ( 'post' ) && !empty($this->data)) {
			//			var_dump ( $this->request->data );
			//			var_dump ($_FILES);
			$teacherID=1;
			$documentsPath = array();
			$data = array();
			$data['Course'] = $this->data['Course'];
			$data['Course']['teacher_id'] = 1;
			$data['Document']= array();

			// check validation for file
			for($i=0;$i<=$this->data['Course']['lessonFileNumber'];$i++){
				if($this->data['Course']['lessonName'.$i]!="" && $_FILES['lessonFile'.$i]['name']!=""){
					$array_ext = array (
						'jpg','jpeg','png','pdf','doc','docx','ppt','pptx','mp3','mp4','wma','flv'
					);
					// get file extension
					$ext = strtolower ( trim ( substr ( $_FILES['lessonFile'.$i]['name'],
					strrpos ( $_FILES['lessonFile'.$i]['name'], "." ) + 1,
					strlen ( $_FILES['lessonFile'.$i]['name'] ) ) ) );
					// save file to server

					if (in_array ( $ext, $array_ext )) {
						$new_name = "files/documents/doc_".$teacherID."_".time().".".$ext;
						$data['Document'][] = array(
						'document_name' => $this->data['Course']['lessonName'.$i],
						'path' => $this->webroot.$new_name
						);
						//if (!move_uploaded_file ( $_FILES['lessonFile'.$i]['tmp_name'], WWW_ROOT . $new_name ))
						//		$this->Session->setFlash ( "Can not save lesson file!" );
					}else {
						$this->Session->setFlash ( "Your lesson file's extension is not true!" );
						return;
					}
						
					switch($ext){
						case 'jpg':
						case 'png':
						case 'jpeg':
							if($_FILES['lessonFile'.$i]['name']>self::IMAGE_SIZE){
								$this->Session->setFlash ( "Your image file's size is over 5Mb!" );
								return;
							}
							break;
						case 'pdf':
						case 'doc':
						case 'docx':
						case 'ppt':
						case 'pptx':
							if($_FILES['lessonFile'.$i]['name']>self::TEXT_SIZE){
								$this->Session->setFlash ( "Your text (pdf, doc, docx, ppt, pptx) file's size is 5Mb! " );
								return;
							}
							break;
						case 'mp3':
							if($_FILES['lessonFile'.$i]['name']>self::AUDIO_SIZE){
								$this->Session->setFlash ( "Your audio (mp3) file's size is over 50Mb!" );
								return;
							}
							break;
						case 'mp4':
						case 'flv':
						case 'wma':
							if($_FILES['lessonFile'.$i]['name']>self::VIDEO_SIZE){
								$this->Session->setFlash ( "Your audio (mp4, flv, wma) file's size is over 200Mb!" );
								return;
							}
							break;
					}
					$documentsPath[] = array(
						'tmp_name' => $_FILES['lessonFile'.$i]['tmp_name'],
						'name' => $new_name
					);
				}
			}

			$testsPath = array();
			$data['Test'] = array();
			for($i=0;$i<=$this->data['Course']['testFileNumber'];$i++){
				if($this->data['Course']['testName'.$i]!="" && $_FILES['testFile'.$i]['name']!=""){
					// get file extension
					$ext = strtolower ( trim ( substr ( $_FILES['testFile'.$i]['name'], strrpos ( $_FILES['testFile'.$i]['name'], "." ) + 1, strlen ( $_FILES['testFile'.$i]['name'] ) ) ) );
					// save file to server
					if ($ext=='tsv') {
						$new_name = "files/tests/test_".$teacherID."_".time().".".$ext;
						$data['Test'][] = array(
							'test_name' => $this->data['Course']['testName'.$i],
							'path' => $this->webroot.$new_name
						);
						//	if (!move_uploaded_file ( $_FILES['testFile'.$i]['tmp_name'], WWW_ROOT . $new_name )){
						//		$this->Session->setFlash ( "Can not save test file!" );
						//		return;
						//  }
					}else {
						$this->Session->setFlash ( "Your test file's extension is not true!" );
						return;
					}

					if($_FILES['testFile'.$i]['size']>self::TEST_SIZE){
						$this->Session->setFlash ( "Your test file's size is over 2Mb!" );
						return;
					}

					$testsPath[] = array(
						'tmp_name' => $_FILES['testFile'.$i]['tmp_name'],
						'name' => $new_name
					);
				}
			}

			$data['Tag'] = array();
			$tagNames = array();
			for($i=0;$i<=$this->data['Course']['tagNumber'];$i++){
				if($this->data['Course']['tag'.$i]!=""){
					$data['Tag'][] = array(
						'tag_name' => $this->data['Course']['tag'.$i]
					);
					$tagNames[] = $this->data['Course']['tag'.$i];
				}
			}

			$this->loadModel('Course');
			$this->loadModel('Teacher');
			$this->loadModel('Tag');
			$this->loadModel('Document');
			$this->loadModel('Test');
			$this->loadModel('CourseTag');

			//insert course
			$dataSource = $this->Course->getDataSource();
			try{
				$dataSource->begin();
				if($this->Course->save($data)){
					$id = $this->Course->getInsertID();
				} else {
					$this->Session->setFlash ( "There is a error when inserting to database" );
					throw new Exception();
				}
				echo "111111";
				//get existed tag
				$existedTag = $this->Tag->find("all",array(
					'conditions' => array(
						'tag_name' => $tagNames
				)
				));
				echo "sadsadadas";
				debug($existedTag);
				$data['CourseTag'] = array();
				foreach ($existedTag as $cat){
					for ($i=0;$i<count($data['Tag']);$i++){
						if($cat['Tag']['name']==$data['Tag'][$i]['name']){
							unset($data['Tag'][$i]);
						}
					}
					$d = array(
						'tag_id' => $cat['tag']['id'],
						'course_id' => $id
					);
					$data['CourseTag'][] = $d;
				}

				//get tag id just insert (link to a aftersave function in AppModel
				$new_tag_ids = array();
					
				if($this->Tag->saveMany($data['Tag'])){
					$new_tag_ids=$this->Tag->inserted_ids;
				} else{
					$this->Session->setFlash ( "There is a error when inserting to database" );
					throw new Exception();
				}
				//debug($new_category_ids);

				//insert CourseCategory
				foreach ($new_tag_ids as $nci){
					$d = array(
						'tag_id' => $nci,
						'course_id' => $id
					);
					$data['CourseTag'][] = $d;
				}
				//if insert fail, return and delele course
				if(!$this->CourseTag->saveMany($data['CourseTag'])){
					$this->Session->setFlash ( "There is a error when inserting to database" );
					throw new Exception();
				}

				//insert document & test
				for($i=0;$i<count($data['Document']);$i++){
					$data['Document'][$i]['course_id'] = $id;
				}
				for($i=0;$i<count($data['Test']);$i++){
					$data['Test'][$i]['course_id'] = $id;
				}
				//			debug($data);
				// if insert document fail, delele course and CourseCategory
				if(!$this->Document->saveMany($data['Document'])){
					$this->Session->setFlash ( "There is a error when inserting to database" );
					throw new Exception();
				}

				if(!$this->Test->saveMany($data['Test'])){
					$this->Session->setFlash ( "There is a error when inserting to database" );
					throw new Exception();
				}

				//save file document
				for ($i=0;$i<count($documentsPath);$i++){
					if (!move_uploaded_file ( $documentsPath[$i]['tmp_name'], WWW_ROOT . $documentsPath[$i]['name'])){
						$this->Session->setFlash ( "Can not save lesson file!" );
						// if any file cannot save, remove all just saved file
						for($j=0;$j<$i;$j++){
							unlink(WWW_ROOT . $documentsPath[$j]['name']);
						}
						throw new Exception();
					}
				}
				//save file test
				for ($i=0;$i<count($testsPath);$i++){
					if (!move_uploaded_file ( $testsPath[$i]['tmp_name'], WWW_ROOT . $testsPath[$i]['name'])){
						$this->Session->setFlash ( "Can not save test file!" );
						// if any file cannot save, remove all just saved file
						for($j=0;$j<$i;$j++){
							unlink(WWW_ROOT . $testsPath[$j]['name']);
						}
						throw new Exception();
					}
				}
				$dataSource->commit();
			} catch(Exception $e){
				echo "<br>EXCEPTION<br>";
				$dataSource->rollback();
			}
		}
	}

	//xem danh dach cac bai giang
	public function view_list_course(){
		$order = 'Course.created_date DESC';
		$fields = array (
				'Course.*',
				'User.username' 
		);

		$joins = array ();
		$joins [] = array (
			'table' => 'courses',
			'foreignKey' => false,
			'conditions' => 'Course.teacher_id = Teacher.id',
			'type' => 'INNER',
			'alias' => 'Course' 
		);
		$joins [] = array (
			'table' => 'users',
			'foreignKey' => false,
			'conditions' => 'User.id = Teacher.user_id',
			'type' => 'INNER',
			'alias' => 'User' 
		);
		$group = 'Course.id';
		$limit = 5;
		$conditions = array (
			"Teacher.id" => 1 
		);

		$this->paginate = compact ( 'order', 'fields', 'joins', 'conditions', 'group', 'limit' );

		$data = $this->paginate ( "Teacher" );
		$this->set ( "data", $data );
	}
}
?>