$(function(){
	var deletes = [];
	var adds = [];
	
	/* dùng để disable việc ấn nút enter */
	$(window).keydown(function(event){
	    if(event.keyCode == 13) {
	      event.preventDefault();
	      return false;
	    }
	  });
	/* dùng để disable việc ấn nút enter */
	
	
	/* タグを追加*/
	$(document).on("keydown",'#tag_list', function(e){
		if(e.keyCode==13){
			var text = $(this).val();
			if(text.length>0){
				var tagObj = $('<div class="tags">' + text + '<a class="delete"></a></div>');
				tagObj.insertBefore($("#tag_list"));
				$("#tag_list").val('');
				
				adds.push(text);
				/*$("#TeacherTags").append("<option value=\"" + text + "\">" + text + "</option>"); */
			}
		}
	});

	/* 作成したタグを削除 */
	$(document).on('click','.delete', function(){
		var text = $(this).parent().text();
		$('#TeacherTags > option[value=' + text + ']').remove();
		
		$(this).parent().remove();
		deletes.push(text);
	});
});
