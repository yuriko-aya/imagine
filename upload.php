<?php
echo '<div id="upload">
		<form enctype="multipart/form-data" action="" method="POST">
		<input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
		Choose a file to upload: <br />
    <center>
    <span class="btn btn-default btn-file">
		<input size="62" name="file[]" type="file" accept="image/*" multiple>
    </span>
    <br><br>
    <br>
	<div class="form-group">
		<img src="/captchalib.php">
	</div>
	<div class="form-group">
		<input type="text" class="form-control" id="captchaEntry" name="captchaEntry" placeholder="CAPTCHA">
	</div>
    <br><br>
    <br>
		<input class="btn btn-default" type="submit" value="Upload File" />
    </center>
		</form>
		<div id="info">
		Max file size: 10mb <br/>
		Supported formats: png, jpg, gif <br/>
		Please do not upload anything illegal
		</div>
  	</div>';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	if(captcha_validation($_POST['captchaEntry']) != true) {
    	echo "<center>Captcha Failed</center>";
		die();
	}
	$countfiles = count($_FILES['file']['name']);
	if($countfiles > 4) {
		echo "Cannot upload more than 4 files at once";
		die();
	}
	for($i=0;$i<$countfiles;$i++){
		$ext = pathinfo($_FILES['file']['name'][$i], PATHINFO_EXTENSION);
		if ((in_array($_FILES['file']['type'][$i], $allowedMime))
		&& (in_array(strtolower($ext), $allowedExts)) 
		&& (@getimagesize($_FILES['file']['tmp_name'][$i]) !== false)
		&& ($_FILES['file']['size'][$i] <= $maxsize)) {
			$md5 = substr(md5_file($_FILES['file']['tmp_name'][$i]), 0, 12);
			$newname = time().$md5.'.'.$ext;
			record_file($_SESSION['user'], $newname);
			move_uploaded_file($_FILES['file']['tmp_name'][$i], $filedir.'/'.$act_user.'/'.$newname);
			$imgurl = $webhome.'/img/'.$newname;
			print '<br />';
			print '<center>Your URL:<br />';
			print '<a href="'.$imgurl.'" target="_blank">'.$imgurl.'</a><br /><br />';
			print '<a href="'.$webhome.'/'.$act_user.'/view/'.$newname.'"><img src="'.$imgurl.'" width="520"></a><br /></center>';
			include('footer.php');
		} else {
				print '<br />';
				print '<center>Houston we have problem! Something went wrong </center>';
		}
	}
}
