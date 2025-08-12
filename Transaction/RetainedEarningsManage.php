<?php
/**
 * Created by PhpStorm.
 * User: NiBiZ Soft
 * Date: 4/25/2019
 * Time: 3:54 PM
 */


$MainContent.='
		<center>
			<h1>Statement Of Retained Earnings</h1>
		</center>
		<div class="row-fluid">
            <div class="span6">
                <!-- block -->
                <div class="block">
                    <div class="navbar navbar-inner block-header">
                        <div class="muted pull-left">Retained Earnings</div>
                        <div class="pull-right">

                        </div>
                    </div>
                    <div class="block-content collapse in">
						<form method="POST" action="'.ApplicationURL("Transaction","RetainedEarnings&NoHeader&NoFooter").'">
							Project Name : '.CCTL_ProductsCategory($Name = "CategoryID", $TheEntityName["CategoryID"], $Where = "", $PrependBlankOption = true).'
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
		    
		    
		    ';

