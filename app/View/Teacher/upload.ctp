<div class="upload index">
<h2>Upload</h2>
<?php echo $this->Form->create('Member', array('type' => 'file')); ?>
<?php echo $this->Form->input('Member.username'); ?>
<?php echo $this->Form->input('Member.photo', array('type' => 'file')); ?>
<?php echo $this->Form->end("Upload"); ?>
</div>