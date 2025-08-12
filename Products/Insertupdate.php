<?php


include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";
$UpdateMode = false;
$FormTitle = "Insert $EntityCaption";
$ButtonCaption = "Insert";
$ActionURL = ApplicationURL("{$_REQUEST["Base"]}", "Insertupdateaction");

// The default value of the input box will goes here according to how many fields we showing

$TheEntityName = array(

    "ProductsName" => "",
    "ProductsDescription" => "",
    "SellingPrice" => "0",
    "Quantity" => "0",
    "Date" => "",
    "InStook" => "",
    "PurchaseLatestPrice" => "0",

    "{$Entity}IsActive" => 1
);



if (isset($_REQUEST[$Entity . "ID"]) && isset($_REQUEST[$Entity . "UUID"]) && !isset($_REQUEST["DeleteConfirm"])) {
    $UpdateMode = true;
    $FormTitle = "Update $EntityCaption";
    $ButtonCaption = "Update";
    $ActionURL = ApplicationURL("{$_REQUEST["Base"]}", "Insertupdateaction", $Entity . "ID={$_REQUEST[$Entity."ID"]}&" . $Entity . "UUID={$_REQUEST[$Entity."UUID"]}");
    if ($UpdateMode && !isset($_POST["" . $Entity . "ID"])) $TheEntityName = SQL_Select($Entity = "{$Entity}", $Where = "{$Entity}ID = {$_REQUEST[$Entity."ID"]} AND {$Entity}UUID = '{$_REQUEST[$Entity."UUID"]}'", $OrderBy = "{$OrderByValue}", $SingleRow = true);
}

// Input sytem display goes here
$Input = array();
$MainContent .= '
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-info text-white">
        <h5 class="mb-0">'.$FormTitle.'</h5>
    </div>
    <div class="card-body">
        <form id="productAddForm" action="' . $ActionURL . '" method="post" enctype="multipart/form-data">
            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label">Projects\'s Name</label>
                    ' . CCTL_ProductsCategory("CategoryID", $TheEntityName["CategoryID"], "", true, "required") . '
                </div>';
if ($_SESSION["ProductType"] == "Land") {
    $MainContent .= '
        <div class="col-md-6"><label class="form-label">Plot No.</label>' . CTL_InputText("FlatType", $TheEntityName["FlatType"], "", 55, "") . '</div>
        <div class="col-md-6"><label class="form-label">Road No.</label>' . CTL_InputNumber("FloorNumber", $TheEntityName["FloorNumber"], "", 55, "") . '</div>
        <div class="col-md-6"><label class="form-label">Plot Area</label>' . CTL_InputText("FlatSize", $TheEntityName["FlatSize"], "", 55, "") . ' </div>
        <div class="col-md-12 text-center"><label class="form-label">Katha</label></div>
        <div class="col-md-6"><label class="form-label">Rate Per Katha</label>' . CTL_InputNumber("UnitPrice", $TheEntityName["UnitPrice"], "", 55, "") . '</div>
        <div class="col-md-6"><label class="form-label">Total Price</label>' . CTL_InputNumber("FlatPrice", $TheEntityName["FlatPrice"], "", 55, "") . '</div>
        <div class="col-md-6"><label class="form-label">Car Parking Charge</label>' . CTL_InputNumber("CarParkingCharge", $TheEntityName["CarParkingCharge"], "", 55, "") . '</div>
        <div class="col-md-6"><label class="form-label">Utility Charge</label>' . CTL_InputNumber("UtilityCharge", $TheEntityName["UtilityCharge"], "", 55, "") . '</div>
        <div class="col-md-6"><label class="form-label">Additional Work Charge</label>' . CTL_InputNumber("AdditionalWorkCharge", $TheEntityName["AdditionalWorkCharge"], "", 55, "") . '</div>
        <div class="col-md-6"><label class="form-label">Other Charge</label>' . CTL_InputNumber("OtherCharge", $TheEntityName["OtherCharge"], "", 55, "") . '</div>
        <div class="col-md-6"><label class="form-label">Deduction/Discount</label>' . CTL_InputNumber("DeductionCharge", $TheEntityName["DeductionCharge"], "", 55, "") . '</div>
        <div class="col-md-6"><label class="form-label">Refund Additional Work Charge</label>' . CTL_InputNumber("RefundAdditionalWorkCharge", $TheEntityName["RefundAdditionalWorkCharge"], "", 55, "") . '</div>';
}

