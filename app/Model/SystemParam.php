<?php
class SystemParam extends AppModel{
	// tên của model
	// nếu tên Model đặt tên khác thì cần phải ghi rõ tên bảng trong CSDL
	public $name = "system_params";
	
	const TEMP_LOCK_TIME 			= 'LOCK_TIME';
	const MAX_TIME_WRONG_PASSWORD 	= 'WRONG_PASS_LIMIT';
	const MAX_LENGTH_INPUT			= 'MAX_LENGTH_INPUT';
	const MIN_LENGTH_PASSWORD		= 'MIN_LENGTH_PASSWORD';
	const MAX_AVATAR_SIZE			= 'MAX_AVATAR_SIZE';
	const MAX_COURSE_FILE_SIZE		= 'MAX_COURSE_FILE_SIZE';
	const KOMA_COST					= 'KOMA_COST';
	const SESSION_TIMEOUT			= 'SESSION_TIMEOUT';
	const TEACHER_PAY				= 'TEACHER_PAY';
	const KOMA_TIMEOUT				= 'KOMA_TIMEOUT';
}