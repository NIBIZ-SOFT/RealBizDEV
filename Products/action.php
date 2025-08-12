<?

	//error_reporting(E_ALL);
	//ini_set("display_errors", 1);

	include("./library/PHPExcel/IOFactory.php");
		
	if(isset($_REQUEST['btn'])){
		
		$target_path = $Application["UploadPath"];
				
		$ext = pathinfo(basename($_FILES['file']['name']), PATHINFO_EXTENSION);
	
		 $filename = $_FILES['file']['name'];

		$target_path = $target_path . $filename;

		move_uploaded_file($_FILES['file']['tmp_name'], $target_path);
			
		$objPHPExcel = PHPExcel_IOFactory::load($target_path);
		
		foreach($objPHPExcel->getWorksheetIterator() as $worksheet)
		{
			
			$highestRow = $worksheet->getHighestRow();
			
		
			for($row=1;$row<=$highestRow;$row++)
			{
				
				// give the data dase fields name and the post value name
				//01.08.2016.
				//2016-11-16
				SQL_InsertUpdate(
				$Entity="Products",
				$TheEntityNameData=array(                                                      
					"Barcode"=>$worksheet->getCellByColumnAndRow(0, $row)->getValue(),
					"CategoryID"=>20,
					"Category"=>GetCategoryName("20"),
					"ProductName"=>$worksheet->getCellByColumnAndRow(1, $row)->getValue(),
					"Quantity"=>$worksheet->getCellByColumnAndRow(2, $row)->getValue(),
					"PurchaseLatestPrice"=>str_replace(",","",$worksheet->getCellByColumnAndRow(3, $row)->getValue()),
					"AlertQuantity"=>"50",
					"SellingPrice"=>str_replace(",","",$worksheet->getCellByColumnAndRow(5, $row)->getValue()),
				
				),
				$Where=""
				);
				
			}
		}
		
		//unlink($target_path);
		
		$MainContent.="
		
			<script language=\"JavaScript\" >
				window.location='index.php?Theme=default&Base=Products&Script=Manage';
			</script>		
		
		
		";
			
	}
