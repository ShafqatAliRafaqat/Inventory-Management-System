$("#backward").click(function(){
var voucher_no=$("#voucher_no").val();
voucher_no--;
if(voucher_no>0)
{
$("#voucher_no").val(voucher_no);
$("#reload_voucher").html('<h1 align="center"><img src="assets/images/loading _save.gif"/></h1>');
$.post("purchase/edit.php",{
voucher_no:voucher_no 
},function(data){
$('#reload_voucher').html(data);
total_amount();
total_quantity();
calculate_discount();
});	 
}
});




function get_address(code)
{
$.ajax({
type: "POST",
url: "practice/address.php",
data:
{
code:code
},
success: function(data)
{   
$("#address").val(data);
}
});	
}
function get_data(code){
$.post("practice/data.php",{
code:code 
},function(data){
$("#unit_s").val(data.unit);
$("#rate_s").val(data.purchaserate);
calculate_amount();
},"json");
}

function get_data_edit(code){
$.post("practice/data.php",{
code:code 
},function(data){
$("#unit").val(data.unit);
$("#rate").val(data.purchaserate);
calculate_amount_edit();
},"json");
}

function edit_row(row_no)
{
$('#edit_modal').modal('show');	
var code=document.getElementById('code'+row_no).value;
var product_name=document.getElementById('product_name'+row_no).value;
var unit=document.getElementById('unit'+row_no).value;
var quantity=document.getElementById('quantity'+row_no).value;
var rate=document.getElementById('rate'+row_no).value;
var amount=document.getElementById('amount'+row_no).value;	
document.getElementById('code').value=code;
document.getElementsByClassName("select2-chosen")[2].innerHTML=product_name;
document.getElementById('unit').value=unit;
document.getElementById('quantity').value=quantity;
document.getElementById('rate').value=rate;
document.getElementById('amount').value=amount;
document.getElementById('row_no').value=row_no;
}
function update_row()
{
var a=$("#code").val();
var b=document.getElementsByClassName('select2-chosen')[2].innerHTML;
var c=$("#unit").val();
var d=$("#quantity").val();
var e=$("#rate").val();
var f=$("#amount").val();
var row_no=$("#row_no").val();
if(a!='' && d!='' && d!=0 && e!='' && e!=0 && f!='' && f!=0)
{
var code=document.getElementById('code').value;
var product_name=document.getElementsByClassName('select2-chosen')[2].innerHTML;
var unit=document.getElementById('unit').value;
var quantity=document.getElementById('quantity').value;
var rate=document.getElementById('rate').value;
var amount=document.getElementById('amount').value;
document.getElementById('code'+row_no).value=code;
document.getElementById('product_name'+row_no).value=product_name;
document.getElementById('unit'+row_no).value=unit;
document.getElementById('quantity'+row_no).value=quantity;
document.getElementById('rate'+row_no).value=rate;
document.getElementById('amount'+row_no).value=amount;
$('#edit_modal').modal('hide');
total_amount();
total_quantity();
calculate_discount();	
}
else
{
if(a=='')
{
document.getElementById('code').style.borderColor ='red';
document.getElementById('code_edit_error').innerHTML='*Enter Product Name';
document.getElementById('code_edit_error').style.color='red';
}	
if(d=='' || d==0)
{
document.getElementById('quantity').style.borderColor ='red';	
document.getElementById('quantity_edit_error').innerHTML='*Enter Quantity';
document.getElementById('quantity_edit_error').style.color='red';
}
if(e=='' || e==0)
{
document.getElementById('rate').style.borderColor ='red';	
document.getElementById('rate_edit_error').innerHTML='*Enter Rate';
document.getElementById('rate_edit_error').style.color='red';
}	
if(f=='' || f==0)
{
document.getElementById('amount').style.borderColor ='red';
document.getElementById('amount_edit_error').innerHTML='*Enter Amount';	
document.getElementById('amount_edit_error').style.color='red';	
}	
}
}
function delete_row(row_no)
{
$('#delete_modal').modal('show');	
var code=document.getElementById('code'+row_no).value;
var product_name=document.getElementById('product_name'+row_no).value;
var unit=document.getElementById('unit'+row_no).value;
var quantity=document.getElementById('quantity'+row_no).value;
var rate=document.getElementById('rate'+row_no).value;
var amount=document.getElementById('amount'+row_no).value;
document.getElementById('dcode').value=code;
document.getElementById('dproduct_name').value=product_name;
document.getElementById('dunit').value=unit;
document.getElementById('dquantity').value=quantity;
document.getElementById('drate').value=rate;
document.getElementById('damount').value=amount;
document.getElementById('drow_no').value=row_no;
}
function remove_row()
{
var drow_no=$("#drow_no").val();
document.getElementById('row'+drow_no).innerHTML="";
total_amount();
total_quantity();
calculate_discount();	
$('#delete_modal').modal('hide');	
$.Notification.autoHideNotify('error', 'bottom left', 'Good job!', 'Row Successfully Deleted')
}
function calculate_amount()
{
var qty=$("#quantity_s").val();
var rate=$("#rate_s").val();	
if(qty=='')
{
qty=0;	
}
if(rate=='')
{
rate=0;	
}
var amount= parseFloat(qty)*parseFloat(rate);
$("#amount_s").val(amount);	
}

function calculate_amount_edit()
{
var qty=$("#quantity").val();
var rate=$("#rate").val();	
if(qty=='')
{
qty=0;	
}
if(rate=='')
{
rate=0;	
}
var amount= parseFloat(qty)*parseFloat(rate);
$("#amount").val(amount);	
}

function total_amount()
{
var total_amounts=0;
$(".amount").each(function(){
var total=($(this).val());
total_amounts=parseFloat(total_amounts)+parseFloat(total);
});
$("#totalamount").val(total_amounts);	
$("#grandamount").val(total_amounts);	
}

function total_quantity()
{
var total_quantitys=0;
$(".quantity").each(function(){
var total=($(this).val());
total_quantitys=parseFloat(total_quantitys)+parseFloat(total);
});
$("#totalquantity").val(total_quantitys);	
}

function calculate_discount()
{
var discount=$("#discount").val();
var totalamount=$("#totalamount").val();
if(totalamount=='')
{
totalamount=0;	
}
if(discount=='')
{
discount=0;	
}
var total=parseFloat(totalamount)-parseFloat(discount);
$("#grandamount").val(total)
}