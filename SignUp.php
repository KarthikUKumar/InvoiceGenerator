<html>
<head>
    <title>Invoice Generator - Create an Account</title>
</head>
<body>
<?php
try
{
    $pdo=new PDO("pgsql:host=ec2-23-22-156-110.compute-1.amazonaws.com;port=5432;dbname=dc71h5v4qsc5iq","dmnsyiybmedxbz","943ba26baf8eb1c6c0898f6e8771e492807a6ed312e5351c7c8d54806ac000c0");
    $gst=$_POST["gstin"];
    $pin=$_POST["pincode"];
    $company=$_POST["company"];
    $email=$_POST["uemail"];
    $address=$_POST["address"].", ".$_POST["Address2"];
    $state=$_POST["State"];
    $country=$_POST["Country"];
    $phone=$_POST["Phone"];
    $pw=$_POST["pwd1"];
    try{
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->beginTransaction();
        $sql="Insert into User_Detail (gstin_no,uemail,password,company,uaddress,ustate,ucountry,phone_no,pincode) values (?,?,?,?,?,?,?,?,?)";
        $stmt=$pdo->prepare($sql);
        $stmt->execute([$gst,$email,md5($pw),$company,$address,$state,$country,$phone,$pin]);
        $pdo->commit();
        echo "<script> alert(\"Account Created Successfully.Please Sign In with your Credentials.\");
                window.location='index.php'; </script>";
        //echo 'Account created';
    }
    catch(Exception $e){
        $pdo->rollback();
        //echo "Sorry Problem Occured.";
        echo "<script> alert(\"Sorry! there is an error!\");
            javascript:history.go(-1); </script>";
    }       
}
catch(PDOException $e){
    echo "<script> alert(\"Connection Failed - ".$e->getMessage()." \");
    window.location='home.html'; </script>";
    $pdo=null;
}
?>
</body>
</html>