
var modal = document.getElementById("myModal");
var span = document.getElementsByClassName("close")[0];
var message = document.getElementById('message');

$(document).ready(function(){
    var $form = $('#login_form');
    $form.submit(function(event){
        $("#btn_login").addClass("loading");
        var login = $("#inputLogin").val().trim();
        var password = $("#inputPassword").val().trim();
        if ($('#remember').is(":checked"))
        {
            var remember = 1;
        } else {
            var remember = 0;
        }

        $.ajax({
            url: $form.attr('action'),
            type:'POST',
            data:{login:login,password:password,remember:remember},
            success:function(response){
                response = JSON.parse(response);
                if (response.status == 'error') {
                    message.textContent = response.message;
                    modal.style.display = "block";
                    $("#btn_login").removeClass("loading");
                } else {
                    document.location.href = '/admin/dashboard';
                }
            }
        });
        
        event.preventDefault;
        return false;
    });
});


span.onclick = function() {
  modal.style.display = "none";
}

window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}