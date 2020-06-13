<?php
session_start();
if(isset($_SESSION["UserId"]) && isset($_SESSION["company"])){
?>
<html lang="en">
  <head>
    <title>Invoice Generator - Add Customer</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
       <SCRIPT language="javascript" src="js/rowadd.js"></SCRIPT>
  </head>
  <body>
    
    <div class="wrapper d-flex align-items-stretch">
      <nav id="sidebar">
        <div class="p-4 pt-5"><center>
          <a href="Profile.php" class="img logo rounded-circle mb-5"><i style="font-size: 90px;" class="fa fa-user-circle" aria-hidden="true"></i><br><?php echo $_SESSION['company']; ?>
</a></center>
          <ul class="list-unstyled components mb-5">
            <li>
                <a href="generatebill.php">Generate Bill&nbsp;<i class="fa fa-file-text" aria-hidden="true"></i>
</a>
            </li>
            <li>
              <a href="viewbill.php">View bill&nbsp;<i class="fa fa-file-text" aria-hidden="true"></i></a>
            </li>
           <li >
            <a href="item.php">Add Items&nbsp;
              <i class="fa fa-shopping-cart" aria-hidden="true"></i>
</a> 
           </li>
            
            
            <li>
              <a href="itemview.php">View Item&nbsp;<i class="fa fa-eye" aria-hidden="true"></i>
</a>
            </li>
<li class="active">
            <a href="#">Add Customer&nbsp;
              <i class="fa fa-shopping-cart" aria-hidden="true"></i>
</a> 
           </li>
           <li>
              <a href="customerview.php">View Customer&nbsp;<i class="fa fa-eye" aria-hidden="true"></i>
</a>
            </li>
             
            
          </ul>
<center>
 <a href="logout.php" class="btn btn-success">Sign-out&nbsp;<i class="fa fa-sign-out" aria-hidden="true"></i></a>
</center>
        </div>
      </nav>

        <!-- Page Content  -->
      <div id="content" class="p-4 p-md-5">

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <div class="container-fluid">

           <button type="button" id="sidebarCollapse" class="btn btn-primary">
<i class="fa fa-bars"></i>
              
              <span class="sr-only">Toggle Menu</span>
            </button>
            <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa fa-bars"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <a href="#" class="navbar-brand">&nbsp;&nbsp;  InvoiceGenerator</a>
            </div>
          </div>
        </nav>

        <h2 class="mb-4">Add Cusomer</h2>
        <p><div class="container">
    <form id="form1" action="customeradd.php" method="post">
        <div class="table-responsive-md">
    <TABLE id="dataTable" class="table table-hover order-list">
        <tr class="table table-active">
            <th width="10%">  </th>
            <th width="30%">Customer Name</th>
            <th width="30%">Customer Email</th>
            <th width="30%">Phone Number</th>
        </tr>
        <TR>
            <TD><INPUT type="checkbox" name="chk[]"></TD>
            <TD><INPUT type="text" name="nam[]" class="form-control" required></TD>
            <TD><INPUT type="email" name="email[]" class="form-control" required></TD>
            <td><input name="phone[]" pattern="^\d*$" maxlength="10" form="form1" class="form-control" required></td>
        </TR>
    </TABLE>
</div>
    <div class="container row">
        <div class="col-md-4">
    <button type="button" onclick="addRow('dataTable')" class="btn btn-md btn btn-info btn-block">Add Customer +</button></div>
    <div class="col-md-4">
    <button type="button" onclick="deleteRow('dataTable')" class="btn btn-md btn btn-danger btn-block">Delete Customer -</button></div>
    <div class="col-md-4">
    <button type="submit" class="btn btn-md btn btn-success btn-block">Submit</button></div>
</div></p>
      </div>
        </div>
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <script>
        $(document).on('keydown', 'input[pattern]', function(e){
  var input = $(this);
  var oldVal = input.val();
  var regex = new RegExp(input.attr('pattern'), 'g');

  setTimeout(function(){
    var newVal = input.val();
    if(!regex.test(newVal)){
      input.val(oldVal); 
    }
  }, 0);
});
</script>
<?php
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
