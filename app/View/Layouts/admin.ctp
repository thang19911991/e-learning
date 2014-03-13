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

$T01Description = "T01 E-learning: the best learning system";
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo "E-Learning" ?>:
		<?php echo "Admin page"; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->css('cake.generic');
		echo $this->Html->script("jquery-1.7.2-min");
		
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
	<div id="container">
		<div id="header">
			<h1><?php echo $this->Html->link($T01Description, 'http://google.com/#q=t01+e-learning'); ?></h1>
		</div>
		<?php echo $this->Session->flash(); ?>
		<div id="content">
			<div class="actions">
				<ul>
					<li><h3>Hello, Admin <?php echo $current_user['username']?></h3></li>
					<li><?php echo $this->Html->link( "Home page",   array('controller' => 'admins', 'action'=>'index')); ?></li>
					<li><?php echo $this->Html->link( "Student Manager",   array('controller' => 'admins', 'action'=>'student_manager')); ?></li>
					<li><?php echo $this->Html->link( "Teacher Manager",   array('controller' => 'admins', 'action'=>'teacher_manager')); ?></li>
					<li><?php echo $this->Html->link( "Admin Manager",   array('controller' => 'admins', 'action'=>'kanrisha_manager')); ?></li>
					<li><?php echo $this->Html->link( "Add a new Admin",   array('controller' => 'admins', 'action'=>'create_admin')); ?></li>
					<li><?php echo $this->Html->link( "Admin Profile",   array('controller' => 'admins', 'action'=>'view_profile')); ?></li>
					<li><?php echo $this->Html->link( "Course Manager",   array('controller' => 'admins', 'action'=>'course_manager')); ?></li>
					<li><?php echo $this->Html->link( "System Manager",   array('controller' => 'admins', 'action'=>'system_manager')); ?></li>
					<li><?php //echo $this->Html->link( "Course Copyright report",   array('controller' => 'student_course_reports', 'action'=>'list_report')); ?></li>
					<li><?php //echo $this->Html->link( "Document Copyright report",   array('controller' => 'student_document_reports', 'action'=>'list_report')); ?></li>
					<li><?php echo $this->Html->link( "View payment",   array('controller' => 'student_course_learns', 'action'=>'view_payment_file_list')); ?></li>
					<li><?php echo $this->Html->link( "Copyright report",   array('controller' => 'student_course_reports', 'action'=>'list_report')); ?></li>
					<li><?php echo $this->Html->link( "Backup/Restore data", array('action'=>'database_manager', 'controller' => 'admins')); ?></li>
					<li><?php echo $this->Html->link( "Logout", array('action'=>'logout', 'controller' => 'users')); ?></li>
					
					
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

