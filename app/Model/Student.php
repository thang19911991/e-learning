<?php
class Student extends  AppModel{
	// tên của model
	// nếu tên Model đặt tên khác thì cần phải ghi rõ tên bảng trong CSDL
	public $name = "Student";
	
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'fields' => array('id', 'username'),
			'dependent' => true
		)
	);
	
	public $validate = array(
			'username' => array(
					// Kiểm tra bằng sử dụng hàm isUniqueUsername($check) đc định nghĩa ở bên dưới
			  'rule'    => 'isUniqueUsername', 
                         'message' => 'ユーザ名が存在'
		),
			'password' => array('rule' => 'nullCheck'),
			'fullname' => array('rule' => 'nullCheck'),
			'address' => array('rule' => 'nullCheck'),
			'creditnumber' => array('rule' => 'nullCheck'),
			'mail' => array('rule' => 'nullCheck'),
			'repassword' => array('rule' => 'nullCheck'),
			'verifycode_answer' => array('rule' => 'nullCheck')
	);
	
	var $hasOne = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'id'
        )
    );
	/**
	 *
	 * Kiem tra tinh duy nhat cua username
	 * @param array $check
	 */
	public function isUniqueUsername($check){
		return  false;
		/*
		$username = $this-> Member ->find(
				'first',
				array(
						'fields' => array(
								'Member.id',
								'Member.username'
						),
						'conditions' => array(
								'Member.username' => $check['username']
						)
				)
		);
		if(empty($username)){
			return true;
		}else{
			return false;
		}
		*/
	}
	
	
	public  function  nullCheck($data)
	{
		return  true;
	}
}