<?php 
session_start();
$U_ID=$_SESSION['username'];
$U_TYPE=$_SESSION['type'];
if(!$_SESSION['mega2018'])
{         
printf("<script>location.href='index.php'</script>");
}?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Receipt Voucher</title>
<link rel="shortcut icon" href="assets/img/icon.png" type="image/png">
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
<meta content="" name="description" />
<meta content="" name="author" />
</head>
<body>
<!-- menu Bar-->
<?php 
include("header.php");
?>
<!-- End menu Bar-->
<div class="wrapper">
<div class="container">
<div class="panel panel-primary" data-collapsed="0">
<div class="panel-heading">
<div class="panel-title">
<h4>Receipt Voucher</h4>
</div>
</div>
<div class="panel-body">
<?php
$query_max = Run("SELECT MAX(VOUCHER_NO) AS NO from RECEIPT");
$x = mssql_fetch_object($query_max);
$id = $x->NO+1;
?>
<form role="form" id="form_new" action="receipt/save.php" enctype="multipart/form-data" onsubmit="return checkvalidation();" method="post" class="validate form-horizontal form-groups-bordered">
<div class="form-group">
<div class="col-sm-offset-2 col-sm-3">
<table class="big-font-table table table-bordered table-stripped" >
<tr>
<td>
<button type="button" id="backward" class="btn btn-default waves-effect waves-light"><i class="fa fa-arrow-left"></i></button>
</td>
<td>
<button type="button" id="refresh" class="btn btn-inverse waves-effect waves-light"><i class="fa fa-refresh"></i></button>
</td>
<td>
<button type="button" id="forward" class="btn btn-default waves-effect waves-light"><i class="fa fa-arrow-right"></i></button>
</td>
<td>
<button type="button" id="print"  class="btn btn-info waves-effect waves-light"><i class="fa fa-print"></i></button>
</td>
<?php
$rights_validation=Run("SELECT * FROM LOGIN WHERE USERNAME='$U_ID'");
$fetch_rights = mssql_fetch_object($rights_validation);
if($fetch_rights->DELETE_VR=='YES' || $U_TYPE==0)
{
?>
<td>
<button type="button" id="delete"  class="btn btn-danger waves-effect waves-light"><i class="fa fa-trash-o"></i></button>
</td>
<?php
}
?>
</tr>
</table>
</div>
</div>
<div class="form-group">
<label class="col-sm-2 control-label" style="color:black;">Voucher No:<span id="star">*</span></label>
<div class="col-sm-2">
<input type="text" class="form-control" value="<?php echo $id ?>" id="voucher_no"  name="voucher_no" required>
<input type="hidden" class="form-control" value="<?php echo $id ?>" id="max_voucher_no"  name="max_voucher_no">
</div>
</div>
<div id="reload_voucher">
<div class="form-group">
<label class="col-sm-2 control-label" style="color:black;">Voucher Date:<span id="star">*</span></label>
<div class="col-sm-2">
<input type="text" class="form-control" value="<?php echo date('d/m/Y') ?>" id="voucher_date"  name="voucher_date" required="required">
</div>
<div class="col-sm-2">
<button type="submit" id="submit" name="submit" class="btn btn-success waves-effect waves-light"><i class="fa fa-check"></i> Save</button>
<a href="home.php"><button type="button" class="btn btn-danger waves-effect waves-light"><i class="fa fa-remove"></i> Cancel</button></a>
</div>
</div>
<div class="form-group">
<label class="col-sm-2 control-label" style="color:black;">Debit Account Code:<span id="star">*</span></label>
<div class="col-sm-5">
<input type="text" class="form-control"  id="account_code" readonly  value="" placeholder="Enter Account Code"name="account_code" required="required">
<span id="account_code_error"> </span>
</div>
</div>
<div class="form-group">
<label class="col-sm-2 control-label" style="color:black;">Debit Account Name:<span id="star">*</span></label>
<div class="col-sm-5">
<select class="form-control select2" data-allow-clear="true" name="account_name"  id="account_name" onchange="document.getElementById('account_code').value=this.value;">
<option value="">Please Select Account</option>
<?php
$query_account=Run("SELECT * FROM ACCOUNT WHERE ATYPE IN ('0','1')");
while($fetch_account=mssql_fetch_object($query_account))
{
$a=$fetch_account->ACCOUNTCODE;
$b=$fetch_account->ACCOUNTNAME;
?>
<option value="<?php echo $a ?>"><?php echo $b?></option>
<?php 
}
?>
</select>
</div>
</div>
<table class="table table-bordered table-stripped" >
<tr>
<th style="width:10%;" id="custom-table-head">Party Code</th>
<th style="width:30%" id="custom-table-head">Party Name</th>
<th style="width:30%" id="custom-table-head">Description</th>
<th style="width:20%" id="custom-table-head">Amount</th>
<th id="custom-table-head">Actions</th>
</tr>
<tr>
<td>
<input type="text" class="form-control" id="code_s"  name="code_s" placeholder="Code" readonly>
<span id="code_s_error"></span>
</td>
<td>
<select  class="form-control select2" data-allow-clear="true" name="party_name_s"  id="party_name_s" onchange="document.getElementById('code_s').value=this.value;">
<option value="">Please Select Party</option>
<?php
$query_party=Run("SELECT * FROM PARTY WHERE PARTYTYPE='Customer' ORDER BY PARTYNAME ASC");
while($fetch_party=mssql_fetch_object($query_party))
{
$a=$fetch_party->PARTYCODE;
$b=$fetch_party->PARTYNAME;
?>
<option value="<?php echo $a ?>"><?php echo $b?></option>
<?php 
}
?>
</select>
</td>
<td>
<input type="text" class="form-control" id="description_s"  name="description_s" placeholder="Description">
</td>
<td>
<input type="text" class="form-control" id="amount_s"  name="amount_s" placeholder="(Rs.)">
<span id="amount_s_error"></span>
</td>
<td>
<button type="button" class="typcn typcn-plus btn btn-block btn-default waves-effect waves-light" onClick="generate_row()"> Add Row</button>
</td>
</tr>
<input type="hidden" class="form-control" id="row_number"  name="row_number" value="1"readonly>
</table>
<div id="show_tables">
</div>
<table class="table table-condensed table-bordered table-hover table-striped" >
<tr>
<th style="width:70%;text-align:right">Total Amount:</th>
<th style="width:20%"><input type="text" class="form-control" id="totalamount"  name="totalamount" value="0" readonly></th>
<th></th>
</tr>
</table>
</div>
</form>
</div>
</div>
<!-- Footer -->
<footer class="footer text-right">
<div class="container">
<div class="row">
<div class="col-xs-6">
Lahore Garrison University @ 2018. All rights reserved.
</div>
</div>
</div>
</footer>
<!-- End Footer -->
</div>
</div>
<div class="modal fade" id="details_modal">
<div class="modal-dialog" style="width:45%;">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h4 class="modal-title">Details</h4>
</div>
<div class="modal-body" id="details">
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>
<div class="modal fade" id="edit_modal">
<div class="modal-dialog" style="width:70%">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h4 class="modal-title">Edit</h4>
</div>
<div class="modal-body" id="edit">
<table class="table table-bordered table-stripped" >
<tr>
<th style="width:10%;">Party Code</th>
<th style="width:30%">Party Name</th>
<th style="width:30%">Description</th>
<th>Amount</th>
</tr>
<tr>
<td>
<input type="text" class="form-control" id="code"  name="code" placeholder="Code" readonly>
<span id="code_edit_error"></span>
</td>
<td>
<select  class="form-control select2" data-allow-clear="true" name="party_name"  id="party_name" onchange="document.getElementById('code').value=this.value;">
<option value="">Please Select Party</option>
<?php
$query_party=Run("SELECT * FROM PARTY WHERE PARTYTYPE='Customer' ORDER BY PARTYNAME ASC");
while($fetch_party=mssql_fetch_object($query_party))
{
$a=$fetch_party->PARTYCODE;
$b=$fetch_party->PARTYNAME;
?>
<option value="<?php echo $a ?>"><?php echo $b?></option>
<?php 
}
?>
</select>
</td>
<td>
<input type="text" class="form-control" id="description"  name="description" placeholder="Description">
</td>
<td>
<input type="text" class="form-control" id="amount"  name="amount" placeholder="(Rs.)">
<span id="amount_edit_error"></span>
</td>
</tr>
<input type="hidden" class="form-control" id="row_no"  name="row_no"  readonly>
</table>
<div class="form-group">
<div class="col-sm-offset-5 col-sm-5">
<button type="button" class="btn btn-warning waves-effect waves-light" Onclick="update_row()">Update</button>
<a data-dismiss="modal"><button type="button" class="btn btn-danger waves-effect waves-light">Cancel</button></a>
</div>
</div>
</div>
</div>
</div>
</div>  


