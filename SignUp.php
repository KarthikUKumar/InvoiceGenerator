<?php
$d=pg_connect("host=ec2-23-22-156-110.compute-1.amazonaws.com port=5432 dbname=dc71h5v4qsc5iq user=dmnsyiybmedxbz password=943ba26baf8eb1c6c0898f6e8771e492807a6ed312e5351c7c8d54806ac000c0 sslmode=require") or die ("ERROR connecting to Cloud database!");
$gst=pg_escape_string($_POST["gstin"]);
$company=pg_escape_string($_POST["company"]);
$email=pg_escape_string($_POST["uemail"]);
$address=pg_escape_string($_POST["address"].$_POST["address2"]);
$State=pg_escape_string($_POST["State"]);
$Country=pg_escape_string($_POST["Country"]);
$phone=pg_escape_string($_POST["Phone"]);
$pw=pg_escape_string($_POST["pwd1"]);
if(isset($_POST["UEmail"]) && isset($_POST["Company"]) && !empty($_POST["pwd1"]))
{
	
    if(pg_query($d,"Insert into User_Detail values(default,'$gst','$email',sha1('$pw'),'$address','$State','$Country','$phone')"))
    {
    	print("Created Successfully.");
        //header('location:LoginPageI.php');
        //exit; 
    }
    else
    {
    	print("error");
        //header('location:SignUpI.php');
        //exit;    
    }    
    pg_close($d);
}
?>
