<?php
// Website Configuration, you can edit it
$webhome= 'http://localhost/imagine'; //url where your script is placed
$title = '!MAGINE Image Hosting'; // website name

// Database configuration
$dbhost = "localhost";    // databse host
$dbuser = "";         // database user
$dbpass = ""; // database password
$dbname = "imagine";  // database name

//Anvance configuration, do not edit unless you know what you are doing

$filedir = 'up';
$maxsize = 5242880; //max size in bytes check you php.ini too
$allowedExts = array('png', 'jpg', 'jpeg', 'gif');
$images = '{*.png,*.jpg,*.jpeg,*.gif}';
$allowedMime = array('image/png', 'image/jpeg', 'image/pjpeg', 'image/gif');
$baseurl = $_SERVER['HTTP_HOST'].dirname($_SERVER['REQUEST_URI']).'/'.$filedir;

//reChaptcha Configuration

require_once "recaptchalib.php";

// your secret key
$secret = "";
 
// empty response
$response = null;
 
// check secret key
$reCaptcha = new ReCaptcha($secret);

// if submitted check response
if($_SERVER['REQUEST_METHOD'] == 'POST') {
  if ($_POST["g-recaptcha-response"]) {
    $response = $reCaptcha->verifyResponse(
        $_SERVER["REMOTE_ADDR"],
        $_POST["g-recaptcha-response"]
    );
  }
}

?>
