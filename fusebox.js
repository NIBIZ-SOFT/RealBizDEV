var nowform=1;

function fieldLoad(page){
	nowform++;
	$('#productNameTable').append('<div id="moreLoad'+nowform+'" style="text-align:left;"></div>');	
	$('#moreLoad'+nowform).load('index.php?Theme=default&Base='+page+'&Script=fieldloader&nextrindx='+nowform);
	SetAllVend();
}

function calculateBuyPrice(qty,vwid,indx){
	var totalprice=qty*$('#'+vwid+indx).val();
	$('#'+vwid+indx).val(totalprice);
	viewTotalPrice();
}

function calculateBuyPrice2(qty,price,indx){
	var totalprice=price*$('#'+qty+indx).val();
	$('#Price'+indx).val(totalprice);
	viewTotalPrice();
	
}



function fieldRemove(){	
	
	$('#moreLoad'+nowform).remove();
	nowform--;	
	
}

function fieldRemoveOne(id){	
	
	$('#moreLoad'+id).remove();
	//nowform--;	
	
}

function viewTotalPrice(){
			    var TotalPrice=0;
				for(var k=1; k<=nowform; k++){
						
					if (document.getElementById("Price"+k)) {
					 var price=$("#Price"+k).val();							
						if(price!=null && price!=''){
						  TotalPrice+=parseFloat(price);
						}
					}
				
				}	
				
								
				$("#TotalPrice").val(TotalPrice)
				$("#TotalPriceView").html(TotalPrice);
				
				
			
			   }
			   
function PaidDueCalc(){
			   
			   	var totalprice=parseFloat($("#TotalPrice").val());
				var paidPrice=$("#PaidAmount").val();
				var DueAmount=totalprice-paidPrice;
				$("#DueAmount").val(DueAmount)
			   
			   }
function SetAllVend(){
	               selIndx=document.getElementById("VendorName1").selectedIndex;
					for(var k=1; k<=nowform; k++){
										
						if(document.getElementById("VendorName"+k)){
						  document.getElementById("VendorName"+k).selectedIndex=selIndx;						  								
						}
								
					}	
					
				}
				
				
				function AddPurchasePay(){
					
				  var r=confirm("Are you confirm?");
				  
				  if(document.getElementById('due').checked==true){
				    var payMethod="cash";
					var PaidAmount=$('#PaidAmount').val();
				  }				
				  
				  if(document.getElementById('cheque').checked==true){
				    var payMethod='cheque';
					var PaidAmount=$('#PaidAmountbycheck').val();
				  }
				  
				   				 
				  var DueAmount=$('#DueAmount').val();
				  var duedate=$('#datepicker2').val();
				  var checkno=$('#checkno').val();
                  var bankname=$('#bankname').val();
				  var checkdate=$('#datepicker1').val();
				  var TotalAmount=$('#TotalPrice').val();
				  
				  
				    if (r==true)
					  {
					    $.post('index.php?Theme=default&Base=Purchase&Script=fieldloader&NoHeader&NoFooter&purchasepay=yes&purchasepaytableid='+document.getElementById('purchasepaytableid').value+'&PaymentMethod='+payMethod+'&PaidAmount='+PaidAmount+'&duedate='+duedate
						+'&DueAmount='+DueAmount+'&checkno='+checkno+'&bankname='+bankname+'&TotalAmount='+TotalAmount+'&checkdate='+checkdate, function(data) {
                         var prevPayINfo=data;
						  
						  $('#payINfo').html(prevPayINfo);
                        });
					  }
					else
					  {
					     //alert("You pressed Cancel!")
					  }
					
				
				}