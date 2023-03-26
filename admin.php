<?php
if(!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    header('Location: '.$webhome); 
}
if(is_super_user($_SESSION['user'])) {
    if(!isset($_GET['action'])) {
        if(isset($_GET['page_number']) && !empty($_GET['page_number'])) {
            $page = $_GET['page_number'];
            $offset = $_GET['page_number'] * 10;
        } else {
            $page = 0;
            $offset = 0;
        }
        $limit = 10;
        $image_query = "SELECT user.uname, image.img FROM image LEFT JOIN user on image.uid = user.id LIMIT $offset, $limit";
        $length_query = "SELECT id FROM image";
        $image_number = mysqli_query($con, $length_query) or die("failed! ".mysqli_error($con));
        $image_count = mysqli_num_rows($image_number);
        $image_list = mysqli_query($con, $image_query) or die("failed! ".mysqli_error($con));
        $prev = '';
        $next = '';
        $prev_page = $page - 1;
        $next_page = $page + 1;
        if($page != 0 || $image_count <= $page * $limit) {
            $prev .= '<a href="/management/?page_number='.$prev_page.'"><< PREV</a>';
        } elseif($page == 0 && $image_count > $limit) {
            $next .= '<a href="/management/?page_number='.$next_page.'">NEXT >></a>';
        } elseif($page != 0 && $page * $limit >= $image_count) {
            $prev .= '<a href="/management/?page_number='.$prev_page.'"><< PREV</a>';
            $next .= '<a href="/management/?page_number='.$next_page.'">NEXT >></a>';
        }
        ?>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>User</th>
                <th>Image Name</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
        <?php
        while($image = mysqli_fetch_assoc($image_list)) {
            ?>
            <tr>
                <td><?php echo $image['uname'] ?></td>
                <td><a target="_blank" href="<?php echo '/management/view/'.$image['img'] ?>"><?php echo $image['img'] ?></a></td>
                <td><a href="<?php echo '/management/delete/'.$image['img'] ?>">Delete</a></td>
            </tr>
            <?php
        }
        ?>
            </tbody>
        </table>
        <?php
        echo "$prev | $next";
        mysqli_close($con);
    }
    if(isset($_GET['action']) && !empty($_GET['action'])) {
        if($_GET['action'] == 'view' && isset($_GET['file']) && !empty($_GET['file'])) {
            $filename = $_GET['file'];
            $sql = "SELECT user.uname, image.img FROM image LEFT JOIN user on image.uid = user.id WHERE img = '$filename' LIMIT 1";
            $sql_result = mysqli_query($con, $sql) or die("failed! ".mysqli_error($con));
            $user = '';
            $img_file = '';
            while($row = mysqli_fetch_assoc($sql_result)) {
                $user .= $row['uname'];
                $img_file .= $row['img'];
            }
            mysqli_close($con);

            echo '<div class="single_img"><center>';
            if(file_exists('up/'.$user.'/'.$img_file)) {
                echo '<img src="'.$webhome.'/up/'.$user.'/'.$img_file.'"><br><br>';
                echo '<a href="'.$webhome.'/management/delete/'.$img_file.'" class="btn btn-warning" role="button"><p>Delete Image</p></a></center>';
            } else {
                echo "<center>Houston, we have problem! The image that you are loking for is not found!<br><br></center>";
                echo '<center><img src="'.$webhome.'/assets/404.jpeg"><br></center>';
            }
            echo '</center></div></div><br><br>';
        }
        if($_GET['action'] == 'delete' && isset($_GET['file']) && !empty($_GET['file'])) {
            $filename = $_GET['file'];
            $sql = "SELECT user.uname, image.img FROM image LEFT JOIN user on image.uid = user.id WHERE img = '$filename' LIMIT 1";
            $sql_result = mysqli_query($con, $sql) or die("failed! ".mysqli_error($con));
            $user = '';
            $img_file = '';
            while($row = mysqli_fetch_assoc($sql_result)) {
                $user .= $row['uname'];
                $img_file .= $row['img'];
            }
            mysqli_close($con);
            if(file_exists('up/'.$user.'/'.$img_file)) {
                delete_record($img_file);
                unlink('up/'.$user.'/'.$img_file);          
            }
            header('Location: '.$webhome.'/management');
        }
    }
} else {
    header('Location: '.$webhome); 
}
include 'footer.php';
die();
?>