<?php
session_start();
try
{
	$i=0;
	$flag=1;
	$pdo=new PDO("pgsql:host=ec2-23-22-156-110.compute-1.amazonaws.com;port=5432;dbname=dc71h5v4qsc5iq","dmnsyiybmedxbz","943ba26baf8eb1c6c0898f6e8771e492807a6ed312e5351c7c8d54806ac000c0");
	$name=$_POST['nam'];
	$price=$_POST['price'];
	$gst=$_POST['gst'];
	$desc=$_POST['desc'];
	foreach($name as $a => $b){
		$i++;
		$sql="Insert into Item (user_id,iname,idesc,price_p_item,gstpercent) values (?,?,?,?,?)";
        $stmt=$pdo->prepare($sql);
        $stmt->execute([$_SESSION['UserId'],$name[$a],$desc[$a],$price[$a],$gst[$a]]);
	    if($stmt->errorCode()==0){
            //header('location:LoginPageI.php');
            //exit;  
	    }
        else{
        	$flag=0;
        	$error=$stmt->errorInfo();
    	    echo $error[2]."Sorry! Please correct the error in $i record";//add danger alert for this.-Faraz
    	    //header('location:SignUpI.php');
            //exit;
    	}  
    	if($flag==0){
    		$pdo->rollback();
    		break;
    	}
    }
    if($flag==1){
    	echo "Inserted $i records Successfully";
    }
}
catch(PDOException $e){
	echo "Connection Failed\n".$e->getMessage();
	$pdo=null;
}
?>