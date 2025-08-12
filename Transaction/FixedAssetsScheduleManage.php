<?php
/**
 * Created by PhpStorm.
 * User: NiBiZ Soft
 * Date: 4/28/2019
 * Time: 10:49 AM
 */




$MainContent.='
		<center>
			<h1>Fixed Assets Schedule Manage</h1>
		</center>
		<div class="row-fluid">
            
		    <div class="span6">
                <!-- block -->
                <div class="block">
                    <div class="navbar navbar-inner block-header">
                        <div class="muted pull-left">Fixed Assets Schedule</div>
                        <div class="pull-right">

                        </div>
                    </div>
                    <div class="block-content collapse in">
						<form method="POST" action="'.ApplicationURL("Transaction","FixedAssetsSchedule&NoHeader&NoFooter").'">
							
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

