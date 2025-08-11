<?php
/**
 * Created by PhpStorm.
 * User: NiBiZ Soft
 * Date: 5/14/2019
 * Time: 3:04 PM
 */


$MainContent .= '



<center>
			<h1>Notes</h1>
		</center>
		<div class="row-fluid">
            <div class="span6">
                <!-- block -->
                <div class="block">
                    <div class="navbar navbar-inner block-header">
                        <div class="muted pull-left">Stock Report</div>
                        <div class="pull-right">

                        </div>
                    </div>
                    <div class="block-content collapse in">
						<form method="POST" action="' . ApplicationURL("Report", "StockReport&NoHeader&NoFooter") . '">
							Project Name : ' . CCTL_ProductsCategory($Name = "CategoryID", $TheEntityName["CategoryID"], $Where = "", $PrependBlankOption = true) . '
							<div style="height:10px;"></div>
							Expense / Income Head : ' . GetExpenseID($Name = "HeadOfAccountID", $ValueSelected = "", $Where = "ExpenseHeadIsStock=1", $PrependBlankOption = true) . '
							<div style="height:10px;"></div>
                            From Date <input  placeholder="Year-Month-Day" type="Date" name="FromDate" style="size:50px;">
                            <br>
                            To Date <input placeholder="Year-Month-Day" type="Date" name="ToDate" size="20">
                            <br>
                            <input type="submit" value="Show Report" class="btn btn-primary" >
                            
						</form>
							
		            </div>
		        </div>
		        <!-- /block -->
		        
		    </div>
		    
		    <div class="span6">
                <!-- block -->
                <div class="block">
                    <div class="navbar navbar-inner block-header">
                        <div class="muted pull-left">Notes (Head Wise All Project Wise)</div>
                        <div class="pull-right">

                        </div>
                    </div>
                    <div class="block-content collapse in">
						<form method="POST" action="' . ApplicationURL("Report", "Notes&NoHeader&NoFooter") . '">
							
							Expense / Income Head (Type) : ' . GetExpenseTypeID($Name = "IncomeExpenseTypeID", $ValueSelected = "", $Where = "", $PrependBlankOption = true) . '
							<div style="height:10px;"></div>
                            From Date <input  placeholder="Year-Month-Day" type="Date" name="FromDate" style="size:50px;">
                            <br>
                            To Date <input placeholder="Year-Month-Day" type="Date" name="ToDate" size="20">
                            <br>
                            From Date <input  placeholder="Year-Month-Day" type="Date" name="FromDate1" style="size:50px;">
                            <br>
                            To Date <input placeholder="Year-Month-Day" type="Date" name="ToDate1" size="20">
                            <br>
                            
                            <input type="submit" value="Show Report" class="btn btn-primary" >
                            
						</form>
							
		            </div>
		        </div>
		        <!-- /block -->
		        
		    </div>
		    
		    
		</div>
		
		
		<div class="row-fluid">
            
		    
		    <div class="span6">
                <!-- block -->
                <div class="block">
                    <div class="navbar navbar-inner block-header">
                        <div class="muted pull-left">Notes ( Project Wise Head of Expense )</div>
                        <div class="pull-right">

                        </div>
                    </div>
                    <div class="block-content collapse in">
						<form method="POST" action="' . ApplicationURL("Report", "NotesProjectExpenseHead&NoHeader&NoFooter") . '">
							
							Project Name : ' . CCTL_ProductsCategory($Name = "CategoryID", $TheEntityName["CategoryID"], $Where = "", $PrependBlankOption = true) . '
							<div style="height:10px;"></div>
							
							Expense / Income Head (Type) : ' . GetExpenseTypeID($Name = "IncomeExpenseTypeID", $ValueSelected = "", $Where = "", $PrependBlankOption = true) . '
							<div style="height:10px;"></div>
                            From Date <input  placeholder="Year-Month-Day" type="Date" name="FromDate" style="size:50px;">
                            <br>
                            To Date <input placeholder="Year-Month-Day" type="Date" name="ToDate" size="20">
                            <br>
                            From Date <input  placeholder="Year-Month-Day" type="Date" name="FromDate1" style="size:50px;">
                            <br>
                            To Date <input placeholder="Year-Month-Day" type="Date" name="ToDate1" size="20">
                            <br>
                            
                            <input type="submit" value="Show Report" class="btn btn-primary" >
                            
						</form>
							
		            </div>
		        </div>
		        <!-- /block -->
		        
		    </div>
		   
		    
		    
		    
		    
		    
		</div>







';