if ($_SESSION["ProductType"] == "LandShare" || $_SESSION["ProductType"] == "HotelShare") {
    $MainContent .= '
        <div class="col-md-6"><label class="form-label">Land Area</label>' . CTL_InputText("LandArea", $TheEntityName["LandArea"], "", 55, "") . '</div>
        <div class="col-md-6"><label class="form-label">Build Area</label>' . CTL_InputText("BuildArea", $TheEntityName["BuildArea"], "", 55, "") . '</div>
        <div class="col-md-6"><label class="form-label">Share Name</label>' . CTL_InputText("FlatType", $TheEntityName["FlatType"], "", 55, "") . '</div>
        <div class="col-md-6"><label class="form-label">Share CID</label>' . CTL_InputText("FloorNumber", $TheEntityName["FloorNumber"], "", 55, "") . '</div>
        <div class="col-md-6"><label class="form-label">How Many Share</label>' . CTL_InputNumber("FlatSize", $TheEntityName["FlatSize"], "", 55, "") . '</div>
        <div class="col-md-6"><label class="form-label">Share Price</label>' . CTL_InputNumber("UnitPrice", $TheEntityName["UnitPrice"], "", 55, "") . '</div>
        <div class="col-md-6"><label class="form-label">Total Share Price</label>' . CTL_InputNumber("FlatPrice", $TheEntityName["FlatPrice"], "", 55, "")
        . CTL_InputTextHidden("CarParkingCharge", $TheEntityName["CarParkingCharge"], "", 55, "")
        . CTL_InputTextHidden("UtilityCharge", $TheEntityName["UtilityCharge"], "", 55, "")
        . CTL_InputTextHidden("AdditionalWorkCharge", $TheEntityName["AdditionalWorkCharge"], "", 55, "")
        . CTL_InputTextHidden("OtherCharge", $TheEntityName["OtherCharge"], "", 55, "")
        . CTL_InputTextHidden("DeductionCharge", $TheEntityName["DeductionCharge"], "", 55, "")
        . CTL_InputTextHidden("RefundAdditionalWorkCharge", $TheEntityName["RefundAdditionalWorkCharge"], "", 55, "") . '</div>';
}

