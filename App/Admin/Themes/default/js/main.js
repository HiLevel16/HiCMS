(function($) {

	"use strict";


	var fullHeight = function() {

		$('.js-fullheight').css('height', $(window).height());
		$(window).resize(function(){
			$('.js-fullheight').css('height', $(window).height());
		});

	};
	fullHeight();



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

	$("#page_edit_file").change(function() {
		readURL(this, '#preview_image_edit');
	});

	$("#page_create_file").change(function() {
		readURL(this, '#preview_image_create');
	});

	$('#sidebarCollapse').on('click', function () {
		$('#sidebar').toggleClass('active');
	});

  document.getElementById('btnShowContent').addEventListener(
	  'click', showContent, false
  );
  document.getElementById('btnHideContent').addEventListener(
	  'click', hideContent, false
  );

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
			giveResponse(result);
			button.removeClass('loading');
		}
	});
}

function getDeleteModal(id)
{
	$('#pageIdDeleteModal').html(id);
	$('#btnDeletePage').attr('onclick', 'deletePage('+id+')');
	$('#deleteModal').modal('toggle');
}

function deletePage(id) {
	$.ajax({
		type: "POST",
		cache: false,
		async: true,
		url: '/admin/api/deletepage',
		data: "id="+id,
		beforeSend: function() {
			$('#btnDeletePage').addClass('loading');
		},
		success: function(data){
			$('#btnDeletePage').removeClass('loading');
			response = JSON.parse(data);
			giveResponse(data);
			if (response.status == 'success')
				$('#deleteModal').modal('toggle');
			updatePagesList();
		}
	});
}
function getPage (pageNumber)
{
	$('#myPagesTable').css('opacity', '0.1');
	$('#currentPage').val(pageNumber);
	updatePagesList();
	$('#myPagesTable').css('opacity', '1');

}

function getAdditionalInfo(id) {
	hideContent();
	$.ajax({
		type: "POST",
		cache: false,
		async: true,
		url: '/admin/api/getpage',
		data: "id="+id,
		success: function(data){
			result = JSON.parse(data);
			$('#views').html(result.views);
			$('#creationDate').html(result.creationDate);
			$('#creatorId').html(result.creatorId);
			$('#category').html(result.category);
			$('#image').attr('src', result.image);
			$('#contentPreview').html(result.content);
			$('#modalGetInfo').modal();
		}
	});
}

function showContent(evt)
{
	$('#btnShowContent').css('display', 'none');
	$('#contentPreview').css('display', 'inline');
	$('#btnHideContent').css('display', 'inline');
	evt.preventDefault();
}

function hideContent(evt = null)
{
	$('#btnShowContent').css('display', 'inline');
	$('#contentPreview').css('display', 'none');
	$('#btnHideContent').css('display', 'none');
	if (evt != null)
	evt.preventDefault();
}

function editPage(id) 
{
	$.ajax({
		type: "POST",
		cache: false,
		async: true,
		url: '/admin/api/getpage',
		data: "id="+id,
		success: function(data){
			result = JSON.parse(data);
			$('#pills-edit-tab').tab('show');
			$('#pageNotSelected').css('display', 'none');
			$('#page_edit').css('display', 'inline');
			$('#page_edit_title').val(result.title);
			$('#page_edit_content').summernote('code',result.content);
			$('#preview_image_edit').attr('src', result.image);
			$('#page_edit_category').val(result.category);
			$('#page_edit_id').val(id);
		}
	});
}

function giveResponse(response)
{
	
	result = JSON.parse(response);
	if (result.status == 'error') {
		toastr.error(result.message, 'Error', {timeOut: 5000});
		return false
	} else if (result.status == 'success') {
		toastr.success(result.message, 'Success', {timeOut: 5000});
		return true;
	}
}

function readURL(input, id) {
	if (input.files && input.files[0]) {
	  var reader = new FileReader();
	  
	  reader.onload = function(e) {
		$(id).attr('src', e.target.result);
		$(id).css('display', 'inline');
	  }
	  
	  reader.readAsDataURL(input.files[0]); // convert to base64 string
	}
  }

function updatePagesList()
{
	var pageNumber = $('#currentPage').val();
	$.ajax({
		type: "POST",
		cache: false,
		async: true,
		url: '/admin/api/getpages',
		data: "page="+pageNumber+"&render=true",
		beforeSend: function() {
		},
		success: function(data){
			$('#myPagesList').detach();
			$('#pills-mypages').prepend(data);
		}
	});
}



$(document).ready(function() {
	$('#page_create_content').summernote({
		codeviewFilter: false,
  		codeviewIframeFilter: true,
		height: 200,
		toolbar: [
			['style', ['style']],
			['font', ['strikethrough', 'superscript', 'subscript']],
			['fontsize', ['fontsize']],
			['color', ['color']],
			['para', ['ul', 'ol', 'paragraph']],
			['height', ['height']],
			['view', ['fullscreen', 'codeview']],
			['insert', ['link', 'picture']]
		  ]
	});
	$('#page_edit_content').summernote({
		codeviewFilter: false,
  		codeviewIframeFilter: true,
		height: 200,
		toolbar: [
			['style', ['style']],
			['font', ['strikethrough', 'superscript', 'subscript']],
			['fontsize', ['fontsize']],
			['color', ['color']],
			['para', ['ul', 'ol', 'paragraph']],
			['height', ['height']],
			['view', ['fullscreen', 'codeview']],
			['insert', ['link', 'picture']]
		  ]
	});
  });
$(document).ready(function() {
    $('#page_create').submit(function(event){
        
        var formData = new FormData(document.getElementById("page_create"));
		var button = $('#btn_create_page');

		$.ajax({
			async: true,
			url: '/admin/pages/create',
			type: "POST",
			dataType: "html",
			data: formData,
			processData: false, 
			contentType: false,
			beforeSend: function(){
				button.addClass('loading');
			},
			success: function(result){
				var suc = giveResponse(result);
				button.removeClass('loading');
				if (suc) {
					$('#page_create_title').val('');
					$('#page_create_content').summernote('code','');
					$('#page_create_file').val('');
				}
			}
		});

        
        
        event.preventDefault;
        return false;
    });

	$('#page_edit').submit(function(event){
        
        var formData = new FormData(document.getElementById("page_edit"));
		var button = $('#btn_edit_page');

		$.ajax({
			async: true,
			url: '/admin/pages/edit',
			type: "POST",
			dataType: "html",
			data: formData,
			processData: false, 
			contentType: false,
			beforeSend: function(){
				button.addClass('loading');
			},
			success: function(result){
				giveResponse(result);
				updatePagesList();
				button.removeClass('loading');
			}
		});

        
        
        event.preventDefault;
        return false;
    });

});



