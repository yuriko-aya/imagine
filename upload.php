<?php
echo '<div id="upload">
		<form enctype="multipart/form-data" action="" method="POST">
		<input type="hidden" name="MAX_FILE_SIZE" value="5242880" />
		Choose a file to upload: <br />
    <center>
    <span class="btn btn-default btn-file">
		<input size="62"  name="file" type="file" accept="image/*" />
    </span>
    <br><br>
    <div class="g-recaptcha" data-sitekey="'.$site_key.'"></div>
    <br>
		<input class="btn btn-default" type="submit" value="Upload File" />
    </center>
		</form>
		<div id="info">
		Max file size: 5mb <br/>
		Supported formats: png, jpg, gif <br/>
		Please do not upload anything illegal
		</div>
  	</div>';

	if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($response != null && $response->success) {
  		$ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
	  	if ((in_array($_FILES['file']['type'], $allowedMime))
	  	&& (in_array(strtolower($ext), $allowedExts)) 
	  	&& (@getimagesize($_FILES['file']['tmp_name']) !== false)
	  	&& ($_FILES['file']['size'] <= $maxsize)) {
	  		$md5 = substr(md5_file($_FILES['file']['tmp_name']), 0, 7);
	  		$newname = time().$md5.'.'.$ext;
	  		move_uploaded_file($_FILES['file']['tmp_name'], $filedir.'/'.$act_user.'/'.$newname);
	  		$baseurl = $webhome.'/'.$filedir.'/'.$act_user;
	  		$imgurl = $baseurl.'/'.$newname;
	  		print '<br />';
	  		print '<center>Your URL:<br />';
	  		print '<input type="text" value="'.$imgurl.'" ><br /><br />';
	  		print '<a href="'.$webhome.'/'.$act_user.'/view/'.$newname.'"><img src="'.$imgurl.'" width="520"></a><br /></center>';
	  	} 
	    }	else {
			  print '<br />';
			  print '<center>Houston we have problem! Something went wrong </center>';
		  }
		
	  }
?>

