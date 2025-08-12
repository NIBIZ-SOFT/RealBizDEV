<?


    $CRM = SQL_Select("CRM","CRMID={$_REQUEST["CRMID"]}","",true);
    


$MainContent.='


    <div class="widget-box">
    	<div class="widget-title">
    		<span class="icon">
    			<i class="icon-th-list"></i>
    		</span>				
    		<h5>Projects List</h5>
    	</div>
    	<div class="widget-content">		
    				
    	</div>	
    </div>

    <div class="row-fluid">
        <!-- block -->
        <div class="block">
            <div class="navbar navbar-inner block-header">
                <div class="muted pull-left">'.$CRM["Title"].' - '.$CRM["ProjectName"].'</div>
                <div class="pull-right">

                </div>
            </div>
            <div style="padding:10px;">
                <div class="row-fluid">
                    <div class="span6" style="width:16%">
                        <!-- block -->
                            <div style="width:240px;">
    							<ul class="nav nav-list bs-docs-sidenav nav-collapse collapse">
                                                            	
    								<li>
    									<a href="http://nibizsoft.net/RedFin/index.php?Theme=default&amp;Base=Page&amp;Script=Home"><i class="icon-chevron-right"></i> Dashboard</a>
    								</li>
                                                            								
    								<li>
    									<a href="http://nibizsoft.net/RedFin/index.php?Theme=default&amp;Base=Category&amp;Script=Manage"><i class="icon-chevron-right"></i> Projects</a>
    								</li>
                                    								
    								<li>
    									<a href="http://nibizsoft.net/RedFin/index.php?Theme=default&amp;Base=ProjectLocation&amp;Script=Manage"><i class="icon-chevron-right"></i> Project Location</a>
    								</li>
                                    	
    								<li>
    									<a href="http://nibizsoft.net/RedFin/index.php?Theme=default&amp;Base=Products&amp;Script=Manage"><i class="icon-chevron-right"></i> Products</a>
    								</li>
                                    	
    								<li>
    									<a href="http://nibizsoft.net/RedFin/index.php?Theme=default&amp;Base=Customer&amp;Script=Manage"><i class="icon-chevron-right"></i>Customer</a>
    								</li>
                                    								
    								<li>
    									<a href="http://nibizsoft.net/RedFin/index.php?Theme=default&amp;Base=Sales&amp;Script=Manage"><i class="icon-chevron-right"></i> Sales</a>
    								</li>

    							</ul>                         
                                <br>
                                <div sytle="clear:both;"></div>
    
    						</div>

                        <!-- /block -->
                    </div>
                    
                    
                    <div class="span6"  style="width:81%">
                        <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Invoices</div>
                                <div class="pull-right"><span class="badge badge-info">812</span>
                
                                </div>
                            </div>
                            <div class="block-content collapse in">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Date</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>02/02/2013</td>
                                            <td>$25.12</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>01/02/2013</td>
                                            <td>$335.00</td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>01/02/2013</td>
                                            <td>$29.99</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /block -->
                    </div>
                </div>            
            </div>                
            
            
            
        </div>
        <!-- /block -->
    </div>

';



?>