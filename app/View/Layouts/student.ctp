<?php
/**
 *
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->css('cake.generic');
		echo $this->Html->css('teacher');
		echo $this->Html->css('jquery-ui');
		echo $this->Html->script("jquery-1.10.2");
		echo $this->Html->script("jquery-ui");
		echo $this->Html->script("swfobject");
		
		echo $this->Html->script("captivateControls");
		echo $this->Html->script("teacher");
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
	<div id="container">
		<div id="header">
			<h1><?php //echo $this->Html->link($cakeDescription, 'http://cakephp.org'); ?></h1>
		</div>
		<div id="content">

			<?php echo $this->Session->flash(); ?>
			<div class="actions">
				<ul>
					<?php
						echo '<li>'.$this->Html->image(UPLOAD_PROFILE_URL. '/' . $user['User']['profile_img'],array('height' => '200','weight' => '200')).'</li>';
						echo '<li>'.$this->Html->link("ホームページ",array('action' => 'std_index')).'</li>';
						echo '<li>'.$this->Html->link("検索機能",array('action' => 'std_search')).'</li>';
						echo '<li>'.$this->Html->link("コースリスト",array('action' => 'std_list_course')).'</li>';
						echo '<li>'.$this->Html->link("プロファイル",array('action' => 'std_profile')).'</li>';
						echo '<li>'.$this->Html->link("プロファイルを変更",array('action' => 'std_edit')).'</li>';
						echo '<li>'.$this->Html->link("テスト結果を見る",array('action' => 'std_test_result')).'</li>';
						echo '<li>'.$this->Html->link("パスワードを変更",array('action' => 'std_change_pass')).'</li>';
						echo '<li>'.$this->Html->link("買ったコースリスト",array('action' => 'std_buy_course')).'</li>';
						echo '<li>'.$this->Html->link("アカウントを脱退",array('action' => 'std_deactive')).'</li>';
						echo '<li>'.$this->Html->link("ログアウト",array('controller' => 'users', 'action' => 'logout')).'</li>';
					?>
				</ul>
			</div>
			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer">
			<?php /*echo $this->Html->link(
					$this->Html->image('cake.power.gif', array('alt' => $cakeDescription, 'border' => '0')),
					'http://www.cakephp.org/',
					array('target' => '_blank', 'escape' => false)
				);*/
			?>
		</div>
	</div>
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>