if ($_SESSION["ProductType"] == "FlatAppartment") {
    $MainContent .= '
        <div class="col-md-6"><label class="form-label">Flat Type</label>' . CTL_InputText("FlatType", $TheEntityName["FlatType"], "", 55, "") . '</div>
        <div class="col-md-6"><label class="form-label">Floor Number</label>' . CTL_InputNumber("FloorNumber", $TheEntityName["FloorNumber"], "", 55, "") . '</div>
        <div class="col-md-6"><label class="form-label">Flat Size</label>' . CTL_InputText("FlatSize", $TheEntityName["FlatSize"], "", 55, "") . '</div>
        <div class="col-md-6"><label class="form-label">Unit Price</label>' . CTL_InputNumber("UnitPrice", $TheEntityName["UnitPrice"], "", 55, "") . '</div>
        <div class="col-md-6"><label class="form-label">Total Price</label>' . CTL_InputNumber("FlatPrice", $TheEntityName["FlatPrice"], "", 55, "") . '</div>
        <div class="col-md-6"><label class="form-label">Car Parking Charge</label>' . CTL_InputNumber("CarParkingCharge", $TheEntityName["CarParkingCharge"], "", 55, "") . '</div>
        <div class="col-md-6"><label class="form-label">Utility Charge</label>' . CTL_InputNumber("UtilityCharge", $TheEntityName["UtilityCharge"], "", 55, "") . '</div>
        <div class="col-md-6"><label class="form-label">Additional Work Charge</label>' . CTL_InputNumber("AdditionalWorkCharge", $TheEntityName["AdditionalWorkCharge"], "", 55, "") . '</div>
        <div class="col-md-6"><label class="form-label">Other Charge</label>' . CTL_InputNumber("OtherCharge", $TheEntityName["OtherCharge"], "", 55, "") . '</div>
        <div class="col-md-6"><label class="form-label">Deduction/Discount</label>' . CTL_InputNumber("DeductionCharge", $TheEntityName["DeductionCharge"], "", 55, "") . '</div>
        <div class="col-md-6"><label class="form-label">Refund Additional Work Charge</label>' . CTL_InputNumber("RefundAdditionalWorkCharge", $TheEntityName["RefundAdditionalWorkCharge"], "", 55, "") . '</div>';
}
$MainContent .= '
    <div class="col-md-6"><label class="form-label">Net Sales(Flat) Price</label>' . CTL_InputNumber("NetSalesPrice", $TheEntityName["NetSalesPrice"], "", 30, "required") . '</div>
    <div class="col-12"><label class="form-label">Description</label>' . CTL_InputTextArea("Description", $TheEntityName["Description"], 40, 8, "") . '</div>
    <div class="col-12"><label class="form-label">Products Image</label>' . CTL_ImageUpload("ProductsImage", $TheEntityName["ProductsImage"], true, "FormTextInput", 100, 0, true) . '</div>
    <div class="col-md-6"><label class="form-label">Is Active?</label>' . CTL_InputRadioSet("{$Entity}IsActive", array("Yes", "No"), array(1, 0), $TheEntityName["{$Entity}IsActive"]) . '</div>
    <div class="col-md-6">
        <button type="submit" class="btn btn-success mt-4">Submit</button>
    </div>
</div>


</form>
</div>
</div>';







//$Input[] = array("VariableName" => "UtilityCharge", "Caption" => "Utility Charge", "ControlHTML" => CTL_InputText("UtilityCharge", $TheEntityName["UtilityCharge"], "", 55, "required"));

//$Input[] = array("VariableName" => "AdditionalWorkCharge", "Caption" => "Additional Work Charge", "ControlHTML" => CTL_InputText("AdditionalWorkCharge", $TheEntityName["AdditionalWorkCharge"], "", 55, "required"));

//$Input[] = array("VariableName" => "OtherCharge", "Caption" => "Other Charge", "ControlHTML" => CTL_InputText("OtherCharge", $TheEntityName["OtherCharge"], "", 55, "required"));

// $Input[] = array("VariableName" => "DeductionCharge", "Caption" => "Deduction/Discount", "ControlHTML" => CTL_InputText("DeductionCharge", $TheEntityName["DeductionCharge"], "", 55, "required"));

//$Input[] = array("VariableName" => "RefundAdditionalWorkCharge", "Caption" => "Refund Additional Work Charge", "ControlHTML" => CTL_InputText("RefundAdditionalWorkCharge", $TheEntityName["RefundAdditionalWorkCharge"], "", 55, "required"));

// $MainContent .= FormInsertUpdate(
//     $EntityName = $EntityLower,
//     $FormTitle,
//     $Input,
//     $ButtonCaption,
//     $ActionURL
// );


$MainContent .= '
    
<script>

