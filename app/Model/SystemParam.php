<?php
class SystemParam extends AppModel{
	// tên của model
	// nếu tên Model đặt tên khác thì cần phải ghi rõ tên bảng trong CSDL
	public $name = "SystemParam";
	
	const TEMP_LOCK_TIME = 'TEMP_LOCK_TIME';
	const MAX_TIME_WRONG_PASSWORD = 'MAX_TIME_WRONG_PASSWORD';
}