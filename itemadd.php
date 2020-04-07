<HTML>
<HEAD>
    <TITLE>Invoice Generator - Add Item</TITLE>
</HEAD><body>
<?php
session_start();
try
{
	$flag=1;
	$pdo=new PDO("pgsql:host=ec2-23-22-156-110.compute-1.amazonaws.com;port=5432;dbname=dc71h5v4qsc5iq","dmnsyiybmedxbz","943ba26baf8eb1c6c0898f6e8771e492807a6ed312e5351c7c8d54806ac000c0");
	$name=$_POST['nam'];
	$price=$_POST['price'];
	$gst=$_POST['gst'];
	$desc=$_POST['desc'];
	foreach($name as $a => $b){
		$sql="Insert into Item (user_id,iname,idesc,price_p_item,gstpercent) values (?,?,?,?,?)";
        $stmt=$pdo->prepare($sql);
        $stmt->execute([$_SESSION['UserId'],$name[$a],$desc[$a],$price[$a],$gst[$a]]);
	    if($stmt->errorCode()==0){
	    }
        else{
        	$flag=0;
        	$error=$stmt->errorInfo();
    	}  
    	if($flag==0){
    		$pdo->rollback();
            echo "<script> alert(\" ".$error[2]."Sorry! Please correct the errors in ".$a." record \");
            window.location='item.php'; </script>";
    		break;
    	}
    }
    if($flag==1){
        $a++;
    	echo "<script> alert(\"Inserted ".$a." records Successfully\");
        window.location='itemview.php'; </script>";
    }
}
catch(PDOException $e){
	echo "<script> alert(\"Connection Failed - ".$e->getMessage()." \");
        window.location='item.php'; </script>";
	$pdo=null;
}
?></body>
</HTML>
