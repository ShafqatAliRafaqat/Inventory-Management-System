<?php 
session_start();
$U_ID=$_SESSION['username'];
$U_TYPE=$_SESSION['type'];
if(!$_SESSION['mega2018'])
{         
printf("<script>location.href='index.php'</script>");
}
include("../connection.php");
?>
<table class="table table-bordered datatable" id="table-1">
<thead>
<tr>
<th>Sr.No</th>
<th>Username</th>
<th>Type</th>
<th>Actions</th>
</tr>
</thead>
<tbody>
<?php
$query = Run("SELECT * FROM LOGIN WHERE USERNAME <>'$U_ID' ORDER BY USERNAME ASC");
$srno =1;
while($rec = mssql_fetch_object($query))
{
$id=$rec->USERNAME;
$type=$rec->TYPE;
if($type==0)
{
$c='ADMIN';
}
else
{
$c='USER';
}
echo '
<tr>
<td>'.$srno.'</td>
<td>'.$rec->USERNAME.'</td>
<td>'.$c.'</td>
';
?>
<td class="center" align="center">
<div class="btn-group">
<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
Action <span class="caret"></span>
</button>
<ul class="dropdown-menu dropdown-blue" role="menu">
<li><a href="javascipt:void(0);" onclick="details_data('<?php echo $id?>')" ><i class="fa fa-eye"></i> Details</a>
</li>
<li class="divider"></li>
<li><a href="javascipt:void(0);" onclick="edit_data('<?php echo $id?>')"><i class="fa fa-pencil"></i> Edit</a>
</li>
<li class="divider"></li>
<li><a href="javascipt:void(0);" onclick="delete_data('<?php echo $id?>')"><i class="fa fa-trash-o"></i> Delete</a>
</li>
</ul>
</div>
</td>			
<?php 
echo'
</tr>';
$srno++;
}
?>
</tbody>
</table>
<script>
jQuery(document).ready(function($)
{
$('#table-1').dataTable();
});
</script>
