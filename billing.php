<?php
session_start();
?>
<HTML>
<HEAD>
    <TITLE>Invoice Generator - Bill</TITLE>
</HEAD><body>
<?php
if(isset($_SESSION["UserId"]) && isset($_SESSION["company"]) && $_SESSION["gst"]){
try
{
	$pdo=new PDO("pgsql:host=ec2-23-22-156-110.compute-1.amazonaws.com;port=5432;dbname=dc71h5v4qsc5iq","dmnsyiybmedxbz","943ba26baf8eb1c6c0898f6e8771e492807a6ed312e5351c7c8d54806ac000c0");
	$uid=$_SESSION['UserId'];
	$total=0;
	$notes=$_POST["notes"];
	$cname=$_POST["cname"];
  $x=0;
  if(isset($_POST['chk'])){
    foreach($_POST['chk'] as $a){
      if($_POST[$a]==0)
        continue;
		  $b[$x]=$_POST[$a];
		  $sql1="select price_p_item,gst,iname from Item where user_id=? and itemcode=? Limit 1";
      $stmt1=$pdo->prepare($sql1);
      $stmt1->execute([$uid,$a]);
      $resw=$stmt1->fetch();
      $actprice=$resw[0]/(1+$resw[1]/100);
      $tot[$x]=$b[$x]*$actprice;
      $tax[$x]=($tot[$x])*($resw[1]/100);
      $total=$total+($tot[$x]+$tax[$x]);	
      $x++;
	  }
    if($total<=0){
      echo "<script> alert(\"Please select the items!\");
            javascript:history.go(-1); </script>";
    }
	  try{
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		  $pdo->beginTransaction();
	    $sql="Insert into Invoice (userid,customerid,total,note) values (?,?,?,?)";
	    $stmt=$pdo->prepare($sql);
      $stmt->execute([$uid,$cname,$total,$notes]);
      $orderid=$pdo->lastInsertId();
      $_SESSION['orderid']=$orderid;
    	$x=0;
    	foreach($_POST['chk'] as $a){
        if($_POST[$a]==0)
          continue;
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
  else{
    echo "<script> alert(\"Please select the items!\");
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
            window.location='home.html'; </script>";
}
?>
</body>
</html>