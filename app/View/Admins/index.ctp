<div class="actions">
<ul>
<li><h3>Hello, Admin <?php echo $current_user['username']?></h3></li>
<li><?php echo $this->Html->link( "Student Manager",   array('controller' => 'admins', 'action'=>'student_manager')); ?></li>
<li><?php echo $this->Html->link( "Teacher Manager",   array('controller' => 'admins', 'action'=>'teacher_manager')); ?></li>
<li><?php echo $this->Html->link( "Add a new Admin",   array('controller' => 'admins', 'action'=>'create_admin')); ?></li>
<li><?php echo $this->Html->link( "Admin Profile",   array('controller' => 'admins', 'action'=>'view_profile')); ?></li>
<li><?php echo $this->Html->link( "Logout", array('action'=>'logout', 'controller' => 'users')); ?></li>
<li></li>
</ul>
</div>
