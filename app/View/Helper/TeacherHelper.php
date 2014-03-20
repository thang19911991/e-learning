<?php
class TeacherHelper extends AppHelper{
	public $helpers = array('Session');
	
	public function leftMenu(){
		$user = $this->Session->read('user');
		switch($user['role']){
			case User::TEACHER:
				switch($this->action){
					case "index":
						echo "<div class=\"col-sm-3 col-md-2 sidebar\">";
						 	  echo "<ul class=\"nav nav-sidebar\">";
						 	  	echo "<li class=\"active\"><a href=\"" .$this->base.'/teachers/index'. "\">先生のページ</a></li>";
					            echo "<li><a href=\"". $this->base.'/teachers/view_list_course'. "\">コースリスト</a></li>";
					            echo "<li><a href=\"". $this->base.'/teachers/create_new_course'. "\">コース作成</a></li>";
					            echo "<li><a href=\"". $this->base.'/users/logout' ."\">ログアウト</a></li>";
					          echo "</ul>";
						echo "</div>";
						break;
					case "view_list_course":
						echo "<div class=\"col-sm-3 col-md-2 sidebar\">";
						 	  echo "<ul class=\"nav nav-sidebar\">";
						 	  	echo "<li><a href=\"" .$this->base.'/teachers/index'. "\">先生のページ</a></li>";
						 	  	echo "<li class=\"active\"><a href=\"". $this->base.'/teachers/view_list_course'. "\">コースリスト</a></li>";
					            echo "<li><a href=\"". $this->base.'/teachers/create_new_course'. "\">コース作成</a></li>";
					            echo "<li><a href=\"". $this->base.'/users/logout' ."\">ログアウト</a></li>";
					          echo "</ul>";
						echo "</div>";
						break;
				}
				break;
		}
	}
}
?>