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
						 	  	echo "<li><a href=\"". $this->base.'/teachers/view_profile'. "\">プロファイル情報</a></li>";
					            echo "<li><a href=\"". $this->base.'/teachers/view_list_course'. "\">コースリスト</a></li>";
					            echo "<li><a href=\"". $this->base.'/teachers/create_new_course'. "\">授業作成</a></li>";
					            echo "<li><a href=\"". $this->base.'/teachers/course_manage'. "\">コース管理</a></li>";
					            echo "<li><a href=\"". $this->base.'/users/logout' ."\">ログアウト</a></li>";
					          echo "</ul>";
						echo "</div>";
						break;
					case "view_list_course":
						echo "<div class=\"col-sm-3 col-md-2 sidebar\">";
						 	  echo "<ul class=\"nav nav-sidebar\">";
						 	  	echo "<li><a href=\"" .$this->base.'/teachers/index'. "\">先生のページ</a></li>";
						 	  	echo "<li><a href=\"". $this->base.'/teachers/view_profile'. "\">プロファイル情報</a></li>";
						 	  	echo "<li class=\"active\"><a href=\"". $this->base.'/teachers/view_list_course'. "\">コースリスト</a></li>";
					            echo "<li><a href=\"". $this->base.'/teachers/create_new_course'. "\">授業作成</a></li>";
					            echo "<li><a href=\"". $this->base.'/users/logout' ."\">ログアウト</a></li>";
					          echo "</ul>";
						echo "</div>";
						break;
					case "view_profile":
						echo "<div class=\"col-sm-3 col-md-2 sidebar\">";
						 	  echo "<ul class=\"nav nav-sidebar\">";
						 	  	echo "<li><a href=\"" .$this->base.'/teachers/index'. "\">先生のページ</a></li>";
						 	  	echo "<li class=\"active\"><a href=\"". $this->base.'/teachers/view_profile'. "\">プロファイル情報</a></li>";
						 	  	echo "<li><a href=\"". $this->base.'/teachers/view_list_course'. "\">コースリスト</a></li>";
					            echo "<li><a href=\"". $this->base.'/teachers/create_new_course'. "\">授業作成</a></li>";
					            echo "<li><a href=\"". $this->base.'/teachers/course_manage'. "\">コース管理</a></li>";					            
					            echo "<li><a href=\"". $this->base.'/users/logout' ."\">ログアウト</a></li>";
					          echo "</ul>";
						echo "</div>";
						break;
					case "change_profile":
						echo "<div class=\"col-sm-3 col-md-2 sidebar\">";
						 	  echo "<ul class=\"nav nav-sidebar\">";
						 	  	echo "<li><a href=\"" .$this->base.'/teachers/index'. "\">先生のページ</a></li>";
						 	  	echo "<li><a href=\"". $this->base.'/teachers/view_profile'. "\">プロファイル情報</a></li>";
						 	  	echo "<li class=\"active\"><a href=\"". $this->base.'/teachers/change_profile'. "\">プロファイル変化</a></li>";
						 	  	echo "<li><a href=\"". $this->base.'/teachers/view_list_course'. "\">コースリスト</a></li>";
					            echo "<li><a href=\"". $this->base.'/teachers/create_new_course'. "\">授業作成</a></li>";
					            echo "<li><a href=\"". $this->base.'/teachers/course_manage'. "\">コース管理</a></li>";					            
					            echo "<li><a href=\"". $this->base.'/users/logout' ."\">ログアウト</a></li>";
					          echo "</ul>";
						echo "</div>";
						break;
					case "change_password":
						echo "<div class=\"col-sm-3 col-md-2 sidebar\">";
						 	  echo "<ul class=\"nav nav-sidebar\">";
						 	  	echo "<li><a href=\"" .$this->base.'/teachers/index'. "\">先生のページ</a></li>";
						 	  	echo "<li><a href=\"". $this->base.'/teachers/view_profile'. "\">プロファイル情報</a></li>";
						 	  	echo "<li class=\"active\"><a href=\"". $this->base.'/teachers/change_password'. "\">パスワード変化</a></li>";
						 	  	echo "<li><a href=\"". $this->base.'/teachers/view_list_course'. "\">コースリスト</a></li>";
					            echo "<li><a href=\"". $this->base.'/teachers/create_new_course'. "\">授業作成</a></li>";
					            echo "<li><a href=\"". $this->base.'/teachers/course_manage'. "\">コース管理</a></li>";					            
					            echo "<li><a href=\"". $this->base.'/users/logout' ."\">ログアウト</a></li>";
					          echo "</ul>";
						echo "</div>";
						break;
					case "change_secret_question":
						echo "<div class=\"col-sm-3 col-md-2 sidebar\">";
						 	  echo "<ul class=\"nav nav-sidebar\">";
						 	  	echo "<li><a href=\"" .$this->base.'/teachers/index'. "\">先生のページ</a></li>";
						 	  	echo "<li><a href=\"". $this->base.'/teachers/view_profile'. "\">プロファイル情報</a></li>";
						 	  	echo "<li class=\"active\"><a href=\"". $this->base.'/teachers/change_secret_question'. "\">秘密質問変化</a></li>";
						 	  	echo "<li><a href=\"". $this->base.'/teachers/view_list_course'. "\">コースリスト</a></li>";
					            echo "<li><a href=\"". $this->base.'/teachers/create_new_course'. "\">授業作成</a></li>";
					            echo "<li><a href=\"". $this->base.'/teachers/course_manage'. "\">コース管理</a></li>";					            
					            echo "<li><a href=\"". $this->base.'/users/logout' ."\">ログアウト</a></li>";
					          echo "</ul>";
						echo "</div>";
						break;
					case "create_new_course":
						echo "<div class=\"col-sm-3 col-md-2 sidebar\">";
						 	  echo "<ul class=\"nav nav-sidebar\">";
						 	  	echo "<li><a href=\"" .$this->base.'/teachers/index'. "\">先生のページ</a></li>";
						 	  	echo "<li><a href=\"". $this->base.'/teachers/view_profile'. "\">プロファイル情報</a></li>";
						 	  	echo "<li><a href=\"". $this->base.'/teachers/view_list_course'. "\">コースリスト</a></li>";
					            echo "<li class=\"active\"><a href=\"". $this->base.'/teachers/create_new_course'. "\">授業作成</a></li>";
					            echo "<li><a href=\"". $this->base.'/teachers/course_manage'. "\">コース管理</a></li>";
					            echo "<li><a href=\"". $this->base.'/users/logout' ."\">ログアウト</a></li>";
					          echo "</ul>";
						echo "</div>";
						break;
					case "edit_course":
						echo "<div class=\"col-sm-3 col-md-2 sidebar\">";
						 	  echo "<ul class=\"nav nav-sidebar\">";
						 	  	echo "<li><a href=\"" .$this->base.'/teachers/index'. "\">先生のページ</a></li>";
						 	  	echo "<li><a href=\"". $this->base.'/teachers/view_profile'. "\">プロファイル情報</a></li>";
						 	  	echo "<li><a href=\"". $this->base.'/teachers/view_list_course'. "\">コースリスト</a></li>";
						 	  	echo "<li class=\"active\"><a href=\"". $this->base.'/teachers/edit_course'. "\">授業情報変化</a></li>";
					            echo "<li><a href=\"". $this->base.'/teachers/create_new_course'. "\">授業作成</a></li>";
					            echo "<li><a href=\"". $this->base.'/teachers/course_manage'. "\">コース管理</a></li>";
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