var ModelController=(function() {
   
    
    return{
        getUnitFlightInputs:function(units,unitsPrice) {
          var unitsVal=$(units).val() == "" ? 0 : parseFloat( $(units).val() );
          var unitsPriceVal=$(unitsPrice).val() == "" ? 0 : parseFloat( $(unitsPrice).val() );
          return unitsVal*unitsPriceVal;  
        
        },
        getTotalCostPrice:function(CarParking,UtilityCharge,AdditionalWorkCharge,OtherCharge,DeductionORDiscount,Refund) {
          
          var CarParkingVal=$(CarParking).val() == "" ? 0 : parseFloat( $(CarParking).val() );
          var UtilityChargeVal=$(UtilityCharge).val() == "" ? 0 : parseFloat( $(UtilityCharge).val() );
          var AdditionalWorkChargeVal=$(AdditionalWorkCharge).val() == "" ? 0 : parseFloat( $(AdditionalWorkCharge).val() );
          var OtherChargeeVal=$(OtherCharge).val() == "" ? 0 : parseFloat( $(OtherCharge).val() );
          
          var DeductionORDiscountVal=$(DeductionORDiscount).val() == "" ? 0 : parseFloat( $(DeductionORDiscount).val() );
          
          var RefundAdditionalWorkCharge=$(Refund).val() == "" ? 0 : parseFloat( $(Refund).val() );
          
          return ((CarParkingVal+UtilityChargeVal+AdditionalWorkChargeVal+OtherChargeeVal) - DeductionORDiscountVal)-RefundAdditionalWorkCharge;
          
        }
    }
    
})();

var UiController=(function() {
    
    var htmlLabel={
        
        CategoryID:"select[name=CategoryID]",
        FlatType:"input[name=FlatType]",
        FloorNumber:"input[name=FloorNumber]",
        
        Units:"input[name=FlatSize]",
        UnitPrice:"input[name=UnitPrice]",
        
        TotalFlatPrice:"input[name=FlatPrice]",
        
        CarParking:"input[name=CarParkingCharge]",
        
        UtilityCharge:"input[name=UtilityCharge]",
        AdditionalWorkCharge:"input[name=AdditionalWorkCharge]",
        OtherCharge:"input[name=OtherCharge]",
        
        DeductionORDiscount:"input[name=DeductionCharge]",
        RefundAdditionalWorkCharge:"input[name=RefundAdditionalWorkCharge]",
        Description:"textarea[name=Description]",
        
        PurchaseLatestPrice:"input[name=NetSalesPrice]"

    };
    
    var validation=function(dom) {
      
        if ( dom.val() !="" || parseFloat(dom.val() ) > 0 ) {
           dom.css("border","1px solid rgba(0,0,0,.2)"); 
            
        }else{
            
            dom.css("border","1px solid red");
            return true;
        }
        
    };
    
    var checkNumber=function(dom) {
      
    if ( parseFloat(dom.val()) !=NaN && parseFloat(dom.val()) > 0 ){
            
             dom.css("border","1px solid rgba(0,0,0,.2)");
            
        } else {
              
             dom.css("border","1px solid red");
             return true;
        }
        
    };
    
    
    return{
        
        getDomString:function() {
          return htmlLabel;
        },
        showingFlatPrice:function(totalFlatPrice) {
          $(htmlLabel.TotalFlatPrice).val(totalFlatPrice);
        },
        showingNetSalePrice:function(netSalesPrice) {
          $(htmlLabel.PurchaseLatestPrice).val(netSalesPrice);
        },
        
        
        CheckSelectedProjectName:function() {
            var CategoryIDDom=$(htmlLabel.CategoryID);
            return validation(CategoryIDDom);
            
            
        },
        CheckFlaghtType:function() {
            var FlatTypeDom=$(htmlLabel.FlatType);
            return validation(FlatTypeDom);
            
            
        },
        CheckFloorNumber:function() {
            var FloorNumberDom=$(htmlLabel.FloorNumber);
            return validation(FloorNumberDom);
            
        },
        CheckTotalPrice:function() {
             var TotalFlatPriceDom=$(htmlLabel.TotalFlatPrice);
             return checkNumber(TotalFlatPriceDom);
            
        },
        
        CheckNetSellPrice:function() {
              var PurchaseLatestPriceDom=$(htmlLabel.PurchaseLatestPrice);
              return checkNumber(PurchaseLatestPriceDom);
             
        },
        
      
        
    }
    
    
})();

