<?php 
session_start();
if (isset($_SESSION['hid'])) {
  header("location:bloodrequest.php");
}elseif (isset($_SESSION['rid'])) {
  header("location:sentrequest.php");
}else{
?><?php

function get_ip() {
    foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
        if (array_key_exists($key, $_SERVER) === true) {
            foreach (array_map('trim', explode(',', $_SERVER[$key])) as $ip) {
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                    return $ip;
                }
            }
        }
    }
}

$ipadd = get_ip();

$loc = file_get_contents("http://ip-api.com/json/$ipadd");

$loc_o = json_decode($loc);

$receiverCity = $loc_o->city; // Store the city value in a PHP variable



?>
<script>
function autoFillCity() {
  
  var cityInput = document.getElementById("rcity");
  cityInput.value = "<?php echo $receiverCity; ?>";
}
</script>


<!DOCTYPE html>
<html>
<?php $title="Bloodbank | Register"; ?>
<?php require 'head.php'; ?>
<body>
  <?php include 'header.php'; ?>

    <div class="container cont">

    <?php require 'message.php'; ?>

      <div class="row justify-content-center">
        <div class="col-lg-4 col-md-5 col-sm-6 col-xs-7 mb-5">
          <div class="card rounded">
            <ul class="nav nav-tabs justify-content-center bg-light" style="padding: 20px">
              <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#hospitals">Hospitals</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#receivers">Receivers</a>
              </li>
            </ul>

    <div class="tab-content">

       <div class="tab-pane container active" id="hospitals">

       <script>
      function getCity() {
  
          var cityInput = document.getElementById("hcity");
          cityInput.value = "<?php echo $receiverCity; ?>";
}
      </script>


        <form action="file/hospitalReg.php" method="post" enctype="multipart/form-data">
          <input type="text" name="hname" placeholder="Hospital Name" class="form-control mb-3" required>
          <input type="text" name="hcity" id="hcity" placeholder="Hospital City" class="form-control mb-3" required>
          <input type="button" name="locateButton" value="Locate using map" class="btn btn-primary btn-block mb-4" onclick="getCity()">
          <input type="tel" name="hphone" placeholder="Hospital Phone Number" class="form-control mb-3" required pattern="[0,6-9]{1}[0-9]{9,11}" title="Password must have start from 0,6,7,8 or 9 and must have 10 to 12 digit">
          <input type="email" name="hemail" placeholder="Hospital Email" class="form-control mb-3" required>
          <input type="password" name="hpassword" placeholder="Hospital Password" class="form-control mb-3" required minlength="6">
          <input type="submit" name="hregister" value="Register" class="btn btn-primary btn-block mb-4">
        </form>

       </div>


       <div class="tab-pane container fade" id="receivers">

         <form action="file/receiverReg.php" method="post" enctype="multipart/form-data">
          <input type="text" name="rname" placeholder="Receiver Name" class="form-control mb-3" required>
          <select name="rbg" class="form-control mb-3" required>
                <option disabled="" selected="">Blood Group</option>
                <option value="A+">A+</option>
                <option value="A-">A-</option>
                <option value="B+">B+</option>
                <option value="B-">B-</option>
                <option value="AB+">AB+</option>
                <option value="AB-">AB-</option>
                <option value="O+">O+</option>
                <option value="O-">O-</option>
          </select>

          
          <input type="text" name="rcity" id="rcity" placeholder="Receiver City" class="form-control mb-3" required>
          <input type="button" name="locateButton" value="Locate using map" class="btn btn-primary btn-block mb-4 custom-button" onclick="autoFillCity('<?php echo $receiverCity; ?>')">
          <input type="tel" name="rphone" placeholder="Receiver Phone Number" class="form-control mb-3" required pattern="[0,6-9]{1}[0-9]{9,11}" title="Mobile no. must start from 0,6,7,8 or 9 and must have 10 to 12 digit">
          <input type="email" name="remail" placeholder="Receiver Email" class="form-control mb-3" required>
          <input type="password" name="rpassword" placeholder="Receiver Password" class="form-control mb-3" required minlength="6">
          <input type="submit" name="rregister" value="Register" class="btn btn-primary btn-block mb-4">


        </form>

       </div>
    </div>
    <a href="login.php" class="text-center mb-4" title="Click here">Already have account?</a>
</div>
</div>
</div>
</div>
<?php require 'footer.php' ?>
</body>
</html>
<?php } ?>