<?php
session_start();
$d=pg_connect("host=ec2-23-22-156-110.compute-1.amazonaws.com port=5432 dbname=dc71h5v4qsc5iq user=dmnsyiybmedxbz password=943ba26baf8eb1c6c0898f6e8771e492807a6ed312e5351c7c8d54806ac000c0 sslmode=require") or die("Error connecting to Cloud");
$e=pg_escape_string($_POST["email"]);
$p=pg_escape_string($_POST["password"]);
if(isset($_POST["email"]) && isset($_POST["password"]))
{
    $pasw=pg_query($d,"select Password,UserId,UEmail from User_Details where UEmail='$e'");
    if(pg_num_rows($pasw)<0)
    {
    	echo "<h1>Invalid Email-Id</h1>";
    }
    else
    {
    	$psw=pg_fetch_array($pasw,0,PGSQL_NUM);
	    if(sha1($p)==$psw[3])
	    {
	    	$_SESSION["UserId"]=$psw[0];
	    	printf("Login Successful.and UserId=%d",$_SESSION['UserId']);
            //header("Location:WebHome.php");
            //exit;
        }
        else
        {
        	session_unset();
        	session_destroy();
	        //header("Location:LoginPageI1.php");
            //exit;
        }
    }
}
else
{
	echo "";
}
pg_close($d);
?>