<div>
<?php 
// debug($documents);	
// $output = shell_exec('/usr/local/bin/pdf2swf -j100 /var/www/e-learning/app/webroot/files/documents/doc_1_1393785509.pdf  -o /var/www/e-learning/app/webroot/files/documents/out2.swf 
// ');
// echo "<pre>$output</pre>";
echo "<h2>".$documents["Document"]["name"]."</h2>"
?>
</div>
<div align="right" style="margin-bottom: 5px">
<?php 
$check_report=0;
foreach ( $reports as $tmp ) {
	if ($tmp ["StudentDocumentReport"] ["student_id"] == $student_id) {
		$check_report = 1;
		break;
	}
}
if ($check_report == 1) {
	echo "<button disabled=\"disabled\" style=\"margin-left: 20px;\">レポート</button>";
}else {
	echo "<button class=\"button_report\"  style=\"margin-left: 20px;\" student_id=\"" . $student_id . " \"document_id=\"" . $documents["Document"]["id"] . "\">レポート</button>";
}

?>
</div>
<hr>
<!--  <div id="documentViewer" class="flexpaper_viewer" style="width:770px;height:500px"></div>-->
<?php 
if($documents["Document"]["type"]=="jpg"||$documents["Document"]["type"]=="jpeg"||$documents["Document"]["type"]=="png")
{
?>
<div oncontextmenu="return false;" onselectstart="return false;" align="center" style="margin-top: 20px;">
<img src="<?php echo $documents["Document"]["path"];?>" height="500" width="500"/>
<?php	
}else if($documents["Document"]["type"]=="mp3"||$documents["Document"]["type"]=="ogg")
{
?>
<audio controls oncontextmenu="return false;" onselectstart="return false;" >
  <source src="<?php echo $documents["Document"]["path"];?>" type="audio/mpeg">
  <source src="<?php echo $documents["Document"]["path"];?>" type="audio/ogg">
  <embed height="50" width="100" src="<?php echo $documents["Document"]["path"];?>">
</audio>
<?php 	
}else if($documents["Document"]["type"]=="mp4")
{
?>	
<video width="320" height="240" controls>
 <source src="<?php echo $documents["Document"]["path"];?>" type="video/mp4">
</video>
<?php 	
}
?>
</div>
<script>
$(function(){
	$(".button_report").click(function(){
		var student_id = $(this).attr("student_id");
		var document_id = $(this).attr("document_id");
		var data=prompt("レポートの理由", "");
		if(data==null)
		{
		return false;
		}else{
			$.ajax({				
				type : "POST",
				url : '<?php echo $this->base. "/student/std_document_report" ?>',
				data : {student_id:student_id, document_id:document_id, content:data},
				success : function(data){				
				}
			});
			window.location = "<?php echo $this->Html->url(array('controller' => 'student', 'action' => 'std_view_document', $documents["Document"]["id"])); ?>"
			
		}
	});
});

</script>
<script type="text/javascript">
    
    $('#documentViewer').FlexPaperViewer(
            { config : {
                
                SWFFile : '/e-learning/files/documents/out2.swf',
                Scale : 0.6,
                ZoomTransition : 'easeOut',
                ZoomTime : 0.5,
                ZoomInterval : 0.2,
                FitPageOnLoad : true,
                FitWidthOnLoad : false,
                FullScreenAsMaxWindow : false,
                ProgressiveLoading : false,
                MinZoomSize : 0.2,
                MaxZoomSize : 5,
                SearchMatchAll : false,
                InitViewMode : 'Portrait',
                RenderingOrder : 'flash',
                StartAtPage : '',
                ViewModeToolsVisible : true,
                ZoomToolsVisible : true,
                NavToolsVisible : true,
                CursorToolsVisible : true,
                SearchToolsVisible : true,
                WMode : 'window',
                localeChain: 'en_US'
            }}
    );
</script>
