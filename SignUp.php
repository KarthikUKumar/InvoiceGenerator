<html>
<head>
    <title>Invoice Generator - Create an Account</title>
</head><body>
<?php
session_start();
try
{
    $pdo=new PDO("pgsql:host=ec2-23-22-156-110.compute-1.amazonaws.com;port=5432;dbname=dc71h5v4qsc5iq","dmnsyiybmedxbz","943ba26baf8eb1c6c0898f6e8771e492807a6ed312e5351c7c8d54806ac000c0");
    $gst=$_POST["gstin"];
    $pin=$_POST["PinCode"];
    $company=$_POST["company"];
    $email=$_POST["uemail"];
    $address=$_POST["address"].", ".$_POST["Address2"];
    $State=$_POST["State"];
    $Country=$_POST["Country"];
    $phone=$_POST["Phone"];
    $pw=$_POST["pwd1"];
    $sql="Insert into User_Detail (gstin_no,uemail,password,company,uaddress,ustate,ucountry,phone_no,PinCode) values (?,?,?,?,?,?,?,?,?)";
    $stmt=$pdo->prepare($sql);
    $stmt->execute([$gst,$email,md5($pw),$company,$address,$State,$Country,$phone,$pin]);
    if($stmt->errorCode()==0){
        echo "<script> alert(\"Account Created Successfully\");
        window.location='home.html'; </script>"; 
    }
    else{
        $error=$stmt->errorInfo();
        echo "<script> alert(\"Sorry! there is an error - $error \");
        window.location='home.html'; <script>";
    }       
}
catch(PDOException $e){
    session_unset();
    session_destroy();
    echo "<script> alert(\"Connection Failed - ".$e->getMessage()." \");
    window.location='home.html'; <script>";
    $pdo=null;
}
?>
</body>
</html>