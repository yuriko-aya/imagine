<?php
session_start();
include 'config.php';
include 'functions.php';
include 'dbcon.php';
if(isset($_SESSION['user']) && !empty($_SESSION['user'])) {
  $act_user = $_SESSION['user'];
}

if(!isset($_GET['page']) || empty( $_GET['page'])) {
  if(isset($_SESSION['user']) && !empty($_SESSION['user'])) {
    header('Location: '.$webhome.'/'.$act_user);
  }
}
include 'header.php';
if(isset($_GET['page']) && !empty($_GET['page'])) {
  if($_GET['page'] == "register") {
    include 'register.php';
  }
  if($_GET['page'] == "login") {
    include 'login.php';
  }
  if($_GET['page'] == "logout") {
    session_unset();
    session_destroy();
    header('Location: ' .$webhome);
  }
  if($_GET['page'] == "error") {
    if($_GET['action'] == "404") {
      echo "<center>Houston, we have problem! The image that you are loking for is not found!<br><br></center>";
      echo '<center><img src="'.$webhome.'/assets/404.jpeg"><br></center>';
      echo '</div></div><br><br>';
      include 'footer.php';
      die();      
    }
  }
}
if(isset($_GET['action']) && !empty($_GET['action'])) {
  if($_GET['action'] == "upload") {
    include 'upload.php';
  }
  if($_GET['action'] == "view" && isset($_GET['file']) && !empty($_GET['file'])) {
  echo '<div class="single_img">';
  view($_GET['file']);
  echo '</div></div><br><br>';
  include 'footer.php';
  die();
  }
  if($_GET['action'] == "delete" && isset($_GET['file']) && !empty($_GET['file'])) {
    if(file_exists('up/'.$_SESSION['user'].'/'.$_GET['file'])) {
      unlink('up/'.$_SESSION['user'].'/'.$_GET['file']);
      header('Location : '.$webhome.'/'.$_SESSION['user']);
    }
  } elseif($_GET['action'] != "report" && $_GET['action'] != "upload") {
    echo "<center>Houston we have problem! The file that you want to delete is not exist!</center>";
  }
  if($_GET['action'] == "report" && isset($_GET['file']) && !empty($_GET['file'])) {
    $imgfile = $_GET['file'];
    $report = mysqli_query($con,"INSERT INTO report(img, status) values ( '$imgfile', 'undone')") or die("failed! ".mysqli_error($con));
    echo "<center>Roger Houston, report have been sent!</center<br><br>";
    echo '<div class="single_img">';
    view($_GET['file']);
    echo '</div></div><br><br>';
    include 'footer.php';
    die();
  }
}
echo '<br><br><div class="gallery_container">';
if(!isset($_SESSION['user']) && empty($_SESSION['user'])) {
  echo '<div class="first_page">
    <a href="'.$webhome.'/login" class="btn btn-primary btn-block" role="button"><p>Login</p></a><br><br>
    <a href="'.$webhome.'/register" class="btn btn-success btn-block" role="button"><p>Register</p></a><br><br>
    <a href="'.$webhome.'/login/public" class="btn btn-info btn-block" role="button"><p>Public Access</p></a><br><br>
    </div>';
  echo '<br><br></div>';
} else {
  if($_SESSION['user'] == "public") {
    echo '<center><h3>Public image only availabe for 30 days</h3></center>';
  }
  dirlist($act_user);
}
echo '</div></div>;';
include 'footer.php';
?>
