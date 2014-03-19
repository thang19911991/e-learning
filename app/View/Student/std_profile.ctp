<h2>これは<?php 
echo $user['User']['full_name']?>さんのプロファイル：</h2>
<br>
<div class='user index'>
<table class = 'table form'>
	<tr>
		<th>名前</th>
		<td><?php 
		echo $user['User']['full_name'];
		?></td>
	</tr>
	<tr>
		<th>ユーザ名</th>
		<td><?php 
		echo $user['User']['username'];
		?></td>
	</tr>
	<tr>
		<th>電話番号</th>
		<td><?php 
		echo $user['User']['phone'];
		?></td>
	</tr>
	<tr>
		<th>メール</th>
		<td><?php 
		echo $user['User']['email'];
		?></td>
	</tr>
	<tr>
		<th>アドレス</th>
		<td><?php 
		echo $user['User']['address'];
		?></td>
	</tr>
	<tr>
		<th>クレジットカード</th>
		<td><?php 
		echo $user['User']['credit_number'];
		?></td>
	</tr>
</table>
</div>

