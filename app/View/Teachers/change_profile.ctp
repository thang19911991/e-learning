<div><h1>プロファイル</h1></div>
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