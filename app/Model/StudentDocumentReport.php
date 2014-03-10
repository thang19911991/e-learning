<?php
class StudentDocumentReport extends AppModel{
	// tên của model
	// nếu tên Model đặt tên khác thì cần phải ghi rõ tên bảng trong CSDL
	
	public $name = "students_documents_report";
	public $useTable = "students_documents_report";
	
	public $hasMany = array(
		'Document' => array(
			'className' => 'Document',
			'foreignKey' => 'document_id',
		)
	);
}