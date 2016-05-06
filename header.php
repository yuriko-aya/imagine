<html>
<head>
<meta name="description" content="IMAGINE Simple Image Hosting by Yuriko Aya">
    <title><?php echo $title; ?></title>
<link rel="stylesheet" href="<?php echo $webhome; ?>/css.css" type="text/css" />
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootswatch/3.1.1/superhero/bootstrap.min.css" type="text/css"/>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js" type="text/javascript"></script>
<script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body>
<nav class="navbar navbar-default" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <a class="navbar-brand" href="<?php echo $webhome; ?>"><?php echo $title; ?></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
      <ul class="nav navbar-nav navbar-right">
<?php
echo'<li><a href="'.$webhome.'/report">Contact/Report</a></li>';
if(isset($_SESSION) && !empty($_SESSION['user'])) {
  echo '<li><a href="'.$webhome.'/'.$_SESSION['user'].'/upload">Upload</a></li>
        <li><a href="'.$webhome.'/logout">Log Out</a></li>';
  if($_SESSION['level'] == "superuser") {
    echo '<li><a href="'.$webhome.'/'.$_SESSION['user'].'/superuser">Admin</a></li>';
  }
} else {
  echo '<li><a href="'.$webhome.'/login">login</a></li>
        <li><a href="'.$webhome.'/register">signup</a></li>';
}
?>
      </ul>
  </div><!-- /.container-fluid -->
</nav>
<div class="container">

