<div class='user index'>
<form action="/e-learning/student/std_search" id="search" method="post"
	accept-charset="utf-8">
<div><strong>検索</strong> <select name="data[User][type]" id="UserType">
	<option selected="selected" value="1">先生</option>
	<option value="2">従業</option>
	<option value="3">タグ</option>
</select><input name="data[User][keyword]" type="text" id="UserKeyword"
	maxlength="30" style="width: 500px; margin-left: 10px" /> <input
	type="submit" value="サブミット" /></div>
</form>
<div>
<ul>

<?php
if($results!="")
{
	foreach ($results as $tmp )
	{
		echo "<li>";
		echo $this->Html->link($tmp['User']['username'], array('controller' => 'teachers','action' => 'view_list_course', $tmp['Teacher']['id']));
		echo "</li>";
	}
}
if($results_course!="")
{
	foreach ($results_course as $tmp )
	{
		echo "<li>";
		echo $this->Html->link($tmp['Course']['course_name'], array('controller' => 'student','action' => 'std_try_course', $tmp['Course']['id']));
		echo "</li>";
	}
}
if($results_tag!="")
{

	foreach ($results_tag as $tmp)
	{
		foreach ($tmp['Course'] as $tmp1)
		{
			echo "<li>";
			echo $this->Html->link($tmp1['course_name'], array('controller' => 'student','action' => 'std_try_course', $tmp1['id']));
			echo "</li>";
		}
	}
}
?>
</ul>
</div>

</div>
