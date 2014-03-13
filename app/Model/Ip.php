<?php
class Ip extends AppModel{
	// tên của model
	// nếu tên Model đặt tên khác thì cần phải ghi rõ tên bảng trong CSDL	
	public $name = "ips";
	
	/*
	public $validate = array(
		'IP' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A verify_code_id is required'
            ),
            'clientip' => array(
	        'rule'    => array('ip', 'IPv4'), // or 'IPv6' or 'both' (default)
	        'message' => 'Please supply a valid IP address.'
	    ),
	));*/
                        
        
	var $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'admin_id'
        )
    );
	
}