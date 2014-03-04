$(function(){
	$( "#tag_list" ).autocomplete({
		  source: [ "c++", "java", "php", "coldfusion", "javascript", "asp", "ruby" ]
	});

	$(document).on("keydown",'#tag_list', function(e){
		if(e.keyCode==13){
			var text = $(this).val();
			if(text.length>0){
				var tagObj = $('<div class="tags">' + text + '<a class="delete"></a></div>');
				tagObj.insertBefore($("#tag_list"));
				$("#tag_list").val('');
			}
		}
	});

	$(document).on('click','.delete', function(){
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
});
