<?

$CRMData = SQL_Select("CRM");
foreach ($CRMData as $CRMRow) {
    //echo $CRMRow["CRMID"];
    $LastCallDateData = SQL_Select("CRMDetails","CRMID={$CRMRow["CRMID"]} order by CRMDetailsID DESC","",true);
    //echo $LastCallDateData["CallDate"];
    SQL_InsertUpdate(
        "CRM",
        $TheEntityNameData=array(
            "LastCallDate"=>$LastCallDateData["CallDate"],
        ),
        " CRMID={$CRMRow["CRMID"]} "
    );

}


if ($_SESSION["UserID"]==1) Header("Location:index.php?Theme=default&Base=System&Script=login");

$MainContent.='

    <img src="Real-Estate-ERP-Solution.png" width="100%">

    <style>
        .group {
            
            margin-bottom: 30px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .group-title {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 18px;
            margin: 0;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .grid-container {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            padding: 20px;
        }

        .card {
            
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
            display: flex;
            align-items: center;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .icon {
            font-size: 2em;
            margin-right: 15px;
        }

        .text-content {
            display: flex;
            flex-direction: column;
        }

        .card h3 {
            margin: 0;
            font-size: 1.2em;
        }

        .card p {
            margin: 5px 0 0;
            font-size: 1em;
        }

        .properties {
            background: linear-gradient(135deg, #1de9b6, #1dc4e9);
        }

        .agents {
            background: linear-gradient(135deg, #ff6f61, #ff9671);
        }

        .clients {
            background: linear-gradient(135deg, #ffb74d, #ff8f00);
        }

        .revenue {
            background: linear-gradient(135deg, #82b1ff, #448aff);
        }
    </style>
    
';



    //// CRM Section =======    
    $TotalLeads = @mysql_fetch_array(mysql_query("SELECT SUM(CRMIsActive) as Total FROM tblcrm"), MYSQL_ASSOC);
    //$row["SellingPrice"];

    $TotalTodaysLeads = @mysql_fetch_array(mysql_query("SELECT SUM(CRMIsActive) as Total FROM tblcrm where DATE(DateInserted) = CURDATE()"), MYSQL_ASSOC);

    $TotalTask = @mysql_fetch_array(mysql_query("SELECT SUM(CRMDetailsIsActive) as Total FROM tblcrmdetails"), MYSQL_ASSOC);
    //$row["SellingPrice"];

    $TotalTaskLeads = @mysql_fetch_array(mysql_query("SELECT SUM(CRMDetailsIsActive) as Total FROM tblcrmdetails where DATE(DateInserted) = CURDATE()"), MYSQL_ASSOC);



    $TLocation = @mysql_fetch_array(mysql_query("SELECT SUM(ProjectLocationIsActive) as Total FROM tblprojectlocation"), MYSQL_ASSOC);
    $TProject = @mysql_fetch_array(mysql_query("SELECT SUM(CategoryIsActive) as Total FROM tblcategory"), MYSQL_ASSOC);
    $TProduct = @mysql_fetch_array(mysql_query("SELECT SUM(ProductsIsActive) as Total FROM tblproducts"), MYSQL_ASSOC);
    $TCustomer = @mysql_fetch_array(mysql_query("SELECT SUM(CustomerIsActive) as Total FROM tblcustomer"), MYSQL_ASSOC);
    $TSales = @mysql_fetch_array(mysql_query("SELECT SUM(SalesIsDisplay) as Total FROM tblsales"), MYSQL_ASSOC);
    $TVendor = @mysql_fetch_array(mysql_query("SELECT SUM(VendorIsDisplay) as Total FROM tblvendor"), MYSQL_ASSOC);
    $TContructor = @mysql_fetch_array(mysql_query("SELECT SUM(ContructorIsDisplay) as Total FROM tblcontructor"), MYSQL_ASSOC);
    
    
    $TPurchaseRequisition = @mysql_fetch_array(mysql_query("SELECT SUM(PurchaseRequisitionIsActive) as Total FROM tblpurchaserequisition where DATE(DateInserted) = CURDATE()"), MYSQL_ASSOC);
    $TCredit = @mysql_num_rows(mysql_query("SELECT * FROM tblcrvoucher where DATE(DateInserted) = CURDATE()"));
    $TDebit = @mysql_num_rows(mysql_query("SELECT * FROM tbldrvoucher where DATE(DateInserted) = CURDATE()"));

    $TEmployee = @mysql_fetch_array(mysql_query("SELECT SUM(EmployeeIsActive) as Total FROM tblemployee"), MYSQL_ASSOC);
    $TUser = @mysql_fetch_array(mysql_query("SELECT SUM(UserIsActive) as Total FROM tbluser"), MYSQL_ASSOC);





$MainContent.='
    <div class="container-fluid p-0">

       <!-- Real Estate Section -->

        <div class="row shadow-lg p-3 mb-5 bg-body rounded" style="border-top-left-radius:10px; border-top-right-radius:10px; ">
            <div class="group-title mb-3">
                <h2 class="h4"><i class="fas fa-building"></i> <span class="mr-2">Real Estate</span></h2>
            </div>
            
            <div class="col-6 col-sm-4 col-lg-3 mb-4">
                <div class="card bg-primary text-white shadow">
                    <div class="card-body d-flex align-items-center">
                        <i class="fas fa-map-marker-alt fa-2x me-3"></i>
                        <div>
                            <h5 style="font-size: .925rem ; font-weight: 600; color:white" class="card-title mb-0">Location</h5>
                            <small>Total: '.$TLocation["Total"].'</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-sm-4 col-lg-3 mb-4">
                <div class="card bg-danger text-white shadow">
                    <div class="card-body d-flex align-items-center">
                        <i class="fas fa-industry fa-2x me-3"></i>
                        <div>
                            <h5 style="font-size: .925rem ; font-weight: 600; color:white" class="card-title mb-0">Projects</h5>
                            <small>Total: '.$TProject["Total"].'</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-sm-4 col-lg-3 mb-4">
                <div class="card bg-warning text-white shadow">
                    <div class="card-body d-flex align-items-center">
                        <i class="fas fa-city fa-2x me-3"></i>
                        <div>
                            <h5 style="font-size: .925rem ; font-weight: 600; color:white" class="card-title mb-0">Products</h5>
                            <small>Total: '.$TProduct["Total"].'</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-sm-4 col-lg-3 mb-4">
                <div class="card bg-info text-white shadow">
                    <div class="card-body d-flex align-items-center">
                        <i class="fas fa-user-shield fa-2x me-3"></i>
                        <div>
                            <h5 style="font-size: .925rem ; font-weight: 600; color:white" class="card-title mb-0">Customers</h5>
                            <small>Total: '.$TCustomer["Total"].'</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-sm-4 col-lg-3 mb-4">
                <div class="card bg-success text-white shadow">
                    <div class="card-body d-flex align-items-center">
                        <i class="fas fa-clipboard-check fa-2x me-3"></i>
                        <div>
                            <h5 style="font-size: .925rem ; font-weight: 600; color:white" class="card-title mb-0">Sales</h5>
                            <small>Total: '.$TSales["Total"].'</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-sm-4 col-lg-3 mb-4">
                <div class="card bg-primary text-white shadow">
                    <div class="card-body d-flex align-items-center">
                        <i class="fas fa-people-carry fa-2x me-3"></i>
                        <div>
                            <h5 style="font-size: .925rem ; font-weight: 600; color:white" class="card-title mb-0">Vendors</h5>
                            <small>Total: '.$TVendor["Total"].'</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-sm-4 col-lg-3 mb-4">
                <div class="card bg-primary bg-info text-white shadow">
                    <div class="card-body d-flex align-items-center">
                        <i class="fas fa-drafting-compass fa-2x me-3"></i>
                        <div>
                            <h5 style="font-size: .925rem ; font-weight: 600; color:white" class="card-title mb-0">Constructors</h5>
                            <small>Total: '.$TContructor["Total"].'</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-sm-4 col-lg-3 mb-4">
                <div class="card bg-success text-white shadow">
                    <div class="card-body d-flex align-items-center">
                        <i class="fas fa-shopping-bag fa-2x me-3"></i>
                        <div>
                            <h5 style="font-size: .925rem ; font-weight: 600; color:white" class="card-title mb-0">Today\'s Requisition</h5>
                            <small>Total: '.$TPurchaseRequisition["Total"].'</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-sm-4 col-lg-3 mb-4">
                <div class="card bg-primary text-white shadow">
                    <div class="card-body d-flex align-items-center">
                        <i class="fas fa-dollar-sign fa-2x me-3"></i>
                        <div>
                            <h5 style="font-size: .925rem ; font-weight: 600; color:white" class="card-title mb-0">Today\'s Credit</h5>
                            <small>Total: '.$TCredit.'</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-sm-4 col-lg-3 mb-4">
                <div class="card bg-danger text-white shadow">
                    <div class="card-body d-flex align-items-center">
                        <i class="fas fa-dollar-sign fa-2x me-3"></i>
                        <div>
                            <h5 style="font-size: .925rem ; font-weight: 600; color:white" class="card-title mb-0">Today\'s Debit</h5>
                            <small>Total: '.$TDebit.'</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-sm-4 col-lg-3 mb-4">
                <div class="card bg-warning text-white shadow">
                    <div class="card-body d-flex align-items-center">
                        <i class="fas fa-id-badge fa-2x me-3"></i>
                        <div>
                            <h5 style="font-size: .925rem ; font-weight: 600; color:white" class="card-title mb-0">Employees</h5>
                            <small>Total: '.$TEmployee["Total"].'</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-sm-4 col-lg-3 mb-4">
                <div class="card bg-info text-white shadow">
                    <div class="card-body d-flex align-items-center">
                        <i class="fas fa-users fa-2x me-3"></i>
                        <div>
                            <h5 style="font-size: .925rem ; font-weight: 600; color:white" class="card-title mb-0">Users</h5>
                            <small>Total: '.$TUser["Total"].'</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CRM Section -->
        <div class="row shadow-lg p-3 mb-5 bg-body rounded" style="border-top-left-radius:10px; border-top-right-radius:10px;">
            <div class="group-title mb-3">
                <h2 class="h4"><i class="fas fa-address-book"></i> <span class="mr-2">CRM</span></h2>
            </div>

            <div class="col-6 col-sm-4 col-lg-3 mb-4">
                <div class="card bg-info text-white shadow">
                    <div class="card-body d-flex align-items-center">
                        <i class="fas fa-headset fa-2x me-3"></i>
                        <div>
                            <h5 style="font-size: .925rem ; font-weight: 600; color:white" class="card-title mb-0">Leads</h5>
                            <small>Total: '.$TotalLeads["Total"].'</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-sm-4 col-lg-3 mb-4">
                <div class="card bg-primary text-white shadow">
                    <div class="card-body d-flex align-items-center">
                        <i class="fas fa-headset fa-2x me-3"></i>
                        <div>
                            <h5 style="font-size: .925rem ; font-weight: 600; color:white" class="card-title mb-0">Today\'s Leads</h5>
                            <small>Total: '.$TotalTodaysLeads["Total"].'</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-sm-4 col-lg-3 mb-4">
                <div class="card bg-secondary text-white shadow">
                    <div class="card-body d-flex align-items-center">
                        <i class="fas fa-tasks fa-2x me-3"></i>
                        <div>
                            <h5 style="font-size: .925rem ; font-weight: 600; color:white" class="card-title mb-0">Tasks</h5>
                            <small>Total: '.$TotalTask["Total"].'</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-sm-4 col-lg-3 mb-4">
                <div class="card bg-success text-white shadow">
                    <div class="card-body d-flex align-items-center">
                        <i class="fas fa-tasks fa-2x me-3"></i>
                        <div>
                            <h5 style="font-size: .925rem ; font-weight: 600; color:white" class="card-title mb-0">Today\'s Tasks</h5>
                            <small>Total: '.$TotalTaskLeads["Total"].'</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
';




// Pending Purchase for Review
$PendingPurchaseReview =  SQL_Select("Purchase","PurchaseIsActive=1 order by PurchaseID DESC limit 50");
$PPRHTML="";
foreach($PendingPurchaseReview as $ThisPendingPurchaseReview){
	$PPRHTML.='
		<tr>
			<th>'.$ThisPendingPurchaseReview["DateInserted"].'</th>
			<th>'.$ThisPendingPurchaseReview["PurchaseID"].'</th>
			<th>'.GetVendorName($ThisPendingPurchaseReview["VendorID"]).'</th>
			<th>'.GetUserName($ThisPendingPurchaseReview["UserIDInserted"]).'</th>
			<th>'.GetWareHouseName($ThisPendingPurchaseReview["WareHouseID"]).'</th>
			<th>
				<span class="badge badge-info"><a style="color:white;" href="index.php?Theme=default&Base=Purchase&Script=Manage&Action=Edit&EditTempNumber='.$ThisPendingPurchaseReview["TempNumber"].'">Edit</a></span>	
			</th>
			<th>
				<span class="badge badge-info"><a style="color:white;" href="index.php?Theme=default&Base=Purchase&Script=Manage&Action=Delete&EditTempNumber='.$ThisPendingPurchaseReview["TempNumber"].'">Del</a></span>	
			</th>
		</tr>
	
	';
	
}





$SalesReport= SQL_Select("Sales","SalesIsActive=1 order by SalesID DESC");
foreach($SalesReport as $ThisSalesReport){

	$TotalDue = GetSalesDueAmount($ThisSalesReport["TempNumber"]);
	
	// if Due found
	if($TotalDue>0){
	
		$TotalSales = GetSalesOrderTotalAmount($ThisSalesReport["TempNumber"]);
		$GrandTotalSales = $GrandTotalSales + $TotalSales;
		$GrandTotalDue = $GrandTotalDue + $TotalDue;
		
		$CustomerDueHTML.='
		
			<tr>
				<td width="45" align="center">
					'.GetCustomerName($ThisSalesReport["CustomerID"]).'
					
					<br>
					<a style="color:blue;font-family:arial;text-decoration:none;"  href="index.php?Theme=default&Base=Sales&Script=Manage&Action=Edit&EditTempNumber='.$ThisSalesReport["TempNumber"].'&CID='.$ThisSalesReport["CustomerID"].'">
						Edit
					</a>					
					
				</td>
				<td align="left" >
					'.$ThisSalesReport["SalesID"].'
				</td>
				<td align="left" >
					'.date("M j, y", strtotime($ThisSalesReport["DateInserted"])).'
				</td>
				<td align="left" >
						Total: '.$TotalSales.'/= <br>
						Due: '.$TotalDue.'/=			
				</td>

			</tr>
		
		';


		$i++;
	}	
}

//echo $SalesReportHTML1;
/// product stock

$ProductsCategory= SQL_Select("Category","1=1 order by Name Asc");



$TotalPurchasePrice =0;
foreach ($ProductsCategory as $ThisProductsCategory){



	$Products= SQL_Select("Products","CategoryID='{$ThisProductsCategory["CategoryID"]}' order by CategoryID Asc");

	$i=1;
	$ProductStockHTMLs.='
		<tr>
			<td colspan="5">
				&nbsp;<b style="color:green">'.$ThisProductsCategory["Name"].'</b>
			</td>
		</tr>		
	
	';
	
//	$TotalPurchasePrice = $TotalPurchasePrice + $ThisProducts["PurchaseLatestPrice"];
	$j=1;
	foreach($Products as $ThisProducts){
		
		$SetColorRed="";
		if($ThisProducts["AlertQuantity"]>$ThisProducts["Quantity"])
			$SetColorRed = "color:red;";
			
		$ProductStockHTML.='
			<tr>
	
				<td  style="'.$SetColorRed.'">
					&nbsp;'.$ThisProducts["ProductName"].'
				</td>
				<td style="'.$SetColorRed.'" >
					&nbsp;'.$ThisProducts["Quantity"].'
				</td>
				<td style="'.$SetColorRed.'" >
					&nbsp;'.$ThisProducts["PurchaseLatestPrice"].'/=
				</td>
				<td style="'.$SetColorRed.'" >
					&nbsp;'.$ThisProducts["Quantity"] * $ThisProducts["PurchaseLatestPrice"].'/=
				</td>
			</tr>		
		
		';

		$j++;

	}
}


/// end of product stock



	$MainContent.='
				
	
			<div class="">
                            <!-- block -->
                            
                            <!-- /block -->
                        </div>		    
				

		   
			</div>
				
		
				
	';

 ?>