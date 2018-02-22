$(document).ready(function(){
	$("input[type=button]").click(function(){
		$.ajax({
		    type: 'POST',
		    url: $("form").attr("action"),
		    data: $("form").serialize(),
		    cache: false,
    		contentType: false,
    		processData: false,
		    success: function(response) {
		  		alert('hihih');
		    },
		});
	});
});