<div class="modal fade" id="delete_modal">
<div class="modal-dialog" style="width:70%">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h4 class="modal-title">Delete</h4>
</div>
<div class="modal-body" id="delete">
<table class="table table-bordered table-stripped" >
<tr>
<th style="width:10%;">Party Code</th>
<th style="width:30%">Party Name</th>
<th style="width:30%">Description</th>
<th>Amount</th>
</tr>
<tr>
<td>
<input type="text" class="form-control" id="dcode"  name="dcode" placeholder="Code" readonly >
</td>
<td>
<input type="text" class="form-control" id="dparty_name"  name="dparty_name" placeholder="Code" readonly >
</td>
<td>
<input type="text" class="form-control" id="ddescription"  readonly name="ddescription" placeholder="Unit" >
</td>
<td>
<input type="text" class="form-control" id="damount"  name="damount" placeholder="(Rs.)" readonly>
</td>
</tr>
<input type="hidden" class="form-control" id="drow_no"  name="drow_no"  readonly>
</table>
<div class="form-group">
<div class="col-sm-offset-5 col-sm-5">
<button type="button" class="btn btn-warning waves-effect waves-light" Onclick="remove_row()">Delete</button>
<a data-dismiss="modal"><button type="button" class="btn btn-danger waves-effect waves-light">Cancel</button></a>
</div>
</div>
</div>
</div>
</div>
</div> 
<div class="modal fade" id="print_modal">
<div class="modal-dialog"  style="width:100%">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h4 class="modal-title">Print</h4>
</div>
<div class="modal-body" id="print_body">
</div>
</div>
</div>
</div>  
<link href="assets/plugins/select2/select2.css" rel="stylesheet" type="text/css" />
<script src="assets/plugins/select2/select2.min.js" type="text/javascript"></script>
<script src="assets/plugins/notifyjs/dist/notify.min.js"></script>
<script src="assets/plugins/notifications/notify-metro.js"></script>
<link href="assets/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
<link href="assets/plugins/datatables/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css"/>
<script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="assets/plugins/datatables/dataTables.bootstrap.js"></script>
<script src="assets/plugins/bootstrap-inputmask/bootstrap-inputmask.min.js" type="text/javascript"></script>

<script src="receipt/function.js" id="script-resource-8"></script>
<script src="receipt/row.js" id="script-resource-8"></script>
<?php
if($_GET['popup']=='yes')
{
?>
<script>
$.Notification.autoHideNotify('success', 'bottom left','Well Done, God Job!','Voucher Successfully Saved !');
</script>
<?php
}
if($_GET['popup']=='no')
{
?>
<script>
$.Notification.autoHideNotify('error', 'bottom left','Well Done, God Job!','Voucher Successfully Deleted !');
</script>
<?php
}
?>
<script>
$(".select2").select2();
$(".select2-limiting").select2({
maximumSelectionLength: 2
});
</script>

</body>
</html>