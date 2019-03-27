<?php 
session_start();
$U_ID=$_SESSION['username'];
$U_TYPE=$_SESSION['type'];
if(!$_SESSION['mega2018'])
{         
printf("<script>location.href='index.php'</script>");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>User Information</title>
<link rel="shortcut icon" href="assets/img/icon.png" type="image/png">
<link href="assets/plugins/switchery/dist/switchery.min.css" rel="stylesheet" />
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
<div class="row">
<div class="col-sm-6">
<div class="panel panel-primary" data-collapsed="0">
<div class="panel-heading">
<div class="panel-title">
<h4>User Information</h4>
</div>
</div>
<div class="panel-body" id="reload_form">
<div class="row" id="loader_new">
</div>
<form role="form" id="form_new" action="javascript:save_data();" method="post" class="validate form-horizontal form-groups-bordered">
<div class="form-group">
<label class="col-sm-3 control-label" style="color:black;">Name:<span id="star">*</span></label>
<div class="col-sm-5">
<input type="text" class="form-control" id="username" placeholder="Please Enter Username" name="username" required>
</div>
</div>
<div class="form-group">
<label class="col-sm-3 control-label" style="color:black;">Password:<span id="star">*</span></label>
<div class="col-sm-5">
<input type="text" class="form-control" id="password" placeholder="Please Enter Password" name="password" required>
</div>
</div>
<div class="form-group">
<label  class="col-sm-3 control-label" style="color:black;">User Type:<span id="star">*</span></label>
<div class="col-sm-5">
<select  class="form-control select2" data-allow-clear="true" name="usertype"  id="usertype" required="required">
<option value="">Please Select Type</option>
<option value="0">ADMIN</option>
<option value="1">USER</option>
</select>
</div>
</div>
<div class="form-group">
<label  class="col-sm-3 control-label" style="color:black;">Voucher Edit:<span id="star">*</span></label>
<div class="col-sm-5">
<td>
<input type="checkbox"  name="voucher_edit" name="voucher_edit" value="YES" data-plugin="switchery" data-color="#81c868" data-size="small"/>
</td>
</div>
</div>
<div class="form-group">
<label  class="col-sm-3 control-label" style="color:black;">Voucher Delete:<span id="star">*</span></label>
<div class="col-sm-5">
<td>
<input type="checkbox"  name="voucher_delete" name="voucher_delete" value="YES" data-plugin="switchery" data-color="#81c868" data-size="small"/>
</td>
</div>
</div>
<div class="form-group">
<div class="col-sm-offset-3 col-sm-5">
<button type="submit" class="btn btn-success waves-effect waves-light">Save</button>
<a href="home.php"><button type="button" class="btn btn-danger waves-effect waves-light">Cancel</button></a>
</div>
</div>
</form>
</div>
</div>
</div>
<div class="col-sm-6">
<div class="panel panel-primary" data-collapsed="0">
<div class="panel-heading">
<div class="panel-title">
<h4>List User</h4>
</div>
</div>
<div class="panel-body" id="reload_list">
</div>
</div>
</div>
</div>
<script>
$(window).load(function()
{
$.post('user/list.php',{},function(data){
$('#reload_list').html(data);
});
});
$(document).ready(function(){
$('[data-plugin="switchery"]').each(function (idx, obj) {
new Switchery($(this)[0], $(this).data());
});		
});
</script>
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
<div class="modal-dialog">
<div class="modal-content">

<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h4 class="modal-title">Edit</h4>
</div>
<div class="modal-body" id="edit">
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
<script src="assets/plugins/switchery/dist/switchery.min.js"></script>
<script src="assets/plugins/datatables/dataTables.bootstrap.js"></script>
<script src="assets/plugins/bootstrap-inputmask/bootstrap-inputmask.min.js" type="text/javascript"></script>

<script src="user/function.js" id="script-resource-8"></script>
<script>
$(".select2").select2();
$(".select2-limiting").select2({
maximumSelectionLength: 2
});
</script>

</body>
</html>