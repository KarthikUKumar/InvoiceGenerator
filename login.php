<?php
session_start();
try
{
	$pdo=new PDO("pgsql:host=ec2-23-22-156-110.compute-1.amazonaws.com;port=5432;dbname=dc71h5v4qsc5iq","dmnsyiybmedxbz","943ba26baf8eb1c6c0898f6e8771e492807a6ed312e5351c7c8d54806ac000c0");
	$em=$_POST["email"];
    $pas=$_POST["password"];
    $sql="select Password,UserId,UEmail from User_Detail where UEmail=? Limit 1";
    $stmt=$pdo->prepare($sql);
    $stmt->execute([$em]);
    if($stmt->rowCount()!=0){
    	$res=$stmt->fetch();
    	if($res['password']==md5($pas))
    	{
    		echo "Successfully logged in.";
    		$_SESSION["UserId"]=$res['userid'];
    		//header('location:LoginPageI.php');
            //exit;uncomment these Faraz
    	}
    	else{
    		session_unset();
    		session_destroy();
    		echo "Incorrect password!";
    		//header('location:LoginPageI.php');
            //exit;uncomment these Faraz
    	}
    }
    else{
    	session_unset();
    	session_destroy();
    	echo "Please create an account ";//add a link here Faraz.
    }

}
catch(PDOException $e){
	session_unset();
    session_destroy();
	echo "Connection Failed\n".$e->getMessage();
	$pdo=null;
} 
?>
