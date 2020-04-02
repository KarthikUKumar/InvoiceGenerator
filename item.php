<?php
session_start();
?>
<HTML>
<HEAD>
    <TITLE>Invoice Generator - Add Item</TITLE>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <SCRIPT language="javascript" src="rowadd.js"></SCRIPT>
</HEAD>
<BODY><center>
   <h1>Welcome <?php echo $_SESSION['company']; ?></h1>
   <h4>Add Items</h4></center>
    <div class="container">
    <form id="form1" action="itemadd.php" method="post">
    <TABLE id="dataTable" class="table order-list">
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
    <INPUT type="button" value="Delete Row -" onclick="deleteRow('dataTable')" class="btn btn-md btn btn-danger col-sm-3">
    <div class="col-sm-1"></div>
    <input type="submit" value="Submit" class="btn btn-md btn btn-success col-sm-3">
    <br><br><br>
    To View Items <a href="itemview.php">Click Here</a>
</div>
</BODY>
</HTML>
