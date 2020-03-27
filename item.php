<?php
session_start();
?>
<HTML>
<HEAD>
    <TITLE>Invoice Generator</TITLE>
 <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<style>
.navy {
    -webkit-box-shadow: 0 8px 6px -6px #999;
    -moz-box-shadow: 0 8px 6px -6px #999;
    box-shadow: 0 8px 6px -6px #999;
 
    /* the rest of your styling */
}
</style>
    <SCRIPT language="javascript" src="rowadd.js"></SCRIPT>
</HEAD>
<BODY>
 <nav class="navbar navbar-inverse navy" >
  <div class="container-fluid" >
    <div class="navbar-header">
      <a class="navbar-brand" href="#">InvoiceGenerator</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="#">Home</a></li>
      <li><a href="#">Page 1</a></li>
      <li><a href="#">Page 2</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="#"><span class="glyphicon glyphicon-user"></span>Profile</a></li>
      <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
    </ul>
  </div>
</nav> 
<center>
   <h1>Welcome <? echo '$_SESSION["Company"]'; ?></h1>
   <h4>Add Items</h4></center>
    <div class="container">
    <form id="form1" action="itemadd.php" method="post">
    <TABLE id="dataTable" class="table table-striped table-hover order-list">
        <tr>
            <td class="col-sm-1"></td>
            <td class="col-sm-3">Name</td>
            <td class="col-sm-4">Description</td>
            <td class="col-sm-2">Price/Item</td>
            <td class="col-sm-2">Gst</td>
        </tr>
        <TR>
            <TD class="col-sm-1"><INPUT type="checkbox" name="chk[]"></TD>
            <TD class="col-sm-3"><INPUT type="text" name="nam[]" class="form-control"></TD>
            <td class="col-sm-4"><textarea row="0" cols="50" form="form1" name="desc[]" class="form-control"></textarea></td>
            <td class="col-sm-2"><input name="price[]" pattern="^\d*(\.\d{0,2})?$" form="form1" class="form-control"></td>
            <TD class="col-sm-2">
                <SELECT name="gst[]" form="form1" class="form-control">
                    <OPTION value="0" class="form-control">Nil</OPTION>
                    <OPTION value="5" class="form-control">5%</OPTION>
                    <OPTION value="12" class="form-control">12%</OPTION>
                    <OPTION value="18" class="form-control">18%</OPTION>
                    <OPTION value="24" class="form-control">24%</OPTION>
                </SELECT>
            </TD>
        </TR>
    </TABLE>
    <div class="col-sm-1"></div>
    <INPUT type="button" value="Add Row +" onclick="addRow('dataTable')" class="btn btn-md btn btn-info col-sm-3">
    <div class="col-sm-1"></div>
    <INPUT type="button" value="Delete Row -" onclick="deleteRow('dataTable')" class="btn btn-md btn btn-danger col-sm-3

">
    <div class="col-sm-1"></div>
    <input type="submit" value="Submit" class="btn btn-md btn btn-success col-sm-3">
</div>
</BODY>
</HTML>
