<div class="index">
<h2>プロファイル変化</h2>
<div>
<?php
echo $this->Form->create('User',array(
			'inputDefaults' => array (
				'label' => false,
				'div' =>false
				)
			)
		);
?>

<table>
	<tr>
		<td>
			<h3><label for="full_name">名前</label></h3>
		</td>
		<td>
			<?php 
				echo $this->Form->input("full_name", array(
					'value' => $data["User"]["full_name"]
				));
			?>
		</td>
	</tr>
	<tr>
		<td>
			<h3><label for="address">アドレス</label></h3>
		</td>
		<td>
			<?php 
				echo $this->Form->input("address", array(
					'value' => $data['User']['address']
				));
			?>
		</td>
	</tr>
	<tr>
		<td>
			<h3><label for="phone">電話番後</label></h3>
		</td>
		<td>
			<?php 
				echo $this->Form->input("phone", array(
					'value' => $data["User"]["phone"]
				));
			?>
		</td>
	</tr>
	<tr>
		<td>
			<h3><label for="account">銀行アカウント</label></h3>
		</td>
		<td>
			<?php 
				echo $this->Form->input("account", array(
					'value' => $data["User"]["credit_number"]
				));
			?>
		</td>
	</tr>
	<tr>
		<td>
			<h3><label for="email">メール</label></h3>
		</td>
		<td>
			<?php 
				echo $this->Form->input("email", array(
					'value' => $data["User"]["email"]
				));
			?>
		</td>
	</tr>
	<tr>
		<td></td>	
		<td>
			<?php 
				echo $this->Form->button("reset", array(
					'type' => 'reset',
					'value' => 'Reset'
				));
			?>
			<?php 
				echo $this->Form->end("Save");
			?>
		</td>
	</tr>
</table>
</div>
</div>

<div class="actions">
	<ul>
		<li>
			<?php echo $this->Html->link( "ホームページ", array('controller' => 'teachers', 'action'=>'index')); ?>
		</li>
		<li>
			<?php echo $this->Html->link( "コースリストを見る",   array('controller' => 'teachers', 'action'=>'view_list_course')); ?>
		</li>		
		<li>
			<?php echo $this->Html->link( "コース作成",   array('controller' => 'teachers', 'action'=>'create_new_course')); ?>
		</li>
		<li>
		<?php if($current_user): ?>
		<?php echo $this->Html->link( "ログアウト", array('controller' => 'teachers', 'action'=>'logout')); ?>
		<?php endif; ?>
		</li>
	</ul>
</div>