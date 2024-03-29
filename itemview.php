<?php
session_start();
if(isset($_SESSION["UserId"]) && isset($_SESSION["company"])){
?>
<html lang="en">
  <head>
    <title>Invoice Generator - View Item</title>
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
            
            
            <li  class="active">
              <a href="itemview.php">View Item&nbsp;<i class="fa fa-eye" aria-hidden="true"></i>
</a>
            </li>
            <li >
              <a href="customer.php">Add Customer&nbsp;<i class="fa fa-eye" aria-hidden="true"></i>
</a>
            </li>
            <li >
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

        <h2 class="mb-4">View Items</h2>
        <p><div class="container">
          <form action="deleteitem.php" method="Post">
  <?php
  $uid=$_SESSION['UserId'];
  $com=$_SESSION['company'];
  try
    { 
      $pdo=new PDO("pgsql:host=ec2-23-22-156-110.compute-1.amazonaws.com;port=5432;dbname=dc71h5v4qsc5iq","dmnsyiybmedxbz","943ba26baf8eb1c6c0898f6e8771e492807a6ed312e5351c7c8d54806ac000c0");
      $sql="select itemcode,iname,idesc,price_p_item,gst from Item where user_id=? Order By iname";
        $stmt=$pdo->prepare($sql);
        $stmt->execute([$uid]);
        $i=0;
        if($stmt->rowCount()!=0){
          echo "<div class=\"table-responsive-md\"><div class=\"input-group mb-3\">
    <div class=\"input-group-prepend\"><span class=\"input-group-text\"><i class=\"fa fa-search\" aria-hidden=\"true\"></i></span></div><input class=\"form-control\" id=\"myInput\" type=\"text\" placeholder=\"Search...\"></div><br><br><table class=\"table table-hover\" id='dataTable'><CENTER><tr class=\"table table-active\"><th width=\"8%\">Sl. No.</th><th width=\"10%\">SKU</th><th width=\"20%\">Name</th><th width=\"40%\">Description</th><th width=\"13%\">Price/Item</th><th width=\"9%\">GST</th><center></tr><tbody id=\"myTable\">";
          while ($res=$stmt->fetch()){
            $i++;
            echo "<tr><td><div class=\"form-check\"><label class=\"form-check-label\"><input class=\"form-check-input\" type=\"checkbox\" name=\"chk[]\" value=\"$res[0]\">$i</td><td>".$res['itemcode']."</td><td>".$res['iname']."</td><td>".$res['idesc']."</td><td>".number_format($res['price_p_item'],2)." &#8377</td><td>".$res['gst']." &#37;</td></label></div></tr>";
          }
          ?>
          </tbody></table></div><br><br>
          <div class="float-right"><button type="Submit" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i>&nbsp;Delete</button></div>
          <br><br>
        </form>

          <?php
        }
        else
        {
          echo "Sorrry there are no items here.Please add Items of your shop.";
          echo "<a href='item.php'>Add Item</a>";
        }
    }
    catch(PDOException $e){
      echo "<script> alert(\"Connection Failed - \"".$e->getMessage()."\");
        window.location='index.html'; </script>";
        $pdo=null;
    } 
    ?>
</div></p>
     
      </div>
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
  session_unset();
  session_destroy();
  echo "<script> alert(\"There was some internal server error.Please Login\");
            window.location='index.php'; </script>";
}
?>
  </body>
</html>
