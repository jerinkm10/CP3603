<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.1.1">
    <title>Exacore Portal</title>

    <!-- Bootstrap core CSS -->
		<link href=" public/css/bootstrap.min.css" rel="stylesheet">
		<link href=" public/css/dashboard.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href=" public/css/style.css" rel="stylesheet">
  </head>
  <body>
<div class="container">
  <div class="row">
    <div class="col-md-4 offset-4">
      <div class="login-box">
        <img src=" {{ url('public/images/logo-color.png') }}" class="logo">
        <div class="login-cover">
          <h3>Login</h3>
          <label>Employee ID /Guest</label>
          <input type="text" class="form-control" name="">
          <label>Password</label>
          <input type="password" class="form-control" name="">
          <input type="submit" name="" value="Login" class="btn btn-primary btn-login">
          <a href="index.html" class="forgot">Forgot Password</a>
          <h5>Powered by Exacore Digital 2020</h5>
        </div>
      </div>
    </div>  
  </div> 
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src=" {{ url('public/js/bootstrap.bundle.min.js') }}"></script>
<script src=" {{ url('public/js/dashboard.js') }}"></script></body>
</html>