var Controller=(function(model,UiCTL) {
    
   var DomString= UiCTL.getDomString();
    
    var TotalFlaghtPrice=function() {
       
       <!--- Get input values (Units, UnitePrice) and flaght price ----->
       var totalFlaghtPrice = model.getUnitFlightInputs(DomString.Units,DomString.UnitPrice);
       
       
//       showing ui
        UiCTL.showingFlatPrice(totalFlaghtPrice);
        
//        Get other charge and deduction
        var TotalOthersPrice=model.getTotalCostPrice(DomString.CarParking,DomString.UtilityCharge,DomString.AdditionalWorkCharge,DomString.OtherCharge,DomString.DeductionORDiscount, DomString.RefundAdditionalWorkCharge);
        
                
//        Get Total Flat Price
        
        var OriginalTotalFlatPrice =  $(DomString.TotalFlatPrice).val() == "" ? 0 : parseFloat($(DomString.TotalFlatPrice).val()) ;
        
        
        
        var netSelesPrice=OriginalTotalFlatPrice+TotalOthersPrice;
        
//        Showing Ui 
        
        UiCTL.showingNetSalePrice(netSelesPrice);
  
        
    };
    
    var TotalFlaghtPrice1=function() {
       
       <!--- Get input values (Units, UnitePrice) and flaght price ----->
       var totalFlaghtPrice = model.getUnitFlightInputs(DomString.Units,DomString.UnitPrice);
       

//        Get other charge and deduction
        var TotalOthersPrice=model.getTotalCostPrice(DomString.CarParking,DomString.UtilityCharge,DomString.AdditionalWorkCharge,DomString.OtherCharge,DomString.DeductionORDiscount, DomString.RefundAdditionalWorkCharge);
        
        
//        Get Total Flat Price
        
        var OriginalTotalFlatPrice =  $(DomString.TotalFlatPrice).val() == "" ? 0 : parseFloat($(DomString.TotalFlatPrice).val()) ;
        
        
        
        var netSelesPrice=OriginalTotalFlatPrice+TotalOthersPrice;
        
//        Showing Ui 
        
        UiCTL.showingNetSalePrice(netSelesPrice);
        
  
        
    };
    
    
    
    var Submit=function(e) {
      
//        check project selected value > 0
        
        var projectId=UiCTL.CheckSelectedProjectName();
        
//        check flat type number !=
        var flaghtType = UiCTL.CheckFlaghtType();
        

        // check floor number
       var floorNumber =  UiCTL.CheckFloorNumber();
        
        
        // check flat price  > 0
       var Tprice = UiCTL.CheckTotalPrice();
        
        // check net sale price  > 0
        var SellPrice = UiCTL.CheckNetSellPrice();

        if (projectId || flaghtType || floorNumber || Tprice || SellPrice){
            e.preventDefault();
        } 
        
        
        
    };

    
    var AddEvent=function() {
      	
        $(document).on("keyup",DomString.Units,TotalFlaghtPrice);
        $(document).on("keyup",DomString.UnitPrice ,TotalFlaghtPrice);
        
        
        $(document).on("keyup",DomString.TotalFlatPrice ,TotalFlaghtPrice1);
        
        
        
        $(document).on("keyup",DomString.CarParking ,TotalFlaghtPrice1);
        $(document).on("keyup",DomString.UtilityCharge ,TotalFlaghtPrice1);
        $(document).on("keyup",DomString.AdditionalWorkCharge ,TotalFlaghtPrice1);
        $(document).on("keyup",DomString.OtherCharge ,TotalFlaghtPrice1);
        $(document).on("keyup",DomString.DeductionORDiscount ,TotalFlaghtPrice1);
        
        $(document).on("keyup",DomString.RefundAdditionalWorkCharge ,TotalFlaghtPrice1);
        
        $(document).on("submit","form" ,Submit);
        
         
    };
    
    return{
        Init:function() {
            console.log("App is running");
            $(DomString.PurchaseLatestPrice).attr("readOnly","true");
            
            AddEvent();
            
        },
    }
  
})(ModelController,UiController);

Controller.Init();
    
</script>

';


?>



