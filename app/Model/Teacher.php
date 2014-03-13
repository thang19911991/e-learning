<?php
class Teacher extends AppModel{
	// tên của model
	// nếu tên Model đặt tên khác thì cần phải ghi rõ tên bảng trong CSDL
	public $name = "Teacher";		
	
	public $hasMany = array(
		'Course' => array(
			'className' => 'Course',
			'foreignKey' => 'teacher_id',
			'dependent' => true
		)
	);
	
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'fields' => array('username'),
			'dependent' => true
		)		
	);
	
	public $validate = array(
		'verify_code_answer' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'セキュリティー答えをご入力してください'
			),
			'maxLength' => array(
				'rule' => array('maxLength', 256),
				'message' => 'セキュリティー答えの最大長が256文字です',
			)
		)
	);
}