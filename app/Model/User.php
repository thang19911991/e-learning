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
        'email' => 'email',
        
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
        'full_name' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A full name is required'
            ),
            'length' => array(
                'rule'    => array('minLength', '3'),
                'message' => 'Minimum 3 characters long'
            ),
                        
        ),
        'birthday' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Birthday is required'
            )
                        
        ),
        
        'address' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Address is required'
            )
                        
        ),
        
        'phone' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Phone number is required'
            ),
            'number' => array(
		   	    'rule' => 'numeric',       
		       	'message' => 'Please enter valid phone number'
    		),
    		'min_length' => array(
                'rule'    => array('maxLength', '12'),
                'message' => 'Please enter valid phone number'
            ),
            'max_length' => array(
                'rule'    => array('minLength', '10'),
                'message' => 'Please enter valid phone number'
            ),           
                        
        ),
        
        'credit_number' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Credit number is required'
            )
                        
        ),
        'role' => array(
            'valid' => array(
                'rule' => array('inList', array('student', 'teacher','admin')),
                'message' => 'Please enter a valid role',
                'allowEmpty' => false
            )
        )
    );
    public $hasOne = array( 
            'Teacher' => array(
            'className' => 'Teacher',   
    		'dependent' => true        
            ),
            
            'Admin' => array(
            'className' => 'Admin',    
            'dependent' => true       
            ),
            
            'Student' => array(
            'className' => 'Student',  
            'dependent' => true         
            ),
            
            'Ip' => array(
            'className' => 'Ip',
            'foreignKey' => 'admin_id',    
            'dependent' => true      
            )
            
        );
        
    
        

    public function beforeSave($options = array()) {
        if (isset($this->data[$this->alias]['password'])) {
            $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
        }
        return true;
    }
} 
?>