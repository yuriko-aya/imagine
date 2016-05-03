<?php

function dirlist($directory) {
  include 'config.php';
  $dir = 'up/'.$directory.'/';
  $imgfiles = glob($dir.$images, GLOB_NOSORT | GLOB_BRACE);
  foreach($imgfiles as $imgfile)
    {
      echo '<a href="'.$webhome.'/'.$_SESSION['user'].'/view/'.basename($imgfile).'"><img src="'.$webhome.'/'.$imgfile.'" alt="'.basename($imgfile).'" width="320"></a>';
    }
}

function view($file) {
  include 'config.php';
  if(file_exists('up/'.$_SESSION['user'].'/'.$file)) {
    echo '<center>Your URL:<br />';
    echo '<input type="text" value="'.$webhome.'/up/'.$_SESSION['user'].'/'.$file.'" ><br /><br />';
	  echo '<img src="'.$webhome.'/up/'.$_SESSION['user'].'/'.$file.'"><br><br>';
    if($_SESSION['user'] == "public") {
    echo '<a href="'.$webhome.'/'.$_SESSION['user'].'/report/'.$_GET['file'].'" class="btn btn-warning" role="button"><p>Report Image</p></a></center>';
  } else {
    echo '<a href="'.$webhome.'/'.$_SESSION['user'].'/delete/'.$_GET['file'].'" class="btn btn-warning" role="button"><p>Delete Image</p></a></center>';
  }

  } else {
      echo "<center>Houston, we have problem! The image that you are loking for is not found!<br><br></center>";
   	  echo '<center><img src="'.$webhome.'/assets/404.jpeg"><br></center>';
  }
}
?>

