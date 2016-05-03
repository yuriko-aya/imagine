<div class="first_page">
<?php
if(isset($_SESSION['user']) && !empty($_SESSION['user'])) {
  header('Location: '.$webhome.'/'.$_SESSION['user']); 
}

if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == "public") {
  echo '<form role="form" enctype="multipart/form-data" action="" method="post">
  <div class="form-group">
    <input type="hidden" class="form-control" id="public" name="public" value="public">
  </div>
  <button type="submit" class="btn btn-warning btn-block">Continue to Public Page</button>
  </form>
  <br><center>OR</center><br>
';
}
if($_SERVER['REQUEST_METHOD'] == 'POST') {
  if(isset($_POST['public']) && !empty($_POST['public'])) {
    $_SESSION['user'] = $_POST['public'];
    $_SESSION['level'] = $_POST['public'];
    header('Location: '.$webhome.'/'.$_POST['public']);
  } else {
    $uname = $_POST['username'];
    $password_entered = $_POST['pwd'];
    $dbpass = mysqli_query($con,"SELECT * FROM user WHERE uname='$uname'");
    if(mysqli_num_rows($dbpass) == 0) {
        echo "<center>Houston, we have problem! That user name does not exist!</center>";  
    } else {   
      while($passhash = mysqli_fetch_array($dbpass)) {
        if(password_verify($password_entered, $passhash['pwd'])) {
          $_SESSION['level'] = $passhash['level'];
          $_SESSION['user'] = $passhash['uname'];
          header('Location: '.$webhome.'/'.$_SESSION['user']);
          } else { 
          echo "<center>Houston, we have problem! Username and password does not match!</center>";
          }
      }
  
    }
  }
}
?>
<form role="form" enctype="multipart/form-data" action="" method="post">
  <div class="form-group">
    <label for="username">User Name:</label>
    <input type="text" class="form-control" id="username" name="username">
  </div>
  <div class="form-group">
    <label for="pwd">Password:</label>
    <input type="password" class="form-control" id="pwd" name="pwd">
  </div>
  <button type="submit" class="btn btn-success btn-block">LOGIN</button>
</form>
<div>
</div>
</div>
</div>
<br><br>
<?php include 'footer.php';
die();
?>

