<div class="first_page">
<?php
if($_SERVER['REQUEST_METHOD'] == 'POST') {
  if(!isset($_POST['report']) || empty($_POST['report'])) {
    $laporan = "contact";
  } else {
    $laporan = $_POST['report'];
  }
  $nama = $_POST['name'];
  $surel = $_POST['email'];
  $pesan = $_POST['message']; 
  $regs = mysqli_query($con,"INSERT INTO contact(name, email, report, message) values ( '$nama', '$surel', '$laporan', '$pesan')") or die("failed! ".mysqli_error($con));
    echo '<center>Message sent!</center>';
  }

?>
<form role="form" enctype="multipart/form-data" action="" method="post">
  <div class="form-group">
    <label for="uname">Your Name*:</label>
    <input type="text" class="form-control" id="name" name="name" required="true">
  </div>
  <div class="form-group">
    <label for="email">Your Email*:</label>
    <input type="email" class="form-control" id="email" name="email" required="true">
  </div>
  <div class="form-group">
    <label for="report">Link to report (leave blank for contacting us):</label>
    <input type="text" class="form-control" id="report" name="report">
  </div>
  <div class="form-group">
    <label for="message">Your Message:</label>
    <textarea class="form-control" id="message" name="message" rows="5"required></textarea>
  </div>
  <br>
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

