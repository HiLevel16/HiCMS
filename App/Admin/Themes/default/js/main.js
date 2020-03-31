(function($) {

	"use strict";

	var fullHeight = function() {

		$('.js-fullheight').css('height', $(window).height());
		$(window).resize(function(){
			$('.js-fullheight').css('height', $(window).height());
		});

	};
	fullHeight();

	$('#sidebarCollapse').on('click', function () {
      $('#sidebar').toggleClass('active');
  });

  $(function(){
	var $body = $('body');
	$('.sidebar').on('click', null, '.sidebar a', function(e){
		e.preventDefault();
		history.pushState(null, document.title, $(this).attr('href'));
		history.forward();
		$("#content").css("opacity", "0.1");
		$body.load($(this).attr('href'));
		document.title = $(this).text();
	});

	
	


	

  });
})(jQuery);

function updateSettings(element)
{
	var formData = $('#settingForm').serialize();
	var button = $(element);

	$.ajax({
		url: '/admin/settings/update',
		type: "POST",
		dataType: "html",
		data: formData,
		beforeSend: function(){
			button.addClass('loading');
		},
		success: function(result){
			toastr.success('Settings successfully applied', 'Success', {timeOut: 5000});
			button.removeClass('loading');
		}
	});
}



