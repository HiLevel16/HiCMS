<?php
$this->header('login-header');
?>


<!-- The Modal -->
<div id="myModal" class="modal">

<div class="modal-content">
  <div class="modal-header">
    <h2>Error</h2>
    <span class="close">&times;</span>
  </div>
  <div class="modal-body">
    <p id='message'></p>
  </div>
</div>

</div>

<div class="container">
<div class="row">
    <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
    <div class="card card-signin my-5">
        <div class="card-body">
        <h5 class="card-title text-center">Sign In</h5>
        <form action="/admin/api/login/" method="POST" class="ui form" id="login_form">
            <div class="field">
            <label>Login</label>
            <input name="login" type="text" id="inputLogin" class="form-control" placeholder="Login" autofocus>
            </div>

            <div class="field">
            <label>Password</label>
            <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Password">
            </div>
            <br>
            <center>
                <div class="ui test toggle checkbox">
                <input type="checkbox" id='remember'>
                <label>Remember me</label>
                </div>
            </center>
            <br>
            <button id="btn_login" class="ui primary button btn-block text-uppercase" type="submit">Sign in</button>
        </form>
        </div>
    </div>
    </div>
</div>
</div>

<?php
$this->footer('login-footer');
?>