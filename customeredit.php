<?php
session_start();
if(isset($_SESSION["UserId"]) && isset($_SESSION["company"])){
  $uid=$_SESSION["UserId"];
  $id=$_GET['id'];
  $_SESSION['itemcode']=$id;
  try
    { 
      $pdo=new PDO("pgsql:host=ec2-23-22-156-110.compute-1.amazonaws.com;port=5432;dbname=dc71h5v4qsc5iq","dmnsyiybmedxbz","943ba26baf8eb1c6c0898f6e8771e492807a6ed312e5351c7c8d54806ac000c0");
      $sql="select cid,c_name,cemail,phone from Customer where userid=? and cid=? Limit 1";
        $stmt=$pdo->prepare($sql);
        $stmt->execute([$uid,$id]);
        $res=$stmt->fetch();
?>
<html lang="en">
  <head>
    <title>Invoice Generator - Edit Customer</title>
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
          <a href="Profile.php" class="img logo rounded-circle mb-5"><i style="font-size: 90px;" class="fa fa-user-circle" aria-hidden="true"></i><br><?php echo $_SESSION['company']; ?>
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
           <li>
              <a href="customer.php">Add Customer&nbsp;<i class="fa fa-eye" aria-hidden="true"></i>
</a>
            </li>
            <li>
              <a href="customerview.php">View Customer&nbsp;<i class="fa fa-eye" aria-hidden="true"></i>
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

        <h2 class="mb-4">Edit Customers</h2>
        <p><div class="container">
          <form action="custedition.php" method="Post" id='editform'>
  <div class="form-group">
    <label for="cname">Customer Name:</label>
    <input type="text" class="form-control" name="cname" id="cname" onclick="this.select()" <?php echo "value=\"$res[1]\""; ?> required>
  </div>
  <div class="form-group">
    <label for="cmail">Customer Email:</label>
    <input type="email" class="form-control" name="cmail" id="cmail" onclick="this.select()" <?php echo "value=\"$res[2]\""; ?> required>
  </div>
  <div class="form-group">
    <label for="Phone"><b>Phone Number</b></label>
    <input pattern="^\d*$" form="editform" class="form-control" name="phone" maxlength="10" <?php echo "value=\"$res[3]\""; ?> required>
  </div>
  <div class="form-group">
    <input type="text" class="form-control" name="cid" id="cid" onclick="this.select()" <?php echo "value=\"$res[0]\""; ?> hidden>
  </div>
<div class="float-right"><?php echo '<a href="customeredit.php?id='.$res[0].'" class="btn btn-danger">Reset</a>'; ?>&nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-primary" name="sub">Submit</button></div>
          </form>
        </div>
      </p>
    </div>
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <script>
        $(document).on('keydown', 'input[pattern]', function(e){
  var input = $(this);
  var oldVal = input.val();
  var regex = new RegExp(input.attr('pattern'), 'g');

  setTimeout(function(){
    var newVal = input.val();
    if(!regex.test(newVal)){
      input.val(oldVal); 
    }
  }, 0);
});
</script>
  </div>
  <?php
  }
    catch(PDOException $e){
      echo "<script> alert(\"Connection Failed - \"".$e->getMessage()."\");
        window.location='index.html'; </script>";
        $pdo=null;
    } 
    }
else{
  session_unset();
  session_destroy();
  echo "<script> alert(\"There was some internal server error.Please Login\");
            window.location='home.html'; </script>";
}
?>
    ?>
</body>
</body>
</html>

