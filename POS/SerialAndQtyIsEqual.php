<?
	
$GetrecentSerialsAndQTY=SQL_Select("SalesOrder","TempNumber='{$_REQUEST["TempNumber"]}'","","");
$HTML="";
//echo "<pre>";
//print_r($GetrecentSerialsAndQTY);
//echo count($GetrecentSerialsAndQTY);

	foreach($GetrecentSerialsAndQTY as $ThisGetrecentSerialsAndQTY){
		
		//if(GetProductsSerial($ThisGetrecentSerialsAndQTY["ProductID"],$SelectedSeriels="",$_REQUEST["TempNumber"])!=""){
			//echo "<hr>";
			//echo $ThisGetrecentSerialsAndQTY["Serials"]."sss";
			//echo strlen($ThisGetrecentSerialsAndQTY["Serials"]);
			if(strlen($ThisGetrecentSerialsAndQTY["Serials"])>1){	
			
				$SerialCount=explode(",",$ThisGetrecentSerialsAndQTY["Serials"]);
				//print_r($SerialCount);
				// echo count($SerialCount)."<br>";
				// echo $ThisGetrecentSerialsAndQTY["Qty"]."<br>";
				// echo $ThisGetrecentSerialsAndQTY["Serials"]."<br>";
				$TotalCount=count($SerialCount);
				
				if($ThisGetrecentSerialsAndQTY["Qty"]!=$TotalCount and $ThisGetrecentSerialsAndQTY["Serials"]!=""){
					$HTML.='
					'.GetProductName($ThisGetrecentSerialsAndQTY["ProductID"]).' Serial('.count($SerialCount).') and Quanty('.$ThisGetrecentSerialsAndQTY["Qty"].') not Equal.';
					//brkea;
				}
			}			
			else{	
				$FindProductSerialKey=SQL_Select("purchasedproducts","ProductID='{$ThisGetrecentSerialsAndQTY["ProductID"]}' and Serials!=''","","true");
				//sa($FindProductSerialKey);
				//echo $FindProductSerialKey["Serials"]."123|";
				//echo $ThisGetrecentSerialsAndQTY["ProductID"];
				
				if($FindProductSerialKey["Serials"]!="")
					$HTML.='
					'.GetProductName($ThisGetrecentSerialsAndQTY["ProductID"]).' Serial Not Selected.';
			}
		//}
		
		//break;
		
	}	
	if($HTML!="")
		echo $HTML;
	else
		echo "1";



?>