<div class = 'user index'>
<?php 
	 	echo $this->Form->create('SystemParam'
	 	//,array('url'=>$this->Html->url(array('controller'=>'admins', 'action'=>'edit_system')))
	 	) ;
		echo '<h4>System Parameter</h4>';
		//echo $this->Form->input('id',  array('value' => $user['User']['id'], 'visibility' => 'hidden'));
		foreach ($system as $param){
			echo $this->Form->input($param['SystemParam']['name'],  array('value' => $param['SystemParam']['value'], 'required' => true));
		}
		
		echo $this->Form->end('Save',array('controller' => 'admins', 'action' => 'edit_system'));
	
?>
</div>