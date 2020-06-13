<HTML>
<HEAD>
    <TITLE>Invoice Generator - Add Customer</TITLE>
</HEAD><body>
<?php
session_start();
if(isset($_SESSION["UserId"]) && isset($_SESSION["company"])){
try
{
	$pdo=new PDO("pgsql:host=ec2-23-22-156-110.compute-1.amazonaws.com;port=5432;dbname=dc71h5v4qsc5iq","dmnsyiybmedxbz","943ba26baf8eb1c6c0898f6e8771e492807a6ed312e5351c7c8d54806ac000c0");
    $uid=$_SESSION['UserId'];
        $name=$_POST['nam'];
        $email=$_POST['email'];
	    $phone=$_POST['phone'];
        $i=0;
        $flag=1;
        try{
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->beginTransaction();
	        foreach($name as $a => $b){
                $i++;
                $sql="Insert into Customer (c_name,cemail,phone,userid) values (?,?,?,?)";  
                $stmt=$pdo->prepare($sql);
                $stmt->execute([$name[$a],$email[$a],$phone[$a],$uid]);
            }
            $pdo->commit();
                echo "<script> alert(\"Inserted ".($a+1)." Items Successfully\");
                        window.location='customerview.php'; </script>";
           /* }
            elseif ($a==0) {
                echo "<script> alert(\"Modified $i Items Successfully\");
                        window.location='itemview.php'; </script>";
            }
            else{
                $i=$i-$a;
                echo "<script> alert(\"Inserted $i Items and Modified $a items Successfully\");
                        window.location='itemview.php'; </script>";
            }*/

        }
        catch(PDOException $e){
                $pdo->rollback();
                echo "<script> alert(\" $e \n Sorry! Please correct the errors.\");
                       javascript:history.go(-1); </script>";
    	    }
}
catch(PDOException $e){
    $pdo=null;
	echo "<script> alert(\"Connection Failed - ".$e->getMessage()." \");
                window.location='item.php'; </script>";
    //echo $e->getMessage();
}
?></body>
<?php
}
else{
  session_unset();
  session_destroy();
  echo "<script> alert(\"There was some internal server error.Please Login\");
            window.location='home.html'; </script>";
}
?>
</HTML>