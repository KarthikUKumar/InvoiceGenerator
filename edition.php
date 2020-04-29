<?php
session_start();
?>
<HTML>
<HEAD>
    <TITLE>Invoice Generator - Editing</TITLE>
</HEAD><body>
<?php
if(isset($_SESSION["UserId"]) && isset($_SESSION["company"]) && $_SESSION["gst"]){
  try
  {
    $pdo=new PDO("pgsql:host=ec2-23-22-156-110.compute-1.amazonaws.com;port=5432;dbname=dc71h5v4qsc5iq","dmnsyiybmedxbz","943ba26baf8eb1c6c0898f6e8771e492807a6ed312e5351c7c8d54806ac000c0");
    $uid=$_SESSION['UserId'];
    if(isset($_POST['sub'])){
      $name=$_POST['name'];
      $desc=$_POST['desc'];
      $gst=$_POST['gst'];
      $price=$_POST['price'];
      $id=$_SESSION['itemcode'];
      try{
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->beginTransaction();
        $swl="update Item set iname=?,idesc=?,price_p_item=?,gst=? where itemcode=? and user_id=?";
        $smt=$pdo->prepare($swl);
        $smt->execute([$name,$desc,$price,$gst,$id,$uid]);
        $pdo->commit();
        echo "<script> alert(\"Updation Successful.\");
            window.location='itemview.php'; </script>";
        }
      catch(Exception $e){
        $pdo->rollback();
        echo "<script> alert(\"Updation failed\");
            javascript:history.go(-1); </script>";
      }
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
</HTML>