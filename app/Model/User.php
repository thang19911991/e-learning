<?php
App::uses('AuthComponent', 'Controller/Component');

class User extends AppModel{
	// tên của model
	// nếu tên Model đặt tên khác thì cần phải ghi rõ tên bảng trong CSDL
	public $name = "User";
		
	const TEACHER = "teacher";
	const STUDENT = "student";
	const ADMIN = "admin";
	
	const ACTIVED = "actived";
	const BANNED = "banned";
	const INACTIVE = "inactive";

	const ON_LOGIN_STATUS = "on";
	const OFF_LOGIN_STATUS = "off";
	const LOCK_LOGIN_STATUS = "lock";
	
	
	public $hasOne = array(
		'Teacher' => array(
			'className' => 'Teacher',
			'foreignKey' => 'user_id',
			'dependent' => true
		),
		'Student' => array(
			'className' => 'Student',
			'foreignKey' => 'user_id',
			'dependent' => true
		)
	);
	
	public $validate = array(
        'username' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'ユーザ名をご入力してください',
			),
			'unique' => array(
					'rule' => 'isUnique',
					'message' => 'そのユーザ名が既存しました。他のユーザ名をご入力してください',
			)
		),		
		'password' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'パスワードをご入力してください',
			),
			'min_length' => array(
				'rule' => array('minLength', 6),
				'message' => 'パスワードの最小長が６文字です。',
			),
			'max_length' => array(
				'rule' => array('maxLength', 256),
				'message' => 'パスワードの最大長が256文字です。',
			)
		),
		're_password' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => '確認パスワードをご入力してください',
			),
			'min_length' => array(
				'rule' => array('minLength', 6),
				'message' => '確認パスワードの最小長が6文字です。',
			),
			'max_length' => array(
				'rule' => array('maxLength', 256),
				'message' => '確認パスワードの最大長が256文字です。',
			),
			'match_password' => array(
				'rule' => 'matchPassword',
				'message' => 'パスワードと確認パスワードが合っていない'
			)
		),
		'full_name' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => '名前をご入力してください',
			)			
		),
		'email' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'メールをご入力してください',
			),			
			'email_format' => array(
				'rule' => 'email',
				'message' => 'そのメールアドレスが正しくない。',
			),
			'min_length' => array(
				'rule' => array('minLength', 6),
				'message' => 'メールの最小長が６文字です。',
			),
			'max_length' => array(
				'rule' => array('maxLength', 256),
				'message' => 'メールの最大長が256文字です。',
			)
		),
		'address' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'アドレスをご入力してください',
			)			
		),
		'phone' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => '電話番号をご入力してください',
			),
			'format_phone' => array(
				'rule' => array('phone', '/[0-9]+/', 'vn'),
				'message' => 'その電話番号が正しくないです'
			)
		),
		'verify_code' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'セキュリティー質問をご入力してください'
			),
			'max_length' => array(
				'rule' => array('maxLength', 256),
				'message' => 'セキュリティー質問の最大長が256文字です。',
			)
			
		),
		'verify_code_answer' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'セキュリティー答えをご入力してください'
			),
			'max_length' => array(
				'rule' => array('maxLength', 256),
				'message' => 'セキュリティー質問の最大長が256文字です。',
			)
		),
		'credit_number' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'クレジットカードをご入力してください'
			),
			'format_of_teacher' => array(
				'rule' => '/^[0-9]{8}-[0-9]{4}-[0-9]{4}-[0-9]{4}-[0-9]{4}$/',
				'message' => 'クレジットカードが正しくないです(正しいフォーマット：12345678-1111-2222-3333-4444)'
			),
			'format_of_student' => array(
				'rule' => '/^[0-9]{4}-[0-9]{3}-[0-9]{1}-[0-9]{7}$/',
				'message' => 'クレジットカードが正しくないです(正しいフォーマット：1111-222-3-4444444)'
			)
		),
		'profile_img' => array(
			'check_type' => array(
				'rule' => array('extension', array('gif', 'jpeg', 'png', 'jpg')),
				'message' => 'アップロードしたファイルのフォーマットが[*.jpg|*.gif|*.jpeg|*.png]です'
			),
			'check_size' => array(
				'rule' => array('fileSize', '<=', '25MB'),
				'message' => 'ファイルの最大サイズが25MBです。他のファイルをアップロードしてください'
			)
		),
		'information' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => '自己PRをご入力してください'
			),
		)
    );
    
    // kiem tra password va password_confirmation co match voi nhau khong
    public function matchPassword($data){
    	if($data['re_password'] == $this->data['User']['password']){
    		return true;
    	}
    	$this->invalidate('password', 'パスワードと確認パスワードが合っていない');
    	return false;
    }
    
    /*
	// Trước khi lưu record vào trong table members thì phải thực hiện hàm này trước
    function beforeSave($option = array()){
    	// hash password
        if (isset($this->data[$this->alias]['password'])) {
            $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
            $this->data[$this->alias]['primary_password'] = AuthComponent::password($this->data[$this->alias]['primary_password']);
        }
        return true;    	        
    }*/
}