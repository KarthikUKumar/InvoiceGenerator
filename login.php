<html>
<head>
    <title>Invoice Generator - Login</title>
</head><body>
<?php
session_start();
try
{
	$pdo=new PDO("pgsql:host=ec2-23-22-156-110.compute-1.amazonaws.com;port=5432;dbname=dc71h5v4qsc5iq","dmnsyiybmedxbz","943ba26baf8eb1c6c0898f6e8771e492807a6ed312e5351c7c8d54806ac000c0");
	$em=$_POST["email"];
    $pas=$_POST["password"];
    $sql="select Password,UserId,UEmail,company from User_Detail where UEmail=? Limit 1";
    $stmt=$pdo->prepare($sql);
    $stmt->execute([$em]);
    if($stmt->rowCount()!=0){
    	$res=$stmt->fetch();
    	if($res['password']==md5($pas))
    	{
    	
    		$_SESSION["UserId"]=$res['userid'];
            $_SESSION["company"]=$res['company'];
            echo "<script> alert(\"Successfully Logged in\");
            window.location='itemview.php'; </script>";
    		
    	}
    	else{
    		session_unset();
    		session_destroy();
    		echo "<script> alert(\"Enter a correct Password.\");
            window.location='index.html'; </script>";
    		
    	}
    }
    else{
    	session_unset();
        session_destroy();
    	echo "<script> alert(\"Please create an account\");
        window.location='index.html';  </script>";
    }

}
catch(PDOException $e){
	session_unset();
    session_destroy();
    echo "<script> alert(\"Connection Failed - \"".$e->getMessage()."\");
        window.location='index.html'; </script>";
    $pdo=null;
} 
?>
</body>
</html>
