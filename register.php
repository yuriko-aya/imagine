<div class="first_page">
<?php
if(isset($_SESSION['user']) && !empty($_SESSION['user'])) {
  header('Location: '.$webhome.'/'.$_SESSION['user']); 
}
if($_SERVER['REQUEST_METHOD'] == 'POST') {
  $uname = $_POST['username'];
  $new_password = $_POST['pwd'];
  $password_hash = crypt($new_password,'$6$');
  $checkname = mysqli_query($con,"SELECT * FROM user where uname='$uname'");
  $idexist = mysqli_num_rows($checkname);
  if($idexist!=0) {
  echo "Houston, we have problem! That user name already taken!";
  } elseif ($response != null && $response->success) {
    $regs = mysqli_query($con,"INSERT INTO user(uname, pwd, level) values ( '$uname', '$password_hash', 'user')") or die("failed! ".mysqli_error($con));
    mkdir('up/'.$uname);
    echo '<div><h1 align="center">Congratulation!!</h1><br /><h2 align="center">Now You have registered as user in this site</h2><br /><h3 align="center"><a href="'.$webhome.'">Back to Home</a></h3></div>';
  } else {
    echo "Houston, we have problem! The chaptcha was wrong!";
  }
}
?>
<form role="form" enctype="multipart/form-data" action="" method="post">
  <div class="form-group">
    <label for="uname">User Name:</label>
    <input type="text" class="form-control" id="username" name="username">
  </div>
  <div class="form-group">
    <label for="pwd">Password:</label>
    <input type="password" class="form-control" id="pwd" name="pwd">
  </div>
  <br>
  <div class="g-recaptcha" data-sitekey="6LfCuR4TAAAAALH4cMYuU2ng9Uadz-MX2Q6wlRDO"></div>
  <br>
  <button type="submit" class="btn btn-default">Submit</button>
</form>
<div>
</div>
</div>
</div>
<br><br>
<?php include 'footer.php';
die();
?>

