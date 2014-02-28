<script>
    var checkEmail =0;
    var checkUsername =0;
</script>
<?php
	echo $this->Html->script('jquery-1.4.4.min.js');
	$this->Html->script('project_list', array('inline' => false));
	echo $this->Form->create('Member', array('autoComplete' => 'off','enctype' => 'multipart/form-data','inputDefaults' => array('label' => false , 'div' => false)));
	if (!empty($this->request->data['form_mode'])):    
	?>
	<?php endif; ?>

	<?php
	if (empty($this->request->data['form_mode'])) {
		echo $this->Form->hidden('form_mode', array(
			'value' => 'confirm',
			'name' => 'data[form_mode]',
			'class' => 'form-mode'
		));
	?>
	<div class="pull-left" style="width : 16%; height: 180px;">
<?php echo $this->Html->image(UPLOAD_PROFILE_URL. '/' . $this->request->data['Member']['profile_img'], array('height' => '100%')) ?>
	</div>
	<table class="table form" style="width : 80%; margin-left: 200px;">
	<tr>
		<th>名前</th>
		<td><?php
		echo $this->Form->input('fullname', array(
		'div' => false,
		'label' => false,
		'type' => 'text'
		));
		?></td>
	</tr>
	<tr>
		<th>誕生日</th>
		<td><?php
		echo $this->Form->input('birthday', array(
		'div' => false,
		'label' => false,
		'type' => 'text'
		));
		?></td>
	</tr>
	<tr>
		<th>ユーザ名</th>
		<td><?php
		echo $this->Form->input('username', array(
		'div' => false,
		'label' => false,
		'type' => 'text'
		));
		?></td>
	</tr>
	<tr>
		<th>メール</th>
		<td><?php
		echo $this->Form->input('email', array(
		'div' => false,
		'label' => false,
		'type' => 'text'
		));
		?></td>
	</tr>
	<tr>
		<th>アドレス</th>
		<td><?php
		echo $this->Form->input('address',array(
		'div' => false,
		'label' => false,
		'type' => 'text'
		));
		?></td>
	</tr>
	<tr>
		<th>電話番号</th>
		<td><?php 
		echo $this->Form->input('phone', array(
		'label' => false,
		'div' => false,
		'type' => 'text'
		));
		?></td>
	</tr>
	<tr>
		<th>セキュリティー問題</th>
		<td><?php
		echo $this->Form->input('question',array(
		'div' => false,
		'label' => false,
		'type' => 'text'
		));
		?></td>
	</tr>
	<tr>
		<th>セキュリティー答え</th>
		<td><?php
		echo $this->Form->input('answer',array(
		'div' => false,
		'label' => false,
		'type' => 'text'
		));
		?></td>
	</tr>
	<tr>
		<th>クレジットカード</th>
		<td><?php
		echo $this->Form->input('creditcard',array(
		'div' => false,
		'label' => false,
		'type' => 'text'
		));
		?></td>
	</tr>
	<tr>
		<th>アバター</th>
		<td>
		<?php echo $this->Form->input('profile_img', array(
		'type' => 'file', 'id' => 'upload-profile', 'label' => false));
		?></td>
	</tr>
</table>
	<?php
		 } elseif ($this->request->data['form_mode'] == 'confirm') {
				echo $this->Form->hidden('form_mode', array('value' => 'save','name' => 'data[form_mode]', 'class' => 'form-mode'));
				echo $this->Form->hidden('fullname');
				echo $this->Form->hidden('username');
				echo $this->Form->hidden('birthday');
				echo $this->Form->hidden('email');
				echo $this->Form->hidden('address'); 
				echo $this->Form->hidden('phone'); 
				echo $this->Form->hidden('creditcard'); 
				echo $this->Form->hidden('question');  
				echo $this->Form->hidden('answer');
				echo $this->Form->hidden('profile_img');
	?>
	
	
	
	
	    <div id="register">
            <div id="profile">   
                <h3 class="title">学生のプロファイル</h3>
                <div id="fullname" class='info'>
                    <b>名前 :</b> <br>
                    <input type="text" name="data[Member][fullname]" placeholder="名前..">
                </div>
                <div id="birthday" class='info date'>
                    <b>誕生日:</b> <br>
                    <?php 
                    echo $this->Form->input('birthday', array(
										'dateFormat' => 'DMY',
										'timeFormat' => null,
										'minYear' => date('Y') - 70,
                   						'label' => false,
										'maxYear' => date('Y') - 0));
                    ?>
                </div>
                <div id="username" class='info'>
                    <b>ユーザ名:</b>  <img  id ="username_thongbao" width="20" height="20" style="display:none; border:0px" ><br>
                    <input type = "text" name="data[Member][username]"  value="" placeholder="ユーザ名">
                    
                </div>
                <div id="password" class='info'>
                <b>パスワード:</b> <br>
                    <input type = "password" name ="data[Member][password]" value="" placeholder ='パスワード..'>
                </div>
                <div id="retype_password" class='info'>
                    <b>確認パスワード :</b><br>
                    <input type = "password" name ="data[Member][retype_password]"  value="" placeholder ="確認パスワード..">
                </div>
                <div id="email" class='info'>
                <b>メール :</b><br>
                    <input type="text" name="data[Member][email]" placeholder="メール..." >
                </div>
                <div id="address" class='info'>
                    <b>アドレス:</b><br>
                    <input type="text" name="data[Member][address]" placeholder="アドレス..." >
                </div>
                <div id="phone" class='info'>
                    <b>電話番号:</b><br>
                    <input name = "data[Member][phone]" type="text" placeholder="電話番号...">
                </div>
               <div id="question" class='info'>
                    <b>セキュリティー問題:</b><br>
                    <input type="text" name="data[Member][question]" placeholder="セキュリティー問題...">
                </div>
                 <div id="answer" class='info'>
                    <b>セキュリティー答え:</b><br>
                    <input type="text" name="data[Member][answer]" placeholder="セキュリティー答え...">
                </div>
                <div id="creditcard" class='info'>
                    <b>クレジットカード:</b><br>
                    <input type="text" name="data[Member][creditcard]" placeholder="クレジットカード...">
                </div>
                <div id="image" class='info'>
                    <b>アバター:</b><br>
                    <input type="file" name="data[Member][image]">
                </div>
          </div>
          <br>
             <?php
            echo $this->Form->submit('Submit');
            echo $this->Form->end();?>
           
      </div>