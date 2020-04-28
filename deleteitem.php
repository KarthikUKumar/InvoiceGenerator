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
	if(isset($_POST['chk'])){
		$i=0;
		try{
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    $pdo->beginTransaction();
		    foreach($_POST['chk'] as $a){
		    	$sql="delete from Item where user_id=? and itemcode=?";
			    $stmt=$pdo->prepare($sql);
                $stmt->execute([$uid,$a]);
                $i++;
            }
            $pdo->commit();
            echo "<script> alert(\"Deleted $i items successfully.\");
                window.location='itemview.php'; </script>";
        }
        catch(Exception $error){
        	echo "<script> alert(\"Sorry something went wrong!\");
            javascript:history.go(-1); </script>";
        }
    }
    else{
    	echo "<script> alert(\"Please select the Items to Delete!\");
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