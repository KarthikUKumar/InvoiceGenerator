<?php
session_start();
if(isset($_SESSION["UserId"]) && isset($_SESSION["company"])){
?>
<html>
<head>
    <title>Invoice Generator - Create an Account</title>
</head><body>
<?php
$uid=$_SESSION["UserId"];
try
{
    $pdo=new PDO("pgsql:host=ec2-23-22-156-110.compute-1.amazonaws.com;port=5432;dbname=dc71h5v4qsc5iq","dmnsyiybmedxbz","943ba26baf8eb1c6c0898f6e8771e492807a6ed312e5351c7c8d54806ac000c0");
    $pin=$_POST["pincode"];
    $company=$_POST["company"];
    $address=$_POST["address"];
    $State=$_POST["State"];
    $Country=$_POST["Country"];
    $phone=$_POST["cphone"];
    $sql="Update User_Detail set company='".$company."' ,uaddress='".$address."' ,ustate='".$State."' ,ucountry='".$Country."' ,phone_no='".$phone."' ,pincode='".$pin."' where userid=?";
    try{
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->beginTransaction();
        $stmt=$pdo->prepare($sql);
        $stmt->execute([$uid]);
        $pdo->commit();
        echo "<script> alert(\"Profile Updated Successfully\");
                    window.location='Profile.php'; </script>"; 
    }
    catch(PDOException $e){
        echo "<script> alert(\"Sorry! there is an error - ".$e->getMessage()." \");
        window.location='Profile.php'; <script>";
    }       
}
catch(PDOException $e){
    session_unset();
    session_destroy();
    echo "<script> alert(\"Connection Failed - ".$e->getMessage()." \");
    window.location='home.html'; <script>";
    $pdo=null;
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