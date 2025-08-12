<?php
/**
 * Created by PhpStorm.
 * User: NiBiZ Soft
 * Date: 4/9/2019
 * Time: 2:54 PM
 */



$MainContent.='
		<center>
			<h1>Trial Balance Manage</h1>
		</center>
		<div class="row-fluid">
            
		    <div class="span6">
                <!-- block -->
                <div class="block">
                    <div class="navbar navbar-inner block-header">
                        <div class="muted pull-left">Trial Balance</div>
                        <div class="pull-right">

                        </div>
                    </div>
                    <div class="block-content collapse in">
						<form method="POST" action="'.ApplicationURL("Transaction","TB&NoHeader&NoFooter").'">
							
							Project Name : '.CCTL_ProductsCategory($Name = "CategoryID", $TheEntityName["CategoryID"], $Where = "", $PrependBlankOption = true).'
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
		        
    		    
                    <!-- block -->
                    <div class="block">
                        <div class="navbar navbar-inner block-header">
                            <div class="muted pull-left">Trial Balance ( Cumulative )</div>
                            <div class="pull-right">
    
                            </div>
                        </div>
                        <div class="block-content collapse in">
    						<form method="POST" action="'.ApplicationURL("Transaction","TBCumulative&NoHeader&NoFooter").'">
    							
    							
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
		    
		    
		    
		    ';


?>

