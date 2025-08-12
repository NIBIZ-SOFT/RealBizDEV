<?php 


if($_REQUEST["ProductID"]!=""){

    $SalesRecord=SQL_Select("sales"," SalesID={$_REQUEST["ProductID"]}","",true);

    if($SalesRecord["ProductID"]!="")
        $SalesDetial=SQL_Select("sales"," ProductID={$SalesRecord["ProductID"]}","");
    
    echo '<select name="customer_id" id="CustomerOption">';
    foreach($SalesDetial as $ThisSalesDetial){
        echo '<option value="'.$ThisSalesDetial["CustomerID"].'">'.$ThisSalesDetial["CustomerName"].'</option>';
    }
    echo '</select>';
    

}


if ( !empty($_POST["ProjectID"])) {
	$ProjectID=$_POST["ProjectID"];
	$SalesDetial=SQL_Select("sales where ProjectID={$ProjectID} and ProductName!='' group by ProductID");
	echo json_encode($SalesDetial);
}
















?>