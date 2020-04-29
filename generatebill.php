<?php
session_start();
if(isset($_SESSION["UserId"]) && isset($_SESSION["company"])){
?>
<html lang="en">
  <head>
    <title>Invoice Generator - Billing</title>
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
            <li  class="active">
                <a href="#">Generate Bill&nbsp;<i class="fa fa-file-text" aria-hidden="true"></i>
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

     <h4>Generate Invoice</h4>
     <?php
  $uid=$_SESSION['UserId'];
  $com=$_SESSION['company'];
  try
    {
      $pdo=new PDO("pgsql:host=ec2-23-22-156-110.compute-1.amazonaws.com;port=5432;dbname=dc71h5v4qsc5iq","dmnsyiybmedxbz","943ba26baf8eb1c6c0898f6e8771e492807a6ed312e5351c7c8d54806ac000c0");
      $sql="select itemcode,iname,price_p_item,gst from Item where user_id=? Order By iname";
        $stmt=$pdo->prepare($sql);
        $stmt->execute([$uid]);
        ?>
    <div class="container">
    <form id="from1" action="billing.php" method="post">
      <div class="form-group">
    <label for="cname">Customer Name:</label>
    <input type="text" class="form-control" placeholder="Enter name" name="cname" id="cname" required>
  </div>
  <div class="form-group">
    <label for="cmail">Customer email:</label>
    <input type="email" class="form-control" placeholder="Enter email" name="cmail" id="cmail">
  </div>
  <div class="form-group">
    <label for="cphone">Customer Phone Number:</label>
    <input pattern="^\d*$" maxlength="10" class="form-control" placeholder="Enter phone number" name="cphone" form="from1" required>
  </div><br>
  <div class="table-responsive-md"><div class="input-group mb-3">
    <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-search" aria-hidden="true"></i></span></div>
    <input class="form-control" id="myInput" type="text" placeholder="Search..."></div><br><br>
    <TABLE id="dataTable" class="table order-list table-hover">
        <thead><tr class="table table-active">
            <th width="5%"></th>
            <th width="20%">SKU Code</th> 
            <th width="25%">Item</th>
            <th width="20%">Price/Item</th>
            <th width="10%">GST</th> 
            <th width="20%">Quantity</th> 
        </tr></thead><tbody id="myTable">
          <?php 
          if($stmt->rowCount()!=0){
            while ($res=$stmt->fetch()){
              echo "<tr><td><div class=\"form-check\"><label class=\"form-check-label\"><input class=\"form-check-input\" type=\"checkbox\" name=\"chk[]\" value=\"$res[0]\"></TD><td>$res[0]</td><TD>$res[1]</td><td>&#8377 $res[2]</td><td>$res[3] &#37;</td><td><input pattern=\"^\d*(\.\d{0,2})?$\" name=\"$res[0]\" onclick=\"this.select();\" value=\"0\" class=\"form-control\" form=\"from1\"></td></label></div></tr>";
            }
                    ?>
                  </tbody>
    </TABLE>
  </div>
<div class="row">
          <div class="col-xs-12 col-sm-8 col-md-8 col-lg-7">
          <h5>Notes: </h5>
          <div class="form-group">
            <textarea class="form-control txt" rows="2" cols="4" name="notes" placeholder="Your Notes"></textarea>
          </div></div>
          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-5"></div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
          </div>
      <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
    <div class="float-right"><button type="submit" class="btn btn-md btn btn-success" >Generate Bill</button></div></div></div>
  </form>
    </div>
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
      <script>
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value)>-1)
    });
  });
});
</script>
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
});

</script>
 <script type="text/javascript">
      $(document).ready(function() {
    $('#dataTable tr').click(function(event) {
        if (event.target.type !== 'checkbox') {
            $(':checkbox', this).trigger('click');
        }
    });
});
    </script> 
<?php
}
          else{
            echo "<script> alert(\"There are no Items here. Please add items.\");
            window.location='item.php'; </script>";
          }
}
catch(PDOException $e){
      echo "<script> alert(\"Connection Failed - \"".$e->getMessage()."\");
        window.location='home.html'; </script>";
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
 </body>
</html>