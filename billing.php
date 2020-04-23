<?php
session_start();
if(isset($_SESSION["UserId"]) && isset($_SESSION["company"]) && $_SESSION["gst"]){
?>
<html lang="en">
  <head>
    <title>Invoice Generator - Bill</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script>function printdiv(){
window.frames["print_frame"].document.body.innerHTML=document.getElementById("Print_Table").innerHTML;
window.frames["print_frame"].window.focus();
window.frames["print_frame"].window.print();
}
</script>
  </head>
  <body>
  	<div class="wrapper d-flex align-items-stretch">
      <nav id="sidebar">
        <div class="p-4 pt-5"><center>
          <a href="#" class="img logo rounded-circle mb-5"><i style="font-size: 90px;" class="fa fa-user-circle" aria-hidden="true"></i><br><?php echo $_SESSION['company']; ?>
</a></center>
          <ul class="list-unstyled components mb-5">
            <li  class="active">
                <a href="generatebill.php">Generate Bill&nbsp;<i class="fa fa-file-text" aria-hidden="true"></i>
</a>
            </li>
            <li>
              <a href="#">View bill&nbsp;<i class="fa fa-file-text" aria-hidden="true"></i></a>
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
<?php
try
{
	$pdo=new PDO("pgsql:host=ec2-23-22-156-110.compute-1.amazonaws.com;port=5432;dbname=dc71h5v4qsc5iq","dmnsyiybmedxbz","943ba26baf8eb1c6c0898f6e8771e492807a6ed312e5351c7c8d54806ac000c0");
	$uid=$_SESSION['UserId'];
	$total=0;
	$notes=$_POST["notes"];
	$cname=$_POST["cname"];
	$cemail=$_POST["cmail"];
	$cphone=$_POST["cphone"];
  $x=0;
	foreach($_POST['chk'] as $a){
		$b[$x]=$_POST[$a];
		$sql1="select price_p_item,gst,iname from Item where user_id=? and itemcode=? Limit 1";
        $stmt1=$pdo->prepare($sql1);
        $stmt1->execute([$uid,$a]);
        $resw=$stmt1->fetch();
        $uprice[$x]=$resw[0];
        $cgst[$x]=$resw[1];
        $item[$x]=$resw[2];
        $tot[$x]=$b[$x]*$resw[0];
        $tax[$x]=($tot[$x])*($resw[1]/100);
        $total=$total+($tot[$x]+$tax[$x]);	
        $x++;
	}
	try{
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$pdo->beginTransaction();
	    $sql="Insert into Invoice (userid,customer_name,c_email,c_phoneno,total,note) values (?,?,?,?,?,?)";
	    $stmt=$pdo->prepare($sql);
      $stmt->execute([$uid,$cname,$cemail,$cphone,$total,$notes]);
      $orderid=$pdo->lastInsertId();
      $_SESSION['orderid']=$orderid;
    	$x=0;
    	foreach($_POST['chk'] as $a){
    		$qty=$_POST[$a];
            $subsql="Insert into Order_Item (order_id,itemcode,quantity,total_amt,tax_amt) values (?,?,?,?,?)";
            $stment=$pdo->prepare($subsql);
            $stment->execute([$orderid,$a,$qty,$tot[$x],$tax[$x]]);
            $x++;
        }
        $pdo->commit();
        echo "<script> window.location='bill.php'; </script>";
  }
  catch(PDOException $e){
    	$pdo->rollback();
    	echo "<script> alert(\"Sorry Something went wrong!\");
            javascript:history.go(-1); </script>";
    }
}
catch(PDOException $e){
    $pdo=null;
	echo "<script> alert(\"Connection Failed - ".$e->getMessage()." \");
        window.location='generatebill.php'; </script>";
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