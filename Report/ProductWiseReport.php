<?



$GetCompanyInfo=SQL_Select("Settings","SettingsID=1","","true");
$CompanyPad = '
        <table align="center">
            <tr>
                <td align="center">
                    <b style="font-size:25px;">'.$GetCompanyInfo["CompanyName"].'</b><br>
                    '.nl2br($GetCompanyInfo["Address"]).'
                </td>
            </tr>
        </table>
    ';

// Stock IN
$StockINPurchase=SQL_Select("purchase","PurchaseIsActive=1");

foreach ($StockINPurchase as $ThisStockINPurchase) {

    $StockIN = SQL_Select("purchasedproducts", "ProductID='{$_REQUEST["ProductsID"]}' and TempNumber='{$ThisStockINPurchase["TempNumber"]}'");
    foreach ($StockIN as $ThisStockIN) {
        $StockINHTML .= '
        <tr>
            <td style="border : 1px solid black;" align="center">
                '.$ThisStockINPurchase["PurchaseID"].'
            </td>
            <td style="border : 1px solid black;" align="center">
                '.$ThisStockIN["DateInserted"].'
            </td>
            <td style="border : 1px solid black;" align="center">
                '.$ThisStockIN["Qty"].'
            </td>
            <td style="border : 1px solid black;" align="center">
                '.$ThisStockIN["CostPerProduct"].'
            </td>
            <td style="border : 1px solid black;" align="center">
                '.GetVendorName($ThisStockIN["VendorID"]).'
            </td>
        </tr>
    ';

    }

}
// end of stock IN

// Stock OUT
$Sales=SQL_Select("Sales","SalesIsActive=1");

foreach ($Sales as $ThisSales) {

    $StockOut = SQL_Select("SalesOrder", "ProductID='{$_REQUEST["ProductsID"]}' and TempNumber='{$ThisSales["TempNumber"]}'");
    foreach ($StockOut as $ThisStockOut) {
        $StockOUTHTML .= '
        <tr>
            <td style="border : 1px solid black;" align="center">
                '.$ThisSales["SalesID"].'
            </td>
            <td style="border : 1px solid black;" align="center">
                '.$ThisSales["DateInserted"].'
            </td>
            <td style="border : 1px solid black;" align="center">
                '.$ThisStockOut["Qty"].'
            </td>
            <td style="border : 1px solid black;" align="center">
                '.$ThisStockOut["Price"].'
            </td>
            <td style="border : 1px solid black;" align="center">
                '.GetCustomerName($ThisSales["CustomerID"]).'
            </td>
        </tr>
    ';

    }

}
// End of Stock OUT

$MainContent.='
    <br><br>
    '.$CompanyPad.'
    <br>
    <center>
        <span style="font-size: 24px;"> Product Name : '.GetProductName($_REQUEST["ProductsID"]).'</span><br>
        
        <span style="color:black;font-family:arial;text-decoration:none;">
            Date : <b>'.$_REQUEST["FromDate"].'</b> To <b>'.$_REQUEST["ToDate"].'</b><br>
        </span>
    </center>
    <table width="100%">
        <tr>
            <td valign="top">
                <center>
                    <hr>
                        <span style="font-size: 20px;"> Stock In</span>
                    <hr>
                </center>

                <table width="100%">
                    <tr>
                        <td style="border : 1px solid black;" align="center">
                            <b>PO No.</b>
                        </td>
                        <td style="border : 1px solid black;" align="center">
                            <b>Date</b>
                        </td>
                        <td style="border : 1px solid black;" align="center">
                            <b>Qty</b>
                        </td>
                        <td style="border : 1px solid black;" align="center">
                            <b>Price</b>
                        </td>
                        <td style="border : 1px solid black;" align="center">
                            <b>Supplier</b>
                        </td>
                    </tr>
                    '.$StockINHTML.'
                </table>
            
            </td>
            
            <td width="50">
            
            </td>
            
            <td valign="top">
                <center>
                    <hr>
                    <span style="font-size: 20px;"> Stock Out</span>
                    <hr>
                </center>
                <table width="100%">
                    <tr>
                        <td style="border : 1px solid black;" align="center">
                            <b>Invoice No.</b>
                        </td>
                        <td style="border : 1px solid black;" align="center">
                            <b>Date</b>
                        </td>
                        <td style="border : 1px solid black;" align="center">
                            <b>Qty</b>
                        </td>
                        <td style="border : 1px solid black;" align="center">
                            <b>Price</b>
                        </td>
                        <td style="border : 1px solid black;" align="center">
                            <b>Supplier</b>
                        </td>
                    </tr>
                    '.$StockOUTHTML.'
                </table>

            
            </td>
            
        </tr>
    </table>


';




?>