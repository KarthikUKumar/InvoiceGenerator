<?php
try
{
	$pdo=new PDO("pgsql:host=ec2-23-22-156-110.compute-1.amazonaws.com;port=5432;dbname=dc71h5v4qsc5iq","dmnsyiybmedxbz","943ba26baf8eb1c6c0898f6e8771e492807a6ed312e5351c7c8d54806ac000c0");
	$gst=$_POST["gstin"];
    $company=$_POST["company"];
    $email=$_POST["uemail"];
    $address=$_POST["address"].$_POST["Address2"];
    $State=$_POST["State"];
    $Country=$_POST["Country"];
    $phone=$_POST["Phone"];
    $pw="'".$_POST["pwd1"]."'";
    $sql="Insert into User_Detail (gstin_no,uemail,password,company,uaddress,ustate,ucountry,phone_no) values (?,?,?,?,?,?,?,?)";
    $stmt=$pdo->prepare($sql);
    $stmt->execute([$gst,$email,sha1($pw),$company,$address,$State,$Country,$phone]);
    if($stmt->errorCode()==0){
    	echo "Inserted Successfully";
        //header('location:LoginPageI.php');
        //exit;  
    }
    else{
    	echo $stmt->errorCode()."Sorry! there was an internal error";
    	//header('location:SignUpI.php');
        //exit;
    }  
}
catch(PDOException $e){
	echo $e->getMessage();
	$pdo=null;
}
?>
