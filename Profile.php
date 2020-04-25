<?php
session_start();
if(isset($_SESSION["UserId"]) && isset($_SESSION["company"])){
?>
<html lang="en">
  <head>
    <title>Invoice Generator - Profile</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
  </head>
  <body>
    
    <div class="wrapper d-flex align-items-stretch">
      <nav id="sidebar">
        <div class="p-4 pt-5"><center>
          <a href="#" class="img logo rounded-circle mb-5" class="active"><i style="font-size: 90px;" class="fa fa-user-circle" aria-hidden="true"></i><br><?php echo $_SESSION['company']; ?>
</a></center>
          <ul class="list-unstyled components mb-5">
            <li>
                <a href="generatebill.php">Generate Bill&nbsp;<i class="fa fa-file-text" aria-hidden="true"></i>
</a>
            </li>
            <li>
              <a href="viewbill.php">View bill&nbsp;<i class="fa fa-file-text" aria-hidden="true"></i></a>
            </li>
           <li>
            <a href="item.php">Add Items&nbsp;






              <i class="fa fa-shopping-cart" aria-hidden="true"></i>
</a> 
           </li>
            
            
            <li>
              <a href="itemview.php">View Item&nbsp;<i class="fa fa-eye" aria-hidden="true"></i>
</a>
            </li>
           
             
            
          </ul>
<center>
 <a href="logout.php" class="btn btn-success">Sign-out&nbsp;<i class="fa fa-sign-out" aria-hidden="true"></i></a>
</center>
        </div>
      </nav>

        <!-- Page Content  -->
      <div id="content" class="p-4 p-md-5">

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <div class="container-fluid">

           <button type="button" id="sidebarCollapse" class="btn btn-primary">
<i class="fa fa-bars"></i>
              
              <span class="sr-only">Toggle Menu</span>
            </button>
            <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa fa-bars"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <a href="#" class="navbar-brand">&nbsp;&nbsp;  InvoiceGenerator</a>
            </div>
          </div>
        </nav>

        <h2 class="mb-4">Profile</h2>
        <?php
         $uid=$_SESSION['UserId'];
    try
    {
      $pdo=new PDO("pgsql:host=ec2-23-22-156-110.compute-1.amazonaws.com;port=5432;dbname=dc71h5v4qsc5iq","dmnsyiybmedxbz","943ba26baf8eb1c6c0898f6e8771e492807a6ed312e5351c7c8d54806ac000c0");
      $sql="Select company,gstin_no,uemail,uaddress,ustate,ucountry,phone_no,pincode from User_Detail where userid=? Limit 1";
      $stmt=$pdo->prepare($sql);
      $stmt->execute([$uid]);
      if($stmt->rowCount()!=0){
        $res=$stmt->fetch();
      ?>
      <div class="container">
    <form id="from1" action="update.php" method="post">
      <div class="form-group">
    <label for="cname">Company Name:</label>
    <input type="text" class="form-control" name="company" id="cname" disabled onclick="select()" <?php echo "value=\"$res[0]\""; ?> required>
  </div>
  <div class="form-group">
    <label for="gstin">GSTIN Number:</label>
    <input <?php echo "value=\"$res[1]\""; ?> type="text" maxlength="15" class="form-control" name="gstin" id="gstin" disabled onkeyup="var start = this.selectionStart;
  var end = this.selectionEnd;
  this.value = this.value.toUpperCase();
  this.setSelectionRange(start, end);">
  </div>
  <div class="form-group">
    <label for="cemail">Email:</label>
    <input type="text" <?php echo "value=\"$res[2]\""; ?> class="form-control" name="uemail" id="cemail " form="from1" disabled>
  </div>
  <div class="form-group">
    <label for="cphone">Phone Number:</label>
    <input pattern="^\d*$" <?php echo "value=\"$res[6]\""; ?> maxlength="10" class="form-control" name="cphone" id="cphone" form="from1" disabled onclick="select()" required>
  </div>
  <div class="form-group">
    <label for="address">Address:</label>
    <input type="text" class="form-control" <?php echo "value=\"$res[3]\""; ?> name="address" id="address" form="from1" disabled onclick="select()" required>
  </div>
  <div class="form-group">
    <label for="state">State:</label>
    <input type="text" class="form-control" <?php echo "value=\"$res[4]\""; ?> name="State" form="from1" id="state" disabled onclick="select()" required>
  </div>
  <div class="form-group">
    <label for="country">Country:</label>
    <input type="text" class="form-control" <?php echo "value=\"$res[5]\""; ?> name="Country" id="country" form="from1" disabled onclick="select()" required>
  </div>
  <div class="form-group">
    <label for="pincode">Pin Code:</label>
    <input pattern="^\d*$" maxlength="6" class="form-control" <?php echo "value=\"$res[7]\""; ?> name="pincode" id="pincode" form="from1" disabled onclick="select()" required>
  </div><br><div class="float-right">
    <button type="reset" id="sreset" class="btn btn-info" hidden>Reset</button>
  <button type="button" onclick="dosome();" id="sedit" class="btn btn-info">Edit</button>
  &nbsp;&nbsp;<button type="submit" class="btn btn-success" id="sbutton" disabled>Submit</button>
</div>
</form>
</div>
      <?php
    }
    else{
      echo "<script> alert(\"Sorry something went wrong!\");
        window.location='generatebill.php'; </script>";
    }
    }
    catch(PDOException $e){
      echo "<script> alert(\"Connection Failed - \"".$e->getMessage()."\");
        window.location='home.html'; </script>";
        $pdo=null;
    }
      ?>
      </div>
    </div>
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <script>function dosome(){
      document.getElementById('cname').removeAttribute('disabled');
      document.getElementById('sbutton').removeAttribute('disabled');
      document.getElementById('state').removeAttribute('disabled');
      document.getElementById('country').removeAttribute('disabled');
      document.getElementById('pincode').removeAttribute('disabled');
      document.getElementById('address').removeAttribute('disabled');
      document.getElementById('cphone').removeAttribute('disabled');
      var x = document.getElementById("sedit");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
  document.getElementById('sreset').removeAttribute('hidden');
    }</script>
    <script type="text/javascript">$(document).on('keydown', 'input[pattern]', function(e){
  var input = $(this);
  var oldVal = input.val();
  var regex = new RegExp(input.attr('pattern'), 'g');

  setTimeout(function(){
    var newVal = input.val();
    if(!regex.test(newVal)){
      input.val(oldVal); 
    }
  }, 0);
});</script>
  </body>
  </html>
<?php
}
else{
  session_unset();
  session_destroy();
  echo "<script> alert(\"There was some internal server error.Please Login\");
            window.location='home.html'; </script>";
}
?>