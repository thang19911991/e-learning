<?php
class User extends AppModel {
	var $name = 'users';
	
  public $validate = array(
        'username' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A username is required'
            ),
            'isUnique' => array(
              'rule' => 'isUnique',
              'message' => 'This Username has already been used.'
            )
        ),
        'password' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A password is required'
            ),
            'length' => array(
                'rule'    => array('minLength', '3'),
                'message' => 'Minimum 3 characters long'
            ),
                        
        ),
        'role' => array(
            'valid' => array(
                'rule' => array('inList', array('student', 'teacher','admin')),
                'message' => 'Please enter a valid role',
                'allowEmpty' => false
            )
        )
    );
//    public $hasOne = array( 
//            'Teacher' => array(
//            'className' => 'Lecturer',           
//            )
//        );

    public function beforeSave($options = array()) {
        if (isset($this->data[$this->alias]['password'])) {
            $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
        }
        return true;
    }
} 
?>