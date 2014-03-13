<?php
class Comment extends AppModel{
	public $name = "Comment";
	public $useTable = "comments";
	
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'fields' => array('id', 'username')
		)
	);
}