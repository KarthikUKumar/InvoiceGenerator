<html>
<head>
    <title>Invoice Generator - Logout</title>
</head><body>
<?php
session_start();
session_unset();
session_destroy();
echo "<script> alert(\"Suuccessfully Logged out\");
window.location='home.html'; </script>";
?>
</body>
</html>