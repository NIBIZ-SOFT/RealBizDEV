<?

$ExpenseData= SQL_Select("Bankcash");

// echo "<pre>";
// print_r($values);
// die();

foreach ($ExpenseData as $value) {

	if (empty($value["CurrentBalance"])) {
		$value["CurrentBalance"]=0;
	}
	  	$BankAccauntInformationHtml.='<option value="'.$value["BankCashID"].'">'.$value["AccountTitle"].'</option>';

	}

    $MainContent.='
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-th-list"></i>
                </span>				
                <h5>Contra Voucher</h5>
            </div>
            <div class="widget-content">	
            	<title>Contra Voucher</title>
				<center>
				<br>
				<img src="http://napps.click/RelainceHoldings/upload/f7f8da37a84d0ebaf39823fee6b2cc6c_logo%20(Software).jpg">
				<h1>Contra Voucher</h1>
            </div>	
        </div>   
		<div class="widget-box">

			<div class="block-content collapse in">

			<form id="BalanceTransfer" style="width:70%;margin:auto" >
				<label for="formAccaunt">Head of Accounts(Form Bank/Cash)</label>
				  
				  <select id="formAccaunt" style="width:70%;" name="formAccaunt">
				  	<option value="invalid Select">Select Accaunt</option>
				  		'.$BankAccauntInformationHtml.'
				  </select>
				
				 <p id="current_amount_form" style="color:green"></p>


				  <label for="toAccaunt">Head of Accounts(To Bank/Cash)</label>

				  <select id="toAccaunt" style="width:70%;" name="toAccaunt">
				  	<option value="invalid Select">Select Accaunt</option>				  
				  	'.$BankAccauntInformationHtml.'
				  </select>

				  <p id="current_amount_to" style="color:green">Current Amount: 120</p>
					

				<label for="datepicker">Date</label>
				<input style="width:70%;" type="text" placeholder="Select date" name="Date" id="datepicker">

				<label for="description">Description</label>
				<textarea style="width:70%;" name="description" id="description" placeholder="Description" ></textarea>

				<label  for="transferAmount">Transfer Amount</label>
				  <input style="width:70%;" placeholder="Transfer Amount" id="transferAmount" type="text" name="transferAmount">
				<br>
				<input id="formAccauntValue" type="hidden" name="formAccauntValue">
				

				<input value="Transfer" type="submit" class="btn btn-success">
			</form>
            </div>
		</div>


		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		<script>

		$( "#datepicker" ).datepicker();

			$("#current_amount_form").hide();	
			$("#formAccaunt").on("change", function() {
				var CurentID= this.value;
				$.ajax({
						type: "POST",
						url: "'.ApplicationURL("Transaction","BalanceTransferAjaxAction&NoHeader&NoFooter&id=true").'",
						data: {id:CurentID},
						success: function(response) {
							$("#current_amount_form").html("Curent Amount is: "+ response.replace(/\"/g, ""));
							$("#formAccauntValue").val(response.replace(/\"/g, ""));
							 $("#current_amount_form").show();
						  },
						  error: function(error) {
							alert("Error"+response);
						  }
					});
			});
			$("#current_amount_to").hide();
			$("#toAccaunt").on("change", function() {
				var CurentID= this.value;
				$.ajax({
						type: "POST",
						url: "'.ApplicationURL("Transaction","BalanceTransferAjaxAction&NoHeader&NoFooter&id=true").'",
						data: {id:CurentID},
						success: function(response) {
							$("#current_amount_to").html("Curent Amount is: "+ response.replace(/\"/g, ""));
							 $("#current_amount_to").show();
							 

						  },
						  error: function(error) {
							alert("Error"+response);
						  }
					});
			});



			$("#BalanceTransfer").submit(function(e){

				var formAccaunt=$("#formAccaunt").find(":selected").val();

				var toAccaunt=$("#toAccaunt").find(":selected").val();

				var transferAmount=$("#transferAmount").val();

				var datepicker=$("#datepicker").val();
				var description=$("#description").val();


				
				if( datepicker=="" || description=="" || formAccaunt=="invalid Select" ||  toAccaunt=="invalid Select" ||  transferAmount==""){
					alert("All field is required");
				}else{

					var formAccauntName=$("#formAccaunt").find(":selected").text();
					var toAccauntName=$("#toAccaunt").find(":selected").text();

					if( formAccauntName === toAccauntName ){
						alert("You can only transfer other accaunt.");
					}else{

						var formAccauntValue =$("#formAccauntValue").val();

					

						
					/*	if( parseInt(transferAmount) <= parseInt(formAccauntValue) ){ */
							
							var formAccauntId=formAccaunt;
							var toAccauntId=toAccaunt;							
							var TransferBalanceAmount=transferAmount;



							$.ajax({

									type: "POST",
									url: "'.ApplicationURL("Transaction","BalanceTransferAjaxAction&NoHeader&NoFooter&transfer=true").'",
									data: {formAccauntId: formAccauntId,toAccauntId:toAccauntId,TransferBalanceAmount:TransferBalanceAmount,datepicker:datepicker,description:description},

									success:function(response){
										alert(response);
										location.reload();
									},
									error: function(error){
										alert("Eror: "+ error);
									}	

								});


					/*	}else{
							alert("Your transfer balnce is getter than your current balance");
						}

						*/
						
					}

				}
				e.preventDefault();

			});


		</script>

    ';


?>


