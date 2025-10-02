<?
include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";


$UpdateMode = false;
$FormTitle = "Insert $EntityCaption";
$ButtonCaption = "Insert";
$ActionURL = ApplicationURL("{$_REQUEST["Base"]}", "Insertupdateaction");

// The default value of the input box will goes here according to how many fields we showing
$TheEntityName = array(

    "ProjectName" => "",
    "HeadOfAccountName" => "",
    "VendorName" => "",
    "RequisitionName" => "",
    "PurchasName" => "",
    "Qty" => "",
    "Rate" => "",

    "{$Entity}IsActive" => 0
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

$Input[] = array("VariableName" => "FormProjectID", "Caption" => "Project Name", "ControlHTML" => CCTL_ProductsCategory($Name = "ProjectID", $TheEntityName["ProjectID"], $Where = "", $PrependBlankOption = true));
$Input[] = array("VariableName" => "FormHeadOfAccountID0", "Caption" => "Head of Accounts", "ControlHTML" => GetExpenseID($Name = "HeadOfAccountID", $TheEntityName["HeadOfAccountID"], $Where = "", $PrependBlankOption = true, $Class = "form-select"));

$Input[] = array("VariableName" => "VendorID", "Caption" => "Vendor", "ControlHTML" => CCTL_Vendor($Name = "VendorID", $TheEntityName["VendorID"], $Where = "", $PrependBlankOption = true));


//$Input[] = array("VariableName" => "RequisitionID", "Caption" => "Requisition ID", "ControlHTML" => CTL_GETRequisitonID($Name = "RequisitionID", $ValueSelected = $TheEntityName["RequisitionID"], $Where = "", $PrependBlankOption = true, $Class = ""));
$Input[] = array("VariableName" => "PurchaseID", "Caption" => "Purchase ID", "ControlHTML" => CTL_GETPurchaseOrderID($Name = "PurchaseID", $ValueSelected = $TheEntityName["PurchaseID"], $Where = "", $PrependBlankOption = true, $Class = "") . " <span id='reDetails'>Ordered Quentity <b id='qnt'></b>, Requisition Rate <b id='rate'></b>, Requisition Amount <b id='amount'></b></span> ");

$Input[] = array("VariableName" => "Qty", "Caption" => "Quantity", "ControlHTML" => CTL_InputText("Qty", $TheEntityName["Qty"], "", 30, "required"));
$Input[] = array("VariableName" => "Rate", "Caption" => "Rate", "ControlHTML" => CTL_InputText("Rate", $TheEntityName["Rate"], "", 30, "required"));
$Input[] = array("VariableName" => "Value", "Caption" => "Value", "ControlHTML" => CTL_InputText("Value", $TheEntityName["Value"], "", 30, "required"));

$Input[] = array("VariableName" => "Date", "Caption" => "Date", "ControlHTML" => CTL_InputTextDate("Date", $TheEntityName["Date"], "", 30, "required"));


$Input[] = array("VariableName" => "IsActive", "Caption" => "Is Stock?", "ControlHTML" => CTL_InputRadioSet($VariableName = "{$Entity}IsActive", $Captions = array("Yes", "No"), $Values = array(1, 0), $CurrentValue = $TheEntityName["{$Entity}IsActive"]), "Required" => false);

$MainContent .= FormInsertUpdate(
    $EntityName = $EntityLower,
    $FormTitle,
    $Input,
    $ButtonCaption,
    $ActionURL
);


$MainContent .= '

    
    <script>


    
        var Model = (function() {
          
            var data= function(Fields ,Values) {
              
                var ProjectID= Values.ProjectID;
                var HeadOfAccountID= Values.HeadOfAccountID;
                var VendorID= Values.VendorID;
                var RequisitionID= Values.RequisitionID;
                var PurchaseID= Values.PurchaseID;
                //alert(ProjectID + " " + HeadOfAccountID + " " + VendorID + " " + RequisitionID + " " + PurchaseID);
                Fields.reSpanDetailsDom.style.display="none";
                
                    
                $.ajax({
                    
                    type: "POST",
                    url: "index.php?Theme=default&Base=Stock&Script=AjaxRequiest&NoHeader&NoFooter",
                    dataType: "json",
                    data: { ProjectID: ProjectID, HeadOfAccountID: HeadOfAccountID, VendorID: VendorID, PurchaseID: PurchaseID },
                    
                    success: function(data) {
                        
                       Fields.qntSpanDom.textContent= data.requisitionQty;
                       Fields.rateSpanDom.textContent= data.requisitionRate;
                       Fields.amountSpanDom.textContent= data.requisitionAmount;
                       
                       Fields.reSpanDetailsDom.style.display="block";
                        
                        
                    },
                    error: function(xhr) { // if error occured
                         Fields.reSpanDetailsDom.style.display="none";
                    },
                
                });
                
                  
            };
            
            return{
                
                getData: function(Fields ,Values) {
                   data(Fields ,Values);
                   
                },
                
            }
            
            
        })();
    
        
        var UiCnt = (function() {
          var DomString ={
            ProjectID: "select[name=ProjectID]",  
            HeadOfAccountID: "select[name=HeadOfAccountID]",  
            VendorID: "select[name=VendorID]",  
            
            PurchaseID: "select[name=PurchaseID]",  
            Qty: "input[name=Qty]",  
            Rate: "input[name=Rate]",  
            Value: "input[name=Value]",  
            Date: "input[name=Date]",  
            
            reSpanDetails: "reDetails",  
            
            qntSpan: "qnt",  
            rateSpan: "rate",  
            amountSpan: "amount",  
            
            form: "form",
              
          };
          
          return{
              getDomString: function() {
                return DomString;
              },
              getFields: function() {
                return{
                    ProjectIDDom: document.querySelector(DomString.ProjectID),
                    HeadOfAccountIDDom: document.querySelector(DomString.HeadOfAccountID),
                    VendorIDDom: document.querySelector(DomString.VendorID),
                    
                    PurchaseIDDom: document.querySelector(DomString.PurchaseID),
                    
                    QtyDom: document.querySelector(DomString.Qty),
                    RateDom: document.querySelector(DomString.Rate),
                    ValueDom: document.querySelector(DomString.Value),
                    DateDom: document.querySelector(DomString.Date),
                    
                    reSpanDetailsDom: document.getElementById(DomString.reSpanDetails),
                    qntSpanDom: document.getElementById(DomString.qntSpan),
                    rateSpanDom: document.getElementById(DomString.rateSpan),
                    amountSpanDom: document.getElementById(DomString.amountSpan),
                    
                    formDom: document.querySelector(DomString.form),
                }
                  
              },
              getValues: function() {
                  var Fields=this.getFields();
                  return{
                      ProjectID: Fields.ProjectIDDom.value == "" ? 0 : parseFloat(Fields.ProjectIDDom.value),
                      HeadOfAccountID: Fields.HeadOfAccountIDDom.value == "" ? 0 : parseFloat(Fields.HeadOfAccountIDDom.value),
                      VendorID: Fields.VendorIDDom.value == "" ? 0 : parseFloat(Fields.VendorIDDom.value),
                      
                      PurchaseID: Fields.PurchaseIDDom.value == "" ? 0 : Fields.PurchaseIDDom.value,
                      Date: Fields.DateDom.value == "" ? 0 : Fields.DateDom.value,
                      Qty: Fields.QtyDom.value == "" ? 0 : parseFloat(Fields.QtyDom.value),
                      Rate: Fields.RateDom.value == "" ? 0 : parseFloat(Fields.RateDom.value),
                      Value: Fields.ValueDom.value == "" ? 0 : parseFloat(Fields.ValueDom.value),
                      
                  }
                
              },
              
              getMultiPlication: function() {
                  var Fields=this.getFields();
                  var Values=this.getValues();
                  
                  var mul= Values.Qty * Values.Rate;
                  
                  Fields.ValueDom.value=mul;
                  
                  
              },
              
              
               
          }
            
            
            
        })();


        
        var Controller = (function(Model, UiCnt) {
            
           
            var DomString = UiCnt.getDomString();
            var Fields = UiCnt.getFields();
            
            var mainHandler= function() {
                Fields.ProjectIDDom.addEventListener("change",getIdes);
                Fields.HeadOfAccountIDDom.addEventListener("change",getIdes);
                Fields.VendorIDDom.addEventListener("change",getIdes);
                
                Fields.PurchaseIDDom.addEventListener("change",getIdes);
                
                Fields.QtyDom.addEventListener("keyup", getQntValue);
                Fields.RateDom.addEventListener("keyup",getQntValue);
                
                Fields.formDom.addEventListener("submit",formSubmit);
                
                
               
            };
            
            var formSubmit = function(e) {
               var Values = UiCnt.getValues();
               var Fields = UiCnt.getFields();
                
                
              if( Values.ProjectID > 0 ){
                  Fields.ProjectIDDom.style.border="1px solid rgba(0,0,0,.3)";
              }else{
                Fields.ProjectIDDom.style.border="1px solid red"; 
                e.preventDefault();
              }
              
              if( Values.HeadOfAccountID > 0 ){
                  Fields.HeadOfAccountIDDom.style.border="1px solid rgba(0,0,0,.3)";
              }else{
                Fields.HeadOfAccountIDDom.style.border="1px solid red";
                e.preventDefault();
              }
              
              if( Values.VendorID > 0 ){
                  Fields.VendorIDDom.style.border="1px solid rgba(0,0,0,.3)";
              }else{
                Fields.VendorIDDom.style.border="1px solid red";
                e.preventDefault();
              }
              
            //   if( Values.RequisitionID > 0 ){
            //       Fields.RequisitionIDDom.style.border="1px solid rgba(0,0,0,.3)";
            //   }else{
            //     Fields.RequisitionIDDom.style.border="1px solid red";
            //     e.preventDefault();
            //   }
              
              if( Values.PurchaseID !="" ){
                  Fields.PurchaseIDDom.style.border="1px solid rgba(0,0,0,.3)";
              }else{
                Fields.PurchaseIDDom.style.border="1px solid red";
                e.preventDefault();
              }
              
              if( Values.Qty > 0 ){
                  Fields.QtyDom.style.border="1px solid rgba(0,0,0,.3)";
              }else{
                Fields.QtyDom.style.border="1px solid red";
                e.preventDefault();
              }
              
              if( Values.Rate > 0 ){
                  Fields.RateDom.style.border="1px solid rgba(0,0,0,.3)";
              }else{
                Fields.RateDom.style.border="1px solid red";
                e.preventDefault();
              }
              
              
              if( Values.Date != 0 ){
                  Fields.DateDom.style.border="1px solid rgba(0,0,0,.3)";
              }else{
                Fields.DateDom.style.border="1px solid red";
                e.preventDefault();
              }
              
            };
            
            
            var getQntValue = function() {
              UiCnt.getMultiPlication()
                
            };
            
            
            var getIdes=function() {
               var Values = UiCnt.getValues();
               var Fields = UiCnt.getFields();
               
               
               //if ( Values.ProjectID > 0 && Values.HeadOfAccountID > 0 && Values.VendorID > 0 && Values.RequisitionID > 0 && Values.PurchaseID !=""  ){
               if ( Values.ProjectID > 0 && Values.HeadOfAccountID > 0 && Values.VendorID > 0  && Values.PurchaseID !=""  ){
                  
                   Model.getData(Fields ,Values);
                   
               } else{
                   Fields.reSpanDetailsDom.style.display="none";
               }
               
                
            };
            
            return{
                
                init:function() {
                  
                    console.log("App Is running");
                    mainHandler();
                    
                    
                    Fields.QtyDom.type="text";
                    Fields.RateDom.type="text";
                    Fields.ValueDom.type="number";
                    
                    Fields.reSpanDetailsDom.style.display="none";
                    Fields.ValueDom.readOnly="true";
                    
                    
                },
                
            }
            
          



        })(Model,UiCnt);
        
        
        Controller.init();
        

  



        document.getElementById(\'basic_validate\').addEventListener(\'submit\', function(e) {
            var qty = parseFloat(document.getElementById("Qty").value);
            var qnt = parseFloat(document.getElementById("qnt").innerText);

            //alert(qty);
            //alert(qnt);


            if ( qty <= 0) {
                document.getElementById("Qty").style.border = "1px solid red";
                alert("Please enter a valid quantity greater than 0");

                e.preventDefault(); // prevent form submission
            }else if( qty > qnt){ 
                document.getElementById("Qty").style.border = "1px solid red";
                alert("You can not insert more than ordered quantity " + qnt);
                e.preventDefault(); // prevent form submission
                
            }else {
                document.getElementById("Qty").style.border = ""; // reset border
                // Form will submit
                form.submit();
            }
        });




    
    </script>






';


?>