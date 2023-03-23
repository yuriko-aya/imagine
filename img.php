<?php
if(isset($_GET['file']) && !empty($_GET['file'])) {
    include 'config.php';
    include 'dbcon.php';
    $filename = $_GET['file'];
    $image_path = '';
    $img_search = mysqli_query($con, "select user.uname, image.img from image left join user on image.uid = user.id where image.img = '$filename'");
    while($row = mysqli_fetch_assoc($img_search)) {
        $image_path .= 'up/'.$row['uname'].'/'.$row['img'];
    }
    mysqli_close($con);
    if(file_exists($image_path)) {
        $mime_type = mime_content_type($image_path);
        $img_file = fopen($image_path, 'rb');

        header("Content-Type: ".$mime_type);
        header("Content-Length: ".filesize($image_path));

        fpassthru($img_file);
        exit;
    } else {
        header("HTTP/1.0 404 Not Found");
        echo 'Image not found';
        die();
    }
}