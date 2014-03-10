<div class='user index'><?php
echo $this->Form->create('User');
echo $this->Form->input('old_password', array('type' => 'password',
										'name' => 'password',
  			                            'label' => 'パスワード',
                   						'required' => false));
echo $this->Form->input('new_password', array('type' => 'password',
										'name' => 'password1',
  			                            'label' => '新しいパスワード',
                   						'required' => false));
echo $this->Form->input('re_new_password', array('type' => 'password',
  			                            'label' => '確認新しいパスワード',
										'name' => 'password2',
                   						'required' => false));
echo $this->Form->end('Save',array('controller' => 'student', 'action' => 'std_change_pass'));
?></div>
