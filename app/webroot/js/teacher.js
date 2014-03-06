$(function(){
	/* dùng để disable việc ấn nút enter */
	$(window).keydown(function(event){
	    if(event.keyCode == 13) {
	      event.preventDefault();
	      return false;
	    }
	  });
	/* dùng để disable việc ấn nút enter */
	
	
	/* dung cho phan them tag*/
	$(document).on("keydown",'#tag_list', function(e){
		if(e.keyCode==13){
			var text = $(this).val();
			if(text.length>0){
				var tagObj = $('<div class="tags">' + text + '<a class="delete"></a></div>');
				tagObj.insertBefore($("#tag_list"));
				$("#tag_list").val('');
				
				$("#TeacherTags").append("<option value=\"" + text + "\">" + text + "</option>");
			}
		}
	});

	$(document).on('click','.delete', function(){
		var text = $(this).parent().text();
		$('#TeacherTags > option[value=' + text + ']').remove();
		
		$(this).parent().remove();
	});

	$(document).on('click','#submit', function(){
		var text = $(".text").text();
		alert(text);
	});

	function createTag(text) {
	    if (text != '') {
	        var tag = $('<div class="tags">' + text + '<a class="delete"></a></div>');
	        tag.insertBefore($('#tag_list'), $('#tag_list'));
	        $('#tag_list').val('');
	    }
	}
	/* dung cho phan them tag*/
});
