<?php
class Tag extends AppModel{
	// tên của model
	// nếu tên Model đặt tên khác thì cần phải ghi rõ tên bảng trong CSDL
	public $name = "tags";
	// We specify the join table here because Cake would expect the table to be called courses_tags from this side
	
	public $hasAndBelongsToMany = array(
		'Course' => array(
			'className' => 'Course',
			'joinTable' => 'courses_tags'
		)
	);
}