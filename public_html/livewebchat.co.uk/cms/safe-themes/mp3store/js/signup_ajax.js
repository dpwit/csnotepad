// JavaScript Signup Validation

$(document).ready(function(){
	
	$("#signUpForm").submit(function(){
		
		if ($('#nameForm').val() == '') {
			alert('Please enter a name');
			return false;	
		}
		if ($('#emailForm').val() == '') {
			alert('Please enter an e-mail address');
			return false;
		}
		var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
		if (!pattern.test($('#emailForm').val())) {
			alert('Please enter a valid e-mail address');
			return false;
		}
		
		// 'this' refers to the current submitted form
		var str = $(this).serialize();
		
		$.ajax({
		type: "POST",
		url: "/lists/newsletteradduser.php",
		data: str,
		success: function(msg){
		
			$('#ajaxReturn').ajaxComplete(function(event, request, settings){
				
				$("#signUpForm").fadeOut('500', function() {
					$('#ajaxReturn').html(msg);
					$('#ajaxReturn').fadeIn('500');
				});
			
			});
		
		}
	
		});
		
	return false;
		
	});

});
