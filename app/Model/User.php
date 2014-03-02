<?php
App::uses('AuthComponent', 'Controller/Component');

class User extends AppModel{
	// tên của model
	// nếu tên Model đặt tên khác thì cần phải ghi rõ tên bảng trong CSDL
	public $name = "User";
	
	public $hasOne = array(
		'Teacher' => array(
			'className' => 'Teacher',
			'foreignKey' => 'user_id'
		),
		'Student' => array(
			'className' => 'Student',
			'foreignKey' => 'id'
		)
	);
	
	// kiểm tra tính hợp lệ của dữ liệu trong Form
	// tức là trước khi ấn submit thì xem dữ liệu có empty không, có valid không	
	public $validate = array(
        'username' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Bạn phải nhập trường [Tên tài khoản]',
		//'allowEmpty' => false,
		//'required' => false,
		//'last' => false, // Stop validation after this rule
		//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
					'unique' => array(
						'rule' => array('isUnique'),
						'message' => 'Tài khoản này đã được đăng kí',
		//'allowEmpty' => false,
		//'required' => false,
		//'last' => false, // Stop validation after this rule
		//'on' => 'create', // Limit validation to 'create' or 'update' operations
		),
		),

		'email' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Bạn phải nhập trường [email]',
		//'allowEmpty' => false,
		//'required' => false,
		//'last' => false, // Stop validation after this rule
		//'on' => 'create', // Limit validation to 'create' or 'update' operations
		),
			'unique' => array(
				'rule' => array('isUnique'),
				'message' => 'email này đã được đăng kí',
		//'allowEmpty' => false,
		//'required' => false,
		//'last' => false, // Stop validation after this rule
		//'on' => 'create', // Limit validation to 'create' or 'update' operations
		),
			'email' => array(
				'rule' => '/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9\._-]+)+\.([a-zA-Z])+$/',
				'message' => 'Bạn hãy nhập email đúng định dạng',
		//'allowEmpty' => false,
		//'required' => false,
		//'last' => false, // Stop validation after this rule
		//'on' => 'create', // Limit validation to 'create' or 'update' operations
		),
			'min' => array(
				'rule' => array('minLength', 6),
				'message' => 'Trường [Email] phải nhiều hơn hoặc bằng 6 kí tự ',
		//'allowEmpty' => false,
		//'required' => false,
		//'last' => false, // Stop validation after this rule
		//'on' => 'create', // Limit validation to 'create' or 'update' operations
		),
			'max' => array(
				'rule' => array('maxLength', 256),
				'message' => 'Trường [Email] phải ít hơn 256 kí tự',
		//'allowEmpty' => false,
		//'required' => false,
		//'last' => false, // Stop validation after this rule
		//'on' => 'create', // Limit validation to 'create' or 'update' operations
		)
		),
		'password' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Bạn phải nhập trường [Password]',
		//'allowEmpty' => false,
		//'required' => false,
		//'last' => false, // Stop validation after this rule
		//'on' => 'create', // Limit validation to 'create' or 'update' operations
		),
			'min' => array(
				'rule' => array('minLength', 6),
				'message' => 'Trường [Password] phải nhiều hơn hoặc bằng 6 kí tự ',
		//'allowEmpty' => false,
		//'required' => false,
		//'last' => false, // Stop validation after this rule
		//'on' => 'create', // Limit validation to 'create' or 'update' operations
		),
			'max' => array(
				'rule' => array('maxLength', 256),
				'message' => 'Trường [Password] phải ít hơn 256 kí tự',
		//'allowEmpty' => false,
		//'required' => false,
		//'last' => false, // Stop validation after this rule
		//'on' => 'create', // Limit validation to 'create' or 'update' operations
		)
		),
		're_password' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Bạn phải nhập trường [Password]',
		//'allowEmpty' => false,
		//'required' => false,
		//'last' => false, // Stop validation after this rule
		//'on' => 'create', // Limit validation to 'create' or 'update' operations
		),
			'min' => array(
				'rule' => array('minLength', 6),
				'message' => 'Trường [Password] phải nhiều hơn hoặc bằng 6 kí tự ',
		//'allowEmpty' => false,
		//'required' => false,
		//'last' => false, // Stop validation after this rule
		//'on' => 'create', // Limit validation to 'create' or 'update' operations
		),
			'max' => array(
				'rule' => array('maxLength', 32),
				'message' => 'Trường [Password] phải ít hơn 32 kí tự',
		//'allowEmpty' => false,
		//'required' => false,
		//'last' => false, // Stop validation after this rule
		//'on' => 'create', // Limit validation to 'create' or 'update' operations
		)
		),
		'new_password' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Bạn phải nhập trường [Password]',
		//'allowEmpty' => false,
		//'required' => false,
		//'last' => false, // Stop validation after this rule
		//'on' => 'create', // Limit validation to 'create' or 'update' operations
		),
			'min' => array(
				'rule' => array('minLength', 6),
				'message' => 'Trường [Password] phải nhiều hơn hoặc bằng 6 kí tự',
		//'allowEmpty' => false,
		//'required' => false,
		//'last' => false, // Stop validation after this rule
		//'on' => 'create', // Limit validation to 'create' or 'update' operations
		),
			'max' => array(
				'rule' => array('maxLength', 32),
				'message' => 'Trường [Password] phải ít hơn 32 kí tự',
		//'allowEmpty' => false,
		//'required' => false,
		//'last' => false, // Stop validation after this rule
		//'on' => 'create', // Limit validation to 'create' or 'update' operations
		)
		),
		'role' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Bạn phải nhập trường [Role]',
		)
		)
    );
    

    /**
     * 
     * Kiem tra tinh duy nhat cua username
     * @param array $check
     */
    public function isUniqueUsername($check){
    	$username = $this->find(
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
        if(!empty($username)){
            return false;
        }else{
            return true; 
        }
    }
    
	// Trước khi lưu record vào trong table members thì phải thực hiện 
    	// hàm này trước
    function beforeSave($option = array()){
    	// hash password
        if (isset($this->data[$this->alias]['password'])) {
            $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
            $this->data[$this->alias]['primary_password'] = AuthComponent::password($this->data[$this->alias]['primary_password']);
        }
        return true;    	        
    }    
}