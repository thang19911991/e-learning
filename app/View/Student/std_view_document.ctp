
<div>
<?php 
debug($documents);	
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
} else {
	echo "<button class=\"button_report\"  style=\"margin-left: 20px;\" student_id=\"" . $student_id . " \"document_id=\"" . $documents["Document"]["id"] . "\">レポート</button>";
}





?>

</div>
<hr>

<div id="captivateSample"></div>
<button onclick="return control('captivateSample', 'next', false);">PLAY/PAUSE</button>



<?php
 
//echo "<object data=\"".$documents['Document']['path']."\" height=\"1000\" width=\"700\"  codebase=\"http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0\" classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\">";
		
		
		

?>





<script>


//Embed the SWF in the HTML
swfobject.embedSWF("/e-learning/files/documents/out2.swf", "captivateSample", "450", "300", "7" );


function playPause(){
        document.getElementById('myId').forward();
}

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
function control(swfID, command, usesSkin){
	   
	   //Get SWF as an object so we can use SetVariable
	   var swf = document.getElementById(swfID);
	   //Error-checking is good.
	   if(!swf){  return false; }
	   //Declare our prefix variable in case we need it. Leave as empty string for now.
	   var prefix = "";
	   //If the Captivate SWF uses a skin, change prefix to include the skin's movieclip name
	   if(usesSkin){ prefix = "cpSkinLoader_mc."; }
	   //Which command is being invoked?
	   	   
	   switch (command) {
	      case "pause": command = "rdcmndPause"; break;
	      case "resume": command = "rdcmndResume"; break;
	      case "rewindStop": command = "rdcmndRewindAndStop"; break;
	      case "rewindPlay": command = "rdcmndRewindAndPlay"; break;
	      case "next": 
		      command = "rdcmndNextSlide";
		      break;
	      case "prev": command = "rdcmndPrevious"; break;
	      case "info": command = "rdcmndInfo"; break;
	      case "exit": command = "rdcmndExit"; break;
	   }
	   swf.SetVariable('rdcmndNextSlide', 1);
	   return true;
}

</script>
