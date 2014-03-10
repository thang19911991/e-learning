<div><h1>プロファイル</h1></div>

<div>
<table>
	<tr>
		<td>ユーザ名</td>
		<td>
			<?php 
				echo $data['User']['username'];
			?>
		</td>
	</tr>
	<tr>
		<td>名前</td>
		<td>
			<?php 
				echo $data['User']['full_name'];
			?>
		</td>
	</tr>
	<tr>
		<td>アドレス</td>
		<td>
			<?php 
				echo $data['User']['address'];
			?>
		</td>
	</tr>
	<tr>
		<td>携帯電話番号</td>
		<td>
			<?php 
				echo $data['User']['phone'];
			?>
		</td>
	</tr>
	<tr>
		<td>銀行アカウント</td>
		<td>
			<?php 
				echo $data['User']['credit_number'];
			?>
		</td>
	</tr>
	<tr>
		<td>メール</td>
		<td>
			<?php 
				echo $data['User']['email'];
			?>
		</td>
	</tr>
	<tr>
		<td>誕生日</td>
		<td>
			<?php 
				echo $data['User']['birthday'];
			?>
		</td>
	</tr>
</table>

<div id="changeProfile">
	<?php
		echo $this->Html->link ( "プロファイル変化", array (
				'controller' => 'Teachers',
				'action' => 'change_profile' 
		) );
	?>
</div>
<div id="changePass">
	<?php
		echo $this->Html->link ( "パスワード変化", array (
				'controller' => 'Teachers',
				'action' => 'change_password' 
		) );
	?>
</div>
<div id="changeSQ">
	<?php
		echo $this->Html->link ( "秘密質問変化", array (
				'controller' => 'Teachers',
				'action' => 'change_secret_question' 
		) );
	?>
</div>
</div>