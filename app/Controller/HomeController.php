<?php
class HomeController extends AppController{
	function index(){
		echo gethostbyname($_SERVER['REMOTE_ADDR']);
		if(!$this->Session->check("fail_login_count")){
			echo "Session : chua khoi tao";
		}else{
			echo "Session : ".$this->Session->read("fail_login_count");
		}
		
		echo "</br>";
		echo "day la trang index cua homepage</br>";
		echo "phai hien thi duoc top bai giang, top giao vien, top bai giang moi nhat</br>";
	}
	
	function register_choice(){
		echo "day la trang lua chon dang ki la giao vien hay hoc sinh";
	}
}