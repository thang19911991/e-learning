<style>
.main {
	margin-top: 50px;
}
</style>
<div class="col-sm-6 col-sm-offset-5 col-md-6 col-md-offset-2 main">
	<div class="row">
		<?php //echo $this->Session->flash(); ?>
		<?php if(!empty($data)):?>
		<span class="label label-danger" style="font-size: 21px;" >学生のテスト見る</span>
		<table class="table table-hover table-bordered">
			<tr>
				<th>学生名</th>
				<th>テスト名</th>
				<th>点</th>
				<th>テスト日</th>
			</tr>			
			<?php 
				foreach ($data as $test){
					for($i=0;$i<count($test);$i++){
					?>
			<tr>
				<td>
					<?php 
						echo $test[$i]['student_name']['User']['username'];
					?>
				</td>
				<td>
					<?php 
						echo $test[$i]['test_name'];
					?>
				</td>
				<td>
					<?php 
						echo $test[$i]['students_tests']['point'];
					?>
				</td>
				<td>
					<?php 
						echo $test[$i]['students_tests']['test_date'];
					?>
				</td>
			</tr>
				<?php
				}
			}
		?>
		</table>
		<?php else:?>
		<span class="label label-danger" style="font-size: 20px"><?php echo "そのコースIDが既存しない";?></span>
		<?php endif; ?>
	</div>
</div>