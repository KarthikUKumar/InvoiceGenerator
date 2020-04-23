<?php
session_start();
if(isset($_SESSION["UserId"]) && isset($_SESSION["company"]) && $_SESSION["gst"]){
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
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
<script>function printdiv(){
window.frames["print_frame"].document.body.innerHTML=document.getElementById("Print_Table").innerHTML;
window.frames["print_frame"].window.focus();
window.frames["print_frame"].window.print();
}
</script>
    <div class="wrapper d-flex align-items-stretch">
      <nav id="sidebar">
        <div class="p-4 pt-5"><center>
          <a href="#" class="img logo rounded-circle mb-5"><i style="font-size: 90px;" class="fa fa-user-circle" aria-hidden="true"></i><br><?php echo $_SESSION['company']; ?>
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
<?php
$orderid=$_SESSION['orderid'];
$totax=0;
try{
  $pdo=new PDO("pgsql:host=ec2-23-22-156-110.compute-1.amazonaws.com;port=5432;dbname=dc71h5v4qsc5iq","dmnsyiybmedxbz","943ba26baf8eb1c6c0898f6e8771e492807a6ed312e5351c7c8d54806ac000c0");
$some="Select order_date,customer_name,c_email,c_phoneno,total from Invoice where order_id=? limit 1";
        $snt=$pdo->prepare($some);
        $snt->execute([$orderid]);
        if($snt->rowCount()!=0){
          $rt=$snt->fetch();
          $dt=explode(" ",$rt[0]);
          $date=date("d-m-yy",strtotime($dt[0]));
          $time=date("H:i:s",strtotime($dt[1]));
        ?>
        <div id="Print_Table">
<div class="container special" style="border:4px double black;">
  <div class="container-fluid" style="border-bottom:2px solid black;"><br>
    <center>TAX INVOICE</center><br>
  </div>
  <div class="container-fluid" style="border-bottom:2px solid black;">
    <div class="row">
      <div class="col-xs-12 col-sm-6 col-md-8 col-lg-8"><br>
        <div class="float:left">Company: <?php echo $_SESSION['company']; ?></div>
        <div class="float:left">Address: <?php echo $_SESSION['address']." - ".$_SESSION['pincode']; ?></div>
        <div class="float:left">GSTIN: <?php echo $_SESSION['gst']; ?></div>
      </div>
      <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4"><br>
       <div class="float:right">Invoice Number: <?php echo $orderid; ?></div>
       <div class="float:right">Invoice Date: <?php echo $date; ?></div>
       <div class="float:right">Invoice Time: <?php echo $time; ?></div><br>
      </div>
    </div>
  </div><br>
  <div class="container-fluid" style="border-bottom:2px solid black;">
  <div class="row">
    <div class="col-xs-12 col-sm-6 col-md-8 col-lg-8">
      <div class="float:left">Customer Name: <?php echo $rt[1]; ?></div>
      <div class="float:left">Customer Phone Number: +91 <?php echo $rt[3]; ?></div>
      <div class="float:left">Customer Email: <?php echo $rt[2]; ?></div><br>
    </div>
  </div></div>
  <div class="container-fluid"><br>
      <table class="table-bordered">
        <tr>
          <th width="5%">Sl. No.</th>
          <th width="25%">Item Name</th>
          <th width="7%">Qty</th>
          <th width="10%">Unit Price</th>
          <th width="10%">Value</th>
          <th width="6%">CGST %</th>
          <th width="8%">CGST Amount</th>
          <th width="6%">SGST %</th>
          <th width="8%">SGST Amount</th>
          <th width="10%">Total</th>
        </tr>
        <?php
        $l=0;
        $sql="Select itemcode,quantity,total_amt,tax_amt from Order_Item where Order_Id=?";
        $stmt=$pdo->prepare($sql);
        $stmt->execute([$orderid]);
        while($res=$stmt->fetch()){
          $l++;
          $totax+=$res[3];
          $sl="Select iname,price_p_item,gst from Item where itemcode=? limit 1";
          $smt=$pdo->prepare($sl);
          $smt->execute([$res[0]]);
          $result=$smt->fetch();
          $gt=$res[2]+$res[3];
          echo "<tr><td>$l</td><td>$result[0]</td><td>$res[1]</td><td>$result[1] &#8377</td><td>$res[2] &#8377</td><td>$result[2] &#37</td><td>$res[3] &#8377</td><td>$result[2] &#37</td><td>$res[3] &#8377</td><td>$gt &#8377</td></tr>";
        }
         ?>
         <tr>
          <td></td>
          <td>Total Taxable Value</td>
          <td></td>
          <td></td>
          <td></td>
          <td>CGST:</td>
          <td><?php echo $totax; ?> &#8377</td>
          <td>SGST:</td>
          <td><?php echo $totax; ?> &#8377</td>
          <td></td>
         </tr>
      </table><br>
      <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4"></div>
      <h3><div class="float:right">GRAND TOTAL: <?php echo $rt[4]; ?> &#8377</div></h3><br>
    </div>
</div></div><br><br>
<button type="button" class="btn btn-primary" onclick="printdiv()"> Print </button>
<iframe name="print_frame" width="0" height="0" frameborder="4" src="about:blank"></iframe>
<?php
}
else{
  unset($_SESSION['orderid']);
  echo "<script> alert(\"Sorry Something went wrong!\");
          window.location='generatebill.php';   </script>";
}
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
            window.location='index.html'; </script>";
}
?>
</body>
</html>