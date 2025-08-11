


<?


$Category=SQL_Select("Category");

foreach ($Category as $value) {
	$CategoryInfo .= '

		<option value="'.$value["CategoryID"].'"> '.$value["Name"].'</option>

	';
}








    $MainContent.='

        <div class="widget-box">

            <div class="widget-title">

                <span class="icon">

                    <i class="icon-th-list"></i>

                </span>				

                <h5>Journal/Trx Report</h5>

            </div>

            <div class="widget-content">	

            	<title>Journal/Trx Report</title>

				<center>

				<br>

				<img src="http://napps.click/RelainceHoldings/upload/f7f8da37a84d0ebaf39823fee6b2cc6c_logo%20(Software).jpg">

				<h1>Journal/Trx Report</h1>

            </div>	
      
        </div>   


		<div class="widget-box">
			<div class="block-content collapse in">
				<form method="POST" action="'.ApplicationURL("Transaction","FullReport").'">
					Select a Bank : '.CCTL_BankCash($Name="BankCashID").'
					<input type="submit" value="Show Report" class="btn btn-primary" >
				</form>
				<hr>
				<form method="POST" action="'.ApplicationURL("Transaction","FullReport").'">
					Select a Project : 

					<select name="CategoryID" id="">

						'.$CategoryInfo.'

					</select>

					Select Expense Head: '.ExpenseHead($Name = "ExpenseHead", $TheEntityName["ExpenseHead"], $Where = "", $PrependBlankOption = false).'

					<input type="submit" value="Show Report" class="btn btn-primary" >
				</form>
				<hr>
				<form method="POST" action="'.ApplicationURL("Transaction","FullReport").'">
					Select a Project :
					<select name="CategoryID" id="">
					 '.$CategoryInfo.'
					</select>

					<input type="submit" value="Show Report" class="btn btn-primary" >
				</form>
				<hr>
				<form method="POST" action="'.ApplicationURL("Transaction","FullReport").'">
					Select a Project : 
					<select name="CategoryID" id="">
					 '.$CategoryInfo.'
					</select>


					<div style="height:10px;"></div>
					From Date <input  placeholder="Year-Month-Day" type="text" name="FromDate" style="size:50px;" class="DatePicker">
					<br>
					To Date <input placeholder="Year-Month-Day" type="text" name="ToDate" size="20"  class="DatePicker">
					<br>
					<input type="submit" value="Show Report" class="btn btn-primary" >
				</form>                                    
            </div>
		</div>

    

    ';



?>