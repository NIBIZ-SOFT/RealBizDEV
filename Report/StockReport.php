<?php


$Settings = SQL_Select("Settings", "SettingsID=1", "", true);

$FromDate = "UpTo";
$ToDate = date("d-m-Y");

if (empty($_POST["CategoryID"]) and empty($_POST["FromDate"]) and empty($_POST["ToDate"]) and empty($_POST["HeadOfAccountID"]) ) {
//    All Categories no date

    $projects = SQL_Select("Category");

//    Stock
    $projectHeadTableHtml="";
    $stockRowHtml="";

    $totalStockValue=0;
    $totalUsedStockValue=0;
    foreach ($projects as $project) {
        $stocks= SQL_Select("stock where ProjectID={$project["CategoryID"]} and StockIsActive=1");

        if (empty($stocks)) continue;

        $projectHeadTableHtml ='
            <div class="col-12">
                <table class="table table-bordered table-hover table-fixed table-sm">
                        <thead>
                        
                        <tr>
                            <th class="text-center" colspan="6" scope="col"><h4>' . $stocks[0]["ProjectName"] . '</h4></th>
                            <th class="text-center" colspan="6" scope="col"><h4>' . $FromDate . "-" . $ToDate . '</h4></th>
                            
                        </tr>
                        </thead>
                        
                </table>
            </div>
        ';



        $stockTrHtml="";
        $sl=1;
        $totalValue=0;
        foreach ($stocks as $stock){

            $totalValue +=$stock["Value"];
            $totalStockValue +=$stock["Value"];
            $stockTrHtml .='<tr>
                            <th style="width: 10px;" class="text-center" scope="row">'.$sl.'</th>
                            <td class="text-left" >'.$stock["Date"].'</td>
                            <td class="text-left" >'.$stock["HeadOfAccountName"].'</td>
                            <td class="text-right" >'.$stock["Qty"].'</td>
                            <td class="text-right" >'.$stock["Rate"].'</td>
                            <td class="text-right" >'.BangladeshiCurencyFormat($stock["Value"]).'</td>
                            
                        </tr>';
            $sl++;

        }

        $UsedStocks= SQL_Select("usedstock where ProjectID={$project["CategoryID"]}  and UsedStockIsActive=1 ");

        $usedStockTrHtml="";
        $sl=1;
        $usedStockValue=0;
        foreach ($UsedStocks as $UsedStock){

            $usedStockValue +=$UsedStock["Value"];

            $totalUsedStockValue +=$UsedStock["Value"];

            $usedStockTrHtml .='<tr>
                            <th style="width: 10px;" class="text-center" scope="row">'.$sl.'</th>
                            <td class="text-left" >'.$UsedStock["Date"].'</td>
                            <td class="text-left" >'.$UsedStock["HeadOfAccountName"].'</td>
                            <td class="text-right" >'.$UsedStock["Qty"].'</td>
                            <td class="text-right" >'.$UsedStock["Rate"].'</td>
                            <td class="text-right" >'.BangladeshiCurencyFormat($UsedStock["Value"]).'</td>
                            
                        </tr>';

            $sl++;
        }


//      Present Stock Html
        $PresentStockTrHtml="";
        $sl=1;
        $usedStockValue=0;
        $TotalPresentStockAmount=0;
        foreach ($stocks as $stock){

            $HeadOfAccountID=$stock["HeadOfAccountID"];
            $HeadOfAccountName=$stock["HeadOfAccountName"];

            $StockQty=$stock["Qty"];
            $StockRate=$stock["Rate"];
            $StockAmount=$stock["Value"];

            $UsedStocks= SQL_Select("usedstock where ProjectID={$project["CategoryID"]} and HeadOfAccountID={$HeadOfAccountID}  and UsedStockIsActive=1 ");

            $usedStockQnt=$UsedStocks[0]["Qty"];
            $usedStockRate=$UsedStocks[0]["Rate"];
            $usedStockValue=$UsedStocks[0]["Value"];


            $presentStockQnt=$StockQty-$usedStockQnt;



            if ($presentStockQnt==0){
                $StockRate=0;
            }

            $presentStockAmount=$StockAmount-$usedStockValue;

            $TotalPresentStockAmount +=$presentStockAmount;


            $PresentStockTrHtml .='<tr>
                            <th style="width: 10px;" class="text-center" scope="row">'.$sl.'</th>
                            <td class="text-left" >'.$UsedStock["Date"].'</td>
                            <td class="text-left" >'.$UsedStock["HeadOfAccountName"].'</td>
                            <td class="text-right" >'.$presentStockQnt.'</td>
                            <td class="text-right" >'.BangladeshiCurencyFormat($StockRate).'</td>
                            <td class="text-right" >'.BangladeshiCurencyFormat($presentStockAmount).'</td>
                            
                        </tr>';

            $sl++;
        }



        $stockRowHtml .='
        
        '.$projectHeadTableHtml.'

        <div class="col-6"> 
            <div class="row"> 
                <div class="col-12"> 
                    <table class="table table-bordered table-hover table-fixed table-sm">
                    
                        <thead>
                        <tr>
                            <th class="text-center" colspan="6" scope="col"><h5> Total Stock</h5></th>
                            
                        </tr>
                        </thead>
                        
                        <thead>
                        <tr>
                            <th scope="col">Sl.No</th>
                            <th scope="col">Date</th>
                            <th  class="text-left"  scope="col">Head Of Account</th>
                 
                            <th class="text-right" scope="col">Qnt</th>
                            <th class="text-right" scope="col">Rate</th>
                            <th class="text-right" scope="col">Amount</th>
                            
                        </tr>
                        </thead>
                        
                        <tbody>
                        
                        '.$stockTrHtml.'
                        
                        </tbody>
                        
                        <thead>
                        <tr>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            
                        </tr>
                        </thead>
                        
                        <thead>
                        <tr>
                            <th class="text-right" colspan="5" scope="col" >Total =</th>
                            <th class="text-right"  scope="col" >' . BangladeshiCurencyFormat($totalValue) . '</th>
                            
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>  
        
        
        
        
        <div class="col-6"> 
        
            <div class="row"> 
                <div class="col-12"> 
                    <table class="table table-bordered table-hover table-fixed table-sm">
                    
                        <thead>
                        <tr>
                            <th class="text-center" colspan="6" scope="col"><h5> Total Used Stock</h5></th>
                            
                        </tr>
                        </thead>
                        
                        <thead>
                        <tr>
                            <th scope="col">Sl.No</th>
                            <th scope="col">Date</th>
                            <th  class="text-left"  scope="col">Head Of Account</th>
                 
                            <th class="text-right" scope="col">Qnt</th>
                            <th class="text-right" scope="col">Rate</th>
                            <th class="text-right" scope="col">Amount</th>
                            
                        </tr>
                        </thead>
                        
                        
                        <tbody>
                        
                        '.$usedStockTrHtml.'
                        
                        </tbody>
                        
                        <thead>
                        <tr>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            
                        </tr>
                        </thead>
                        
                        <thead>
                        <tr>
                            <th class="text-right" colspan="5" scope="col" >Total =</th>
                            <th class="text-right"  scope="col" >' . BangladeshiCurencyFormat($usedStockValue) . '</th>
                            
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
            
        </div>
        
        
        <div class="col-3"></div>
        <div class="col-6"> 
        
            <div class="row"> 
                <div class="col-12"> 
                    <table class="table table-bordered table-hover table-fixed table-sm">
                    
                        <thead>
                        <tr>
                            <th class="text-center" colspan="6" scope="col"><h5>Present Stock</h5></th>
                            
                        </tr>
                        </thead>
                        
                        <thead>
                        <tr>
                            <th scope="col">Sl.No</th>
                            <th scope="col">Date</th>
                            <th  class="text-left"  scope="col">Head Of Account</th>
                 
                            <th class="text-right" scope="col">Qnt</th>
                            <th class="text-right" scope="col">Rate</th>
                            <th class="text-right" scope="col">Amount</th>
                            
                        </tr>
                        </thead>
                        
                        
                        <tbody>
                        
                        
                        '.$PresentStockTrHtml.'
                        
                        </tbody>
                        
                        <thead>
                        <tr>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            
                        </tr>
                        </thead>
                        
                        <thead>
                        <tr>
                            <th class="text-right" colspan="5" scope="col" >Total =</th>
                            <th class="text-right"  scope="col" >' . BangladeshiCurencyFormat($TotalPresentStockAmount) . '</th>
                            
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
            
        </div>
        
        <div class="col-3"></div>
        
            
            ';

        
    }

    $PresentStock=$totalStockValue - $totalUsedStockValue;


    $stockUsedStockHtml ='

    <div class="row">
         
        '.$stockRowHtml.'
        
    </div>';




} elseif (!empty($_POST["CategoryID"]) and empty($_POST["FromDate"]) and empty($_POST["ToDate"])  and empty($_POST["HeadOfAccountID"]) ) {
//    One Categories No dates


    $projects = SQL_Select("Category where CategoryID={$_POST["CategoryID"]}");

//    Stock
    $projectHeadTableHtml="";
    $stockRowHtml="";

    $totalStockValue=0;
    $totalUsedStockValue=0;
    foreach ($projects as $project) {
        $stocks= SQL_Select("stock where ProjectID={$project["CategoryID"]} and StockIsActive=1");

        if (empty($stocks)) continue;


        $projectHeadTableHtml ='
            <div class="col-12">
                <table class="table table-bordered table-hover table-fixed table-sm">
                        <thead>
                        
                        <tr>
                            <th class="text-center" colspan="6" scope="col"><h4>' . $stocks[0]["ProjectName"] . '</h4></th>
                            <th class="text-center" colspan="6" scope="col"><h4>' . $FromDate . "-" . $ToDate . '</h4></th>
                            
                        </tr>
                        </thead>
                        
                </table>
            </div>
        ';


        $stockTrHtml="";
        $sl=1;
        $totalValue=0;
        foreach ($stocks as $stock){

            $totalValue +=$stock["Value"];
            $totalStockValue +=$stock["Value"];
            $stockTrHtml .='<tr>
                            <th style="width: 10px;" class="text-center" scope="row">'.$sl.'</th>
                            <td class="text-left" >'.$stock["Date"].'</td>
                            <td class="text-left" >'.$stock["HeadOfAccountName"].'</td>
                            <td class="text-right" >'.$stock["Qty"].'</td>
                            <td class="text-right" >'.$stock["Rate"].'</td>
                            <td class="text-right" >'.BangladeshiCurencyFormat($stock["Value"]).'</td>
                            
                        </tr>';
            $sl++;


        }

        $UsedStocks= SQL_Select("usedstock where ProjectID={$project["CategoryID"]}  and UsedStockIsActive=1 ");

        $usedStockTrHtml="";
        $sl=1;
        $usedStockValue=0;
        foreach ($UsedStocks as $UsedStock){

            $usedStockValue +=$UsedStock["Value"];

            $totalUsedStockValue +=$UsedStock["Value"];

            $usedStockTrHtml .='<tr>
                            <th style="width: 10px;" class="text-center" scope="row">'.$sl.'</th>
                            <td class="text-left" >'.$UsedStock["Date"].'</td>
                            <td class="text-left" >'.$UsedStock["HeadOfAccountName"].'</td>
                            <td class="text-right" >'.$UsedStock["Qty"].'</td>
                            <td class="text-right" >'.$UsedStock["Rate"].'</td>
                            <td class="text-right" >'.BangladeshiCurencyFormat($UsedStock["Value"]).'</td>
                            
                        </tr>';

            $sl++;
        }



//      Present Stock Html

        $PresentStockTrHtml="";
        $sl=1;
        $usedStockValue=0;
        $TotalPresentStockAmount=0;
        foreach ($stocks as $stock){

            $HeadOfAccountID=$stock["HeadOfAccountID"];
            $HeadOfAccountName=$stock["HeadOfAccountName"];

            $StockQty=$stock["Qty"];
            $StockRate=$stock["Rate"];
            $StockAmount=$stock["Value"];

            $UsedStocks= SQL_Select("usedstock where ProjectID={$project["CategoryID"]} and HeadOfAccountID={$HeadOfAccountID}  and UsedStockIsActive=1 ");

            $usedStockQnt=$UsedStocks[0]["Qty"];
            $usedStockRate=$UsedStocks[0]["Rate"];
            $usedStockValue=$UsedStocks[0]["Value"];


            $presentStockQnt=$StockQty-$usedStockQnt;

            if ($presentStockQnt==0){
                $StockRate=0;
            }

            $presentStockAmount=$StockAmount-$usedStockValue;

            $TotalPresentStockAmount +=$presentStockAmount;


            $PresentStockTrHtml .='<tr>
                            <th style="width: 10px;" class="text-center" scope="row">'.$sl.'</th>
                            <td class="text-left" >'.$UsedStock["Date"].'</td>
                            <td class="text-left" >'.$UsedStock["HeadOfAccountName"].'</td>
                            <td class="text-right" >'.$presentStockQnt.'</td>
                            <td class="text-right" >'.BangladeshiCurencyFormat($StockRate).'</td>
                            <td class="text-right" >'.BangladeshiCurencyFormat($presentStockAmount).'</td>
                            
                        </tr>';

            $sl++;
        }

        $stockRowHtml .='
        
        '.$projectHeadTableHtml.'

        <div class="col-6"> 
            <div class="row"> 
                <div class="col-12"> 
                    <table class="table table-bordered table-hover table-fixed table-sm">
                    
                        <thead>
                        <tr>
                            <th class="text-center" colspan="6" scope="col"><h5> Total Stock</h5></th>
                            
                        </tr>
                        </thead>
                        
                        <thead>
                        <tr>
                            <th scope="col">Sl.No</th>
                            <th scope="col">Date</th>
                            <th  class="text-left"  scope="col">Head Of Account</th>
                 
                            <th class="text-right" scope="col">Qnt</th>
                            <th class="text-right" scope="col">Rate</th>
                            <th class="text-right" scope="col">Amount</th>
                            
                        </tr>
                        </thead>
                        
                        <tbody>
                        
                        '.$stockTrHtml.'
                        
                        </tbody>
                        
                        <thead>
                        <tr>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            
                        </tr>
                        </thead>
                        
                        <thead>
                        <tr>
                            <th class="text-right" colspan="5" scope="col" >Total =</th>
                            <th class="text-right"  scope="col" >' . BangladeshiCurencyFormat($totalValue) . '</th>
                            
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>  
        
        
        
        <div class="col-6"> 
        
            <div class="row"> 
                <div class="col-12"> 
                    <table class="table table-bordered table-hover table-fixed table-sm">
                    
                        <thead>
                        <tr>
                            <th class="text-center" colspan="6" scope="col"><h5> Total Used Stock</h5></th>
                            
                        </tr>
                        </thead>
                        
                        <thead>
                        <tr>
                            <th scope="col">Sl.No</th>
                            <th scope="col">Date</th>
                            <th  class="text-left"  scope="col">Head Of Account</th>
                 
                            <th class="text-right" scope="col">Qnt</th>
                            <th class="text-right" scope="col">Rate</th>
                            <th class="text-right" scope="col">Amount</th>
                            
                        </tr>
                        </thead>
                        
                        
                        <tbody>
                        
                        '.$usedStockTrHtml.'
                        
                        </tbody>
                        
                        <thead>
                        <tr>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            
                        </tr>
                        </thead>
                        
                        <thead>
                        <tr>
                            <th class="text-right" colspan="5" scope="col" >Total =</th>
                            <th class="text-right"  scope="col" >' . BangladeshiCurencyFormat($usedStockValue) . '</th>
                            
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
            
        </div>  
        
        
        
<!--   Present Stock  -->

        <div class="col-3"></div>
        <div class="col-6"> 
        
            <div class="row"> 
                <div class="col-12"> 
                    <table class="table table-bordered table-hover table-fixed table-sm">
                    
                        <thead>
                        <tr>
                            <th class="text-center" colspan="6" scope="col"><h5>Present Stock</h5></th>
                            
                        </tr>
                        </thead>
                        
                        <thead>
                        <tr>
                            <th scope="col">Sl.No</th>
                            <th scope="col">Date</th>
                            <th  class="text-left"  scope="col">Head Of Account</th>
                 
                            <th class="text-right" scope="col">Qnt</th>
                            <th class="text-right" scope="col">Rate</th>
                            <th class="text-right" scope="col">Amount</th>
                            
                        </tr>
                        </thead>
                        
                        
                        <tbody>
                        
                        
                        '.$PresentStockTrHtml.'
                        
                        </tbody>
                        
                        <thead>
                        <tr>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            
                        </tr>
                        </thead>
                        
                        <thead>
                        <tr>
                            <th class="text-right" colspan="5" scope="col" >Total =</th>
                            <th class="text-right"  scope="col" >' . BangladeshiCurencyFormat($TotalPresentStockAmount) . '</th>
                            
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
            
        </div>
        
        <div class="col-3"></div>
        
            ';


    }

    $PresentStock=$totalStockValue - $totalUsedStockValue;


    $stockUsedStockHtml ='

    <div class="row">
         
        '.$stockRowHtml.'
        
    </div>';

} elseif (!empty($_POST["CategoryID"]) and !empty($_POST["FromDate"]) and !empty($_POST["ToDate"])  and empty($_POST["HeadOfAccountID"]) ) {
//    One Project Date Wayes


    $FromDate = $_POST["FromDate"];
    $ToDate = " To ".$_POST["ToDate"];


    $projects = SQL_Select("Category where CategoryID={$_POST["CategoryID"]}");

//    Stock
    $projectHeadTableHtml="";
    $stockRowHtml="";

    $totalStockValue=0;
    $totalUsedStockValue=0;
    foreach ($projects as $project) {
        $stocks= SQL_Select("stock where ProjectID={$project["CategoryID"]}  and StockIsActive=1   and  Date BETWEEN '{$_REQUEST["FromDate"]}' AND  '{$_REQUEST["ToDate"]}' ");

        if (empty($stocks)) continue;


        $projectHeadTableHtml ='
            <div class="col-12">
                <table class="table table-bordered table-hover table-fixed table-sm">
                        <thead>
                        
                        <tr>
                            <th class="text-center" colspan="6" scope="col"><h4>' . $stocks[0]["ProjectName"] . '</h4></th>
                            <th class="text-center" colspan="6" scope="col"><h4>' . $FromDate . "" . $ToDate . '</h4></th>
                            
                        </tr>
                        </thead>
                        
                </table>
            </div>
        ';


        $stockTrHtml="";
        $sl=1;
        $totalValue=0;
        foreach ($stocks as $stock){

            $totalValue +=$stock["Value"];
            $totalStockValue +=$stock["Value"];
            $stockTrHtml .='<tr>
                            <th style="width: 10px;" class="text-center" scope="row">'.$sl.'</th>
                            <td class="text-left" >'.$stock["Date"].'</td>
                            <td class="text-left" >'.$stock["HeadOfAccountName"].'</td>
                            <td class="text-right" >'.$stock["Qty"].'</td>
                            <td class="text-right" >'.$stock["Rate"].'</td>
                            <td class="text-right" >'.BangladeshiCurencyFormat($stock["Value"]).'</td>
                            
                        </tr>';
            $sl++;


        }

        $UsedStocks= SQL_Select("usedstock where ProjectID={$project["CategoryID"]}  and UsedStockIsActive=1 and  Date BETWEEN '{$_REQUEST["FromDate"]}' AND  '{$_REQUEST["ToDate"]}' ");

        $usedStockTrHtml="";
        $sl=1;
        $usedStockValue=0;
        foreach ($UsedStocks as $UsedStock){

            $usedStockValue +=$UsedStock["Value"];

            $totalUsedStockValue +=$UsedStock["Value"];

            $usedStockTrHtml .='<tr>
                            <th style="width: 10px;" class="text-center" scope="row">'.$sl.'</th>
                            <td class="text-left" >'.$UsedStock["Date"].'</td>
                            <td class="text-left" >'.$UsedStock["HeadOfAccountName"].'</td>
                            <td class="text-right" >'.$UsedStock["Qty"].'</td>
                            <td class="text-right" >'.$UsedStock["Rate"].'</td>
                            <td class="text-right" >'.BangladeshiCurencyFormat($UsedStock["Value"]).'</td>
                            
                        </tr>';

            $sl++;
        }


//      Present Stock Html

        $PresentStockTrHtml="";
        $sl=1;
        $usedStockValue=0;
        $TotalPresentStockAmount=0;
        foreach ($stocks as $stock){

            $HeadOfAccountID=$stock["HeadOfAccountID"];
            $HeadOfAccountName=$stock["HeadOfAccountName"];

            $StockQty=$stock["Qty"];
            $StockRate=$stock["Rate"];
            $StockAmount=$stock["Value"];

            $UsedStocks= SQL_Select("usedstock where ProjectID={$project["CategoryID"]} and HeadOfAccountID={$HeadOfAccountID}  and UsedStockIsActive=1  and  Date BETWEEN '{$_REQUEST["FromDate"]}' AND  '{$_REQUEST["ToDate"]}'  ");

            $usedStockQnt=$UsedStocks[0]["Qty"];
            $usedStockRate=$UsedStocks[0]["Rate"];
            $usedStockValue=$UsedStocks[0]["Value"];


            $presentStockQnt=$StockQty-$usedStockQnt;

            if ($presentStockQnt==0){
                $StockRate=0;
            }

            $presentStockAmount=$StockAmount-$usedStockValue;

            $TotalPresentStockAmount +=$presentStockAmount;


            $PresentStockTrHtml .='<tr>
                            <th style="width: 10px;" class="text-center" scope="row">'.$sl.'</th>
                            <td class="text-left" >'.$UsedStock["Date"].'</td>
                            <td class="text-left" >'.$UsedStock["HeadOfAccountName"].'</td>
                            <td class="text-right" >'.$presentStockQnt.'</td>
                            <td class="text-right" >'.BangladeshiCurencyFormat($StockRate).'</td>
                            <td class="text-right" >'.BangladeshiCurencyFormat($presentStockAmount).'</td>
                            
                        </tr>';

            $sl++;
        }



        $stockRowHtml .='
        
        '.$projectHeadTableHtml.'

        <div class="col-6"> 
            <div class="row"> 
                <div class="col-12"> 
                    <table class="table table-bordered table-hover table-fixed table-sm">
                    
                        <thead>
                        <tr>
                            <th class="text-center" colspan="6" scope="col"><h5> Total Stock</h5></th>
                            
                        </tr>
                        </thead>
                        
                        <thead>
                        <tr>
                            <th scope="col">Sl.No</th>
                            <th scope="col">Date</th>
                            <th  class="text-left"  scope="col">Head Of Account</th>
                 
                            <th class="text-right" scope="col">Qnt</th>
                            <th class="text-right" scope="col">Rate</th>
                            <th class="text-right" scope="col">Amount</th>
                            
                        </tr>
                        </thead>
                        
                        <tbody>
                        
                        '.$stockTrHtml.'
                        
                        </tbody>
                        
                        <thead>
                        <tr>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            
                        </tr>
                        </thead>
                        
                        <thead>
                        <tr>
                            <th class="text-right" colspan="5" scope="col" >Total =</th>
                            <th class="text-right"  scope="col" >' . BangladeshiCurencyFormat($totalValue) . '</th>
                            
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>  
        
        
        
        <div class="col-6"> 
        
            <div class="row"> 
                <div class="col-12"> 
                    <table class="table table-bordered table-hover table-fixed table-sm">
                    
                        <thead>
                        <tr>
                            <th class="text-center" colspan="6" scope="col"><h5> Total Used Stock</h5></th>
                            
                        </tr>
                        </thead>
                        
                        <thead>
                        <tr>
                            <th scope="col">Sl.No</th>
                            <th scope="col">Date</th>
                            <th  class="text-left"  scope="col">Head Of Account</th>
                 
                            <th class="text-right" scope="col">Qnt</th>
                            <th class="text-right" scope="col">Rate</th>
                            <th class="text-right" scope="col">Amount</th>
                            
                        </tr>
                        </thead>
                        
                        
                        <tbody>
                        
                        '.$usedStockTrHtml.'
                        
                        </tbody>
                        
                        <thead>
                        <tr>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            
                        </tr>
                        </thead>
                        
                        <thead>
                        <tr>
                            <th class="text-right" colspan="5" scope="col" >Total =</th>
                            <th class="text-right"  scope="col" >' . BangladeshiCurencyFormat($usedStockValue) . '</th>
                            
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
            
        </div>  
            
        
<!--   Present Stock  -->
        <div class="col-3"></div>
        <div class="col-6"> 
        
            <div class="row"> 
                <div class="col-12"> 
                    <table class="table table-bordered table-hover table-fixed table-sm">
                    
                        <thead>
                        <tr>
                            <th class="text-center" colspan="6" scope="col"><h5>Present Stock</h5></th>
                            
                        </tr>
                        </thead>
                        
                        <thead>
                        <tr>
                            <th scope="col">Sl.No</th>
                            <th scope="col">Date</th>
                            <th  class="text-left"  scope="col">Head Of Account</th>
                 
                            <th class="text-right" scope="col">Qnt</th>
                            <th class="text-right" scope="col">Rate</th>
                            <th class="text-right" scope="col">Amount</th>
                            
                        </tr>
                        </thead>
                        
                        
                        <tbody>
                        
                        
                        '.$PresentStockTrHtml.'
                        
                        </tbody>
                        
                        <thead>
                        <tr>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            
                        </tr>
                        </thead>
                        
                        <thead>
                        <tr>
                            <th class="text-right" colspan="5" scope="col" >Total =</th>
                            <th class="text-right"  scope="col" >' . BangladeshiCurencyFormat($TotalPresentStockAmount) . '</th>
                            
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
            
        </div>
        
        <div class="col-3"></div>
            
            
            
            ';


    }

    $PresentStock=$totalStockValue - $totalUsedStockValue;


    $stockUsedStockHtml ='

    <div class="row">
         
        '.$stockRowHtml.'
        
    </div>';




} elseif (empty($_POST["CategoryID"]) and !empty($_POST["FromDate"]) and !empty($_POST["ToDate"])  and empty($_POST["HeadOfAccountID"]) ) {
//    All Project Date ways

    $FromDate = $_POST["FromDate"];
    $ToDate = " To ".$_POST["ToDate"];


    $projects = SQL_Select("Category");

//    Stock
    $projectHeadTableHtml="";
    $stockRowHtml="";

    $totalStockValue=0;
    $totalUsedStockValue=0;
    foreach ($projects as $project) {
        $stocks= SQL_Select("stock where ProjectID={$project["CategoryID"]}  and StockIsActive=1   and  Date BETWEEN '{$_REQUEST["FromDate"]}' AND  '{$_REQUEST["ToDate"]}' ");

        if (empty($stocks)) continue;


        $projectHeadTableHtml ='
            <div class="col-12">
                <table class="table table-bordered table-hover table-fixed table-sm">
                        <thead>
                        
                        <tr>
                            <th class="text-center" colspan="6" scope="col"><h4>' . $stocks[0]["ProjectName"] . '</h4></th>
                            <th class="text-center" colspan="6" scope="col"><h4>' . $FromDate . "" . $ToDate . '</h4></th>
                            
                        </tr>
                        </thead>
                        
                </table>
            </div>
        ';


        $stockTrHtml="";
        $sl=1;
        $totalValue=0;
        foreach ($stocks as $stock){

            $totalValue +=$stock["Value"];
            $totalStockValue +=$stock["Value"];
            $stockTrHtml .='<tr>
                            <th style="width: 10px;" class="text-center" scope="row">'.$sl.'</th>
                            <td class="text-left" >'.$stock["Date"].'</td>
                            <td class="text-left" >'.$stock["HeadOfAccountName"].'</td>
                            <td class="text-right" >'.$stock["Qty"].'</td>
                            <td class="text-right" >'.$stock["Rate"].'</td>
                            <td class="text-right" >'.BangladeshiCurencyFormat($stock["Value"]).'</td>
                            
                        </tr>';
            $sl++;


        }

        $UsedStocks= SQL_Select("usedstock where ProjectID={$project["CategoryID"]}  and UsedStockIsActive=1 and  Date BETWEEN '{$_REQUEST["FromDate"]}' AND  '{$_REQUEST["ToDate"]}' ");

        $usedStockTrHtml="";
        $sl=1;
        $usedStockValue=0;
        foreach ($UsedStocks as $UsedStock){

            $usedStockValue +=$UsedStock["Value"];

            $totalUsedStockValue +=$UsedStock["Value"];

            $usedStockTrHtml .='<tr>
                            <th style="width: 10px;" class="text-center" scope="row">'.$sl.'</th>
                            <td class="text-left" >'.$UsedStock["Date"].'</td>
                            <td class="text-left" >'.$UsedStock["HeadOfAccountName"].'</td>
                            <td class="text-right" >'.$UsedStock["Qty"].'</td>
                            <td class="text-right" >'.$UsedStock["Rate"].'</td>
                            <td class="text-right" >'.BangladeshiCurencyFormat($UsedStock["Value"]).'</td>
                            
                        </tr>';

            $sl++;
        }




//      Present Stock Html

        $PresentStockTrHtml="";
        $sl=1;
        $usedStockValue=0;
        $TotalPresentStockAmount=0;
        foreach ($stocks as $stock){

            $HeadOfAccountID=$stock["HeadOfAccountID"];
            $HeadOfAccountName=$stock["HeadOfAccountName"];

            $StockQty=$stock["Qty"];
            $StockRate=$stock["Rate"];
            $StockAmount=$stock["Value"];

            $UsedStocks= SQL_Select("usedstock where ProjectID={$project["CategoryID"]} and HeadOfAccountID={$HeadOfAccountID}  and UsedStockIsActive=1  and  Date BETWEEN '{$_REQUEST["FromDate"]}' AND  '{$_REQUEST["ToDate"]}'  ");

            $usedStockQnt=$UsedStocks[0]["Qty"];
            $usedStockRate=$UsedStocks[0]["Rate"];
            $usedStockValue=$UsedStocks[0]["Value"];


            $presentStockQnt=$StockQty-$usedStockQnt;

            if ($presentStockQnt==0){
                $StockRate=0;
            }

            $presentStockAmount=$StockAmount-$usedStockValue;

            $TotalPresentStockAmount +=$presentStockAmount;


            $PresentStockTrHtml .='<tr>
                            <th style="width: 10px;" class="text-center" scope="row">'.$sl.'</th>
                            <td class="text-left" >'.$UsedStock["Date"].'</td>
                            <td class="text-left" >'.$UsedStock["HeadOfAccountName"].'</td>
                            <td class="text-right" >'.$presentStockQnt.'</td>
                            <td class="text-right" >'.BangladeshiCurencyFormat($StockRate).'</td>
                            <td class="text-right" >'.BangladeshiCurencyFormat($presentStockAmount).'</td>
                            
                        </tr>';

            $sl++;
        }



        $stockRowHtml .='
        
        '.$projectHeadTableHtml.'

        <div class="col-6"> 
            <div class="row"> 
                <div class="col-12"> 
                    <table class="table table-bordered table-hover table-fixed table-sm">
                    
                        <thead>
                        <tr>
                            <th class="text-center" colspan="6" scope="col"><h5> Total Stock</h5></th>
                            
                        </tr>
                        </thead>
                        
                        <thead>
                        <tr>
                            <th scope="col">Sl.No</th>
                            <th scope="col">Date</th>
                            <th  class="text-left"  scope="col">Head Of Account</th>
                 
                            <th class="text-right" scope="col">QTY</th>
                            <th class="text-right" scope="col">Rate</th>
                            <th class="text-right" scope="col">Amount</th>
                            
                        </tr>
                        </thead>
                        
                        <tbody>
                        
                        '.$stockTrHtml.'
                        
                        </tbody>
                        
                        <thead>
                        <tr>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            
                        </tr>
                        </thead>
                        
                        <thead>
                        <tr>
                            <th class="text-right" colspan="5" scope="col" >Total =</th>
                            <th class="text-right"  scope="col" >' . BangladeshiCurencyFormat($totalValue) . '</th>
                            
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>  
        
        
        
        <div class="col-6"> 
        
            <div class="row"> 
                <div class="col-12"> 
                    <table class="table table-bordered table-hover table-fixed table-sm">
                    
                        <thead>
                        <tr>
                            <th class="text-center" colspan="6" scope="col"><h5> Total Used Stock</h5></th>
                            
                        </tr>
                        </thead>
                        
                        <thead>
                        <tr>
                            <th scope="col">Sl.No</th>
                            <th scope="col">Date</th>
                            <th  class="text-left"  scope="col">Head Of Account</th>
                 
                            <th class="text-right" scope="col">QTY</th>
                            <th class="text-right" scope="col">Rate</th>
                            <th class="text-right" scope="col">Amount</th>
                            
                        </tr>
                        </thead>
                        
                        
                        <tbody>
                        
                        '.$usedStockTrHtml.'
                        
                        </tbody>
                        
                        <thead>
                        <tr>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            
                        </tr>
                        </thead>
                        
                        <thead>
                        <tr>
                            <th class="text-right" colspan="5" scope="col" >Total =</th>
                            <th class="text-right"  scope="col" >' . BangladeshiCurencyFormat($usedStockValue) . '</th>
                            
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
            
        </div>  
            
        
           
<!--   Present Stock  -->
        <div class="col-3"></div>
        <div class="col-6"> 
        
            <div class="row"> 
                <div class="col-12"> 
                    <table class="table table-bordered table-hover table-fixed table-sm">
                    
                        <thead>
                        <tr>
                            <th class="text-center" colspan="6" scope="col"><h5>Present Stock</h5></th>
                            
                        </tr>
                        </thead>
                        
                        <thead>
                        <tr>
                            <th scope="col">Sl.No</th>
                            <th scope="col">Date</th>
                            <th  class="text-left"  scope="col">Head Of Account</th>
                 
                            <th class="text-right" scope="col">QTY</th>
                            <th class="text-right" scope="col">Rate</th>
                            <th class="text-right" scope="col">Amount</th>
                            
                        </tr>
                        </thead>
                        
                        
                        <tbody>
                        
                        
                        '.$PresentStockTrHtml.'
                        
                        </tbody>
                        
                        <thead>
                        <tr>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            
                        </tr>
                        </thead>
                        
                        <thead>
                        <tr>
                            <th class="text-right" colspan="5" scope="col" >Total =</th>
                            <th class="text-right"  scope="col" >' . BangladeshiCurencyFormat($TotalPresentStockAmount) . '</th>
                            
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
            
        </div>
        
        <div class="col-3"></div>
            
            
          
            
            ';


    }

    $PresentStock=$totalStockValue - $totalUsedStockValue;


    $stockUsedStockHtml ='

    <div class="row">
         
        '.$stockRowHtml.'
        
    </div>';



}elseif (empty($_POST["CategoryID"]) and empty($_POST["FromDate"]) and empty($_POST["ToDate"]) and !empty($_POST["HeadOfAccountID"])){
//  Only Expense Head

    $projects = SQL_Select("Category");

//    Stock
    $projectHeadTableHtml="";
    $stockRowHtml="";

    $totalStockValue=0;
    $totalUsedStockValue=0;
    foreach ($projects as $project) {
        $stocks= SQL_Select("stock where ProjectID={$project["CategoryID"]} and StockIsActive=1 and HeadOfAccountID={$_POST["HeadOfAccountID"]}");

        if (empty($stocks)) continue;


        $projectHeadTableHtml ='
            <div class="col-12">
                <table class="table table-bordered table-hover table-fixed table-sm">
                        <thead>
                        
                        <tr>
                            <th class="text-center" colspan="6" scope="col"><h4>' . $stocks[0]["ProjectName"] . '</h4></th>
                            <th class="text-center" colspan="6" scope="col"><h4>' . $FromDate . "-" . $ToDate . '</h4></th>
                            
                        </tr>
                        </thead>
                        
                </table>
            </div>
        ';


        $stockTrHtml="";
        $sl=1;
        $totalValue=0;
        foreach ($stocks as $stock){

            $totalValue +=$stock["Value"];
            $totalStockValue +=$stock["Value"];
            $stockTrHtml .='<tr>
                            <th style="width: 10px;" class="text-center" scope="row">'.$sl.'</th>
                            <td class="text-left" >'.$stock["Date"].'</td>
                            <td class="text-left" >'.$stock["HeadOfAccountName"].'</td>
                            <td class="text-right" >'.$stock["Qty"].'</td>
                            <td class="text-right" >'.$stock["Rate"].'</td>
                            <td class="text-right" >'.BangladeshiCurencyFormat($stock["Value"]).'</td>
                            
                        </tr>';
            $sl++;


        }

        $UsedStocks= SQL_Select("usedstock where ProjectID={$project["CategoryID"]}  and UsedStockIsActive=1  and HeadOfAccountID={$_POST["HeadOfAccountID"]}");

        $usedStockTrHtml="";
        $sl=1;
        $usedStockValue=0;
        foreach ($UsedStocks as $UsedStock){

            $usedStockValue +=$UsedStock["Value"];

            $totalUsedStockValue +=$UsedStock["Value"];

            $usedStockTrHtml .='<tr>
                            <th style="width: 10px;" class="text-center" scope="row">'.$sl.'</th>
                            <td class="text-left" >'.$UsedStock["Date"].'</td>
                            <td class="text-left" >'.$UsedStock["HeadOfAccountName"].'</td>
                            <td class="text-right" >'.$UsedStock["Qty"].'</td>
                            <td class="text-right" >'.$UsedStock["Rate"].'</td>
                            <td class="text-right" >'.BangladeshiCurencyFormat($UsedStock["Value"]).'</td>
                            
                        </tr>';

            $sl++;
        }


//      Present Stock Html
        $PresentStockTrHtml="";
        $sl=1;
        $usedStockValue=0;
        $TotalPresentStockAmount=0;
        foreach ($stocks as $stock){

            $HeadOfAccountID=$stock["HeadOfAccountID"];
            $HeadOfAccountName=$stock["HeadOfAccountName"];

            $StockQty=$stock["Qty"];
            $StockRate=$stock["Rate"];
            $StockAmount=$stock["Value"];

            $UsedStocks= SQL_Select("usedstock where ProjectID={$project["CategoryID"]} and HeadOfAccountID={$HeadOfAccountID}  and UsedStockIsActive=1 ");

            $usedStockQnt=$UsedStocks[0]["Qty"];
            $usedStockRate=$UsedStocks[0]["Rate"];
            $usedStockValue=$UsedStocks[0]["Value"];

            $presentStockQnt=$StockQty-$usedStockQnt;

            if ($presentStockQnt==0){
                $StockRate=0;
            }

            $presentStockAmount=$StockAmount-$usedStockValue;

            $TotalPresentStockAmount +=$presentStockAmount;


            $PresentStockTrHtml .='<tr>
                            <th style="width: 10px;" class="text-center" scope="row">'.$sl.'</th>
                            <td class="text-left" >'.$UsedStock["Date"].'</td>
                            <td class="text-left" >'.$UsedStock["HeadOfAccountName"].'</td>
                            <td class="text-right" >'.$presentStockQnt.'</td>
                            <td class="text-right" >'.BangladeshiCurencyFormat($StockRate).'</td>
                            <td class="text-right" >'.BangladeshiCurencyFormat($presentStockAmount).'</td>
                            
                        </tr>';

            $sl++;
        }


        $stockRowHtml .='
        
        '.$projectHeadTableHtml.'

        <div class="col-6"> 
            <div class="row"> 
                <div class="col-12"> 
                    <table class="table table-bordered table-hover table-fixed table-sm">
                    
                        <thead>
                        <tr>
                            <th class="text-center" colspan="6" scope="col"><h5> Total Stock</h5></th>
                            
                        </tr>
                        </thead>
                        
                        <thead>
                        <tr>
                            <th scope="col">Sl.No</th>
                            <th scope="col">Date</th>
                            <th  class="text-left"  scope="col">Head Of Account</th>
                 
                            <th class="text-right" scope="col">Qnt</th>
                            <th class="text-right" scope="col">Rate</th>
                            <th class="text-right" scope="col">Amount</th>
                            
                        </tr>
                        </thead>
                        
                        <tbody>
                        
                        '.$stockTrHtml.'
                        
                        </tbody>
                        
                        <thead>
                        <tr>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            
                        </tr>
                        </thead>
                        
                        <thead>
                        <tr>
                            <th class="text-right" colspan="5" scope="col" >Total =</th>
                            <th class="text-right"  scope="col" >' . BangladeshiCurencyFormat($totalValue) . '</th>
                            
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>  
        
        
        
        <div class="col-6"> 
        
            <div class="row"> 
                <div class="col-12"> 
                    <table class="table table-bordered table-hover table-fixed table-sm">
                    
                        <thead>
                        <tr>
                            <th class="text-center" colspan="6" scope="col"><h5> Total Used Stock</h5></th>
                            
                        </tr>
                        </thead>
                        
                        <thead>
                        <tr>
                            <th scope="col">Sl.No</th>
                            <th scope="col">Date</th>
                            <th  class="text-left"  scope="col">Head Of Account</th>
                 
                            <th class="text-right" scope="col">Qnt</th>
                            <th class="text-right" scope="col">Rate</th>
                            <th class="text-right" scope="col">Amount</th>
                            
                        </tr>
                        </thead>
                        
                        
                        <tbody>
                        
                        '.$usedStockTrHtml.'
                        
                        </tbody>
                        
                        <thead>
                        <tr>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            
                        </tr>
                        </thead>
                        
                        <thead>
                        <tr>
                            <th class="text-right" colspan="5" scope="col" >Total =</th>
                            <th class="text-right"  scope="col" >' . BangladeshiCurencyFormat($usedStockValue) . '</th>
                            
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
            
        </div>  
          
             
<!--   Present Stock  -->
        <div class="col-3"></div>
        <div class="col-6"> 
        
            <div class="row"> 
                <div class="col-12"> 
                    <table class="table table-bordered table-hover table-fixed table-sm">
                    
                        <thead>
                        <tr>
                            <th class="text-center" colspan="6" scope="col"><h5>Present Stock</h5></th>
                            
                        </tr>
                        </thead>
                        
                        <thead>
                        <tr>
                            <th scope="col">Sl.No</th>
                            <th scope="col">Date</th>
                            <th  class="text-left"  scope="col">Head Of Account</th>
                 
                            <th class="text-right" scope="col">Qnt</th>
                            <th class="text-right" scope="col">Rate</th>
                            <th class="text-right" scope="col">Amount</th>
                            
                        </tr>
                        </thead>
                        
                        
                        <tbody>
                        
                        
                        '.$PresentStockTrHtml.'
                        
                        </tbody>
                        
                        <thead>
                        <tr>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            
                        </tr>
                        </thead>
                        
                        <thead>
                        <tr>
                            <th class="text-right" colspan="5" scope="col" >Total =</th>
                            <th class="text-right"  scope="col" >' . BangladeshiCurencyFormat($TotalPresentStockAmount) . '</th>
                            
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
            
        </div>
        
        <div class="col-3"></div>
            
              
            
            
            
            ';


    }

    $PresentStock=$totalStockValue - $totalUsedStockValue;


    $stockUsedStockHtml ='

    <div class="row">
         
        '.$stockRowHtml.'
        
    </div>';

}elseif (!empty($_POST["CategoryID"]) and empty($_POST["FromDate"]) and empty($_POST["ToDate"]) and !empty($_POST["HeadOfAccountID"])) {

//    Only Project and Head of Account

    $projects = SQL_Select("Category where CategoryID={$_POST["CategoryID"]}");

//    Stock
    $projectHeadTableHtml="";
    $stockRowHtml="";

    $totalStockValue=0;
    $totalUsedStockValue=0;
    foreach ($projects as $project) {
        $stocks= SQL_Select("stock where ProjectID={$project["CategoryID"]} and StockIsActive=1 and HeadOfAccountID={$_POST["HeadOfAccountID"]}");

        if (empty($stocks)) continue;


        $projectHeadTableHtml ='
            <div class="col-12">
                <table class="table table-bordered table-hover table-fixed table-sm">
                        <thead>
                        
                        <tr>
                            <th class="text-center" colspan="6" scope="col"><h4>' . $stocks[0]["ProjectName"] . '</h4></th>
                            <th class="text-center" colspan="6" scope="col"><h4>' . $FromDate . "-" . $ToDate . '</h4></th>
                            
                        </tr>
                        </thead>
                        
                </table>
            </div>
        ';


        $stockTrHtml="";
        $sl=1;
        $totalValue=0;
        foreach ($stocks as $stock){

            $totalValue +=$stock["Value"];
            $totalStockValue +=$stock["Value"];
            $stockTrHtml .='<tr>
                            <th style="width: 10px;" class="text-center" scope="row">'.$sl.'</th>
                            <td class="text-left" >'.$stock["Date"].'</td>
                            <td class="text-left" >'.$stock["HeadOfAccountName"].'</td>
                            <td class="text-right" >'.$stock["Qty"].'</td>
                            <td class="text-right" >'.$stock["Rate"].'</td>
                            <td class="text-right" >'.BangladeshiCurencyFormat($stock["Value"]).'</td>
                            
                        </tr>';
            $sl++;


        }

        $UsedStocks= SQL_Select("usedstock where ProjectID={$project["CategoryID"]}  and UsedStockIsActive=1  and HeadOfAccountID={$_POST["HeadOfAccountID"]}");

        $usedStockTrHtml="";
        $sl=1;
        $usedStockValue=0;
        foreach ($UsedStocks as $UsedStock){

            $usedStockValue +=$UsedStock["Value"];

            $totalUsedStockValue +=$UsedStock["Value"];

            $usedStockTrHtml .='<tr>
                            <th style="width: 10px;" class="text-center" scope="row">'.$sl.'</th>
                            <td class="text-left" >'.$UsedStock["Date"].'</td>
                            <td class="text-left" >'.$UsedStock["HeadOfAccountName"].'</td>
                            <td class="text-right" >'.$UsedStock["Qty"].'</td>
                            <td class="text-right" >'.$UsedStock["Rate"].'</td>
                            <td class="text-right" >'.BangladeshiCurencyFormat($UsedStock["Value"]).'</td>
                            
                        </tr>';

            $sl++;
        }



//      Present Stock Html
        $PresentStockTrHtml="";
        $sl=1;
        $usedStockValue=0;
        $TotalPresentStockAmount=0;
        foreach ($stocks as $stock){

            $HeadOfAccountID=$stock["HeadOfAccountID"];
            $HeadOfAccountName=$stock["HeadOfAccountName"];

            $StockQty=$stock["Qty"];
            $StockRate=$stock["Rate"];
            $StockAmount=$stock["Value"];

            $UsedStocks= SQL_Select("usedstock where ProjectID={$project["CategoryID"]} and HeadOfAccountID={$HeadOfAccountID}  and UsedStockIsActive=1 ");

            $usedStockQnt=$UsedStocks[0]["Qty"];
            $usedStockRate=$UsedStocks[0]["Rate"];
            $usedStockValue=$UsedStocks[0]["Value"];

            $presentStockQnt=$StockQty-$usedStockQnt;

            if ($presentStockQnt==0){
                $StockRate=0;
            }

            $presentStockAmount=$StockAmount-$usedStockValue;

            $TotalPresentStockAmount +=$presentStockAmount;


            $PresentStockTrHtml .='<tr>
                            <th style="width: 10px;" class="text-center" scope="row">'.$sl.'</th>
                            <td class="text-left" >'.$UsedStock["Date"].'</td>
                            <td class="text-left" >'.$UsedStock["HeadOfAccountName"].'</td>
                            <td class="text-right" >'.$presentStockQnt.'</td>
                            <td class="text-right" >'.BangladeshiCurencyFormat($StockRate).'</td>
                            <td class="text-right" >'.BangladeshiCurencyFormat($presentStockAmount).'</td>
                            
                        </tr>';

            $sl++;
        }





        $stockRowHtml .='
        
        '.$projectHeadTableHtml.'

        <div class="col-6"> 
            <div class="row"> 
                <div class="col-12"> 
                    <table class="table table-bordered table-hover table-fixed table-sm">
                    
                        <thead>
                        <tr>
                            <th class="text-center" colspan="6" scope="col"><h5> Total Stock</h5></th>
                            
                        </tr>
                        </thead>
                        
                        <thead>
                        <tr>
                            <th scope="col">Sl.No</th>
                            <th scope="col">Date</th>
                            <th  class="text-left"  scope="col">Head Of Account</th>
                 
                            <th class="text-right" scope="col">Qnt</th>
                            <th class="text-right" scope="col">Rate</th>
                            <th class="text-right" scope="col">Amount</th>
                            
                        </tr>
                        </thead>
                        
                        <tbody>
                        
                        '.$stockTrHtml.'
                        
                        </tbody>
                        
                        <thead>
                        <tr>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            
                        </tr>
                        </thead>
                        
                        <thead>
                        <tr>
                            <th class="text-right" colspan="5" scope="col" >Total =</th>
                            <th class="text-right"  scope="col" >' . BangladeshiCurencyFormat($totalValue) . '</th>
                            
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>  
        
        
        
        <div class="col-6"> 
        
            <div class="row"> 
                <div class="col-12"> 
                    <table class="table table-bordered table-hover table-fixed table-sm">
                    
                        <thead>
                        <tr>
                            <th class="text-center" colspan="6" scope="col"><h5> Total Used Stock</h5></th>
                            
                        </tr>
                        </thead>
                        
                        <thead>
                        <tr>
                            <th scope="col">Sl.No</th>
                            <th scope="col">Date</th>
                            <th  class="text-left"  scope="col">Head Of Account</th>
                 
                            <th class="text-right" scope="col">Qnt</th>
                            <th class="text-right" scope="col">Rate</th>
                            <th class="text-right" scope="col">Amount</th>
                            
                        </tr>
                        </thead>
                        
                        
                        <tbody>
                        
                        '.$usedStockTrHtml.'
                        
                        </tbody>
                        
                        <thead>
                        <tr>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            
                        </tr>
                        </thead>
                        
                        <thead>
                        <tr>
                            <th class="text-right" colspan="5" scope="col" >Total =</th>
                            <th class="text-right"  scope="col" >' . BangladeshiCurencyFormat($usedStockValue) . '</th>
                            
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
            
        </div>  
        
           
<!--   Present Stock  -->
        <div class="col-3"></div>
        <div class="col-6"> 
        
            <div class="row"> 
                <div class="col-12"> 
                    <table class="table table-bordered table-hover table-fixed table-sm">
                    
                        <thead>
                        <tr>
                            <th class="text-center" colspan="6" scope="col"><h5>Present Stock</h5></th>
                            
                        </tr>
                        </thead>
                        
                        <thead>
                        <tr>
                            <th scope="col">Sl.No</th>
                            <th scope="col">Date</th>
                            <th  class="text-left"  scope="col">Head Of Account</th>
                 
                            <th class="text-right" scope="col">Qnt</th>
                            <th class="text-right" scope="col">Rate</th>
                            <th class="text-right" scope="col">Amount</th>
                            
                        </tr>
                        </thead>
                        
                        
                        <tbody>
                        
                        
                        '.$PresentStockTrHtml.'
                        
                        </tbody>
                        
                        <thead>
                        <tr>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            
                        </tr>
                        </thead>
                        
                        <thead>
                        <tr>
                            <th class="text-right" colspan="5" scope="col" >Total =</th>
                            <th class="text-right"  scope="col" >' . BangladeshiCurencyFormat($TotalPresentStockAmount) . '</th>
                            
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
            
        </div>
        
        <div class="col-3"></div>
            
            
            ';


    }

    $PresentStock=$totalStockValue - $totalUsedStockValue;


    $stockUsedStockHtml ='

    <div class="row">
         
        '.$stockRowHtml.'
        
    </div>';


    
}elseif (!empty($_POST["CategoryID"]) and !empty($_POST["FromDate"]) and !empty($_POST["ToDate"]) and !empty($_POST["HeadOfAccountID"])) {
//    One Category , one Expense head and Data

    $FromDate = $_POST["FromDate"];
    $ToDate = " To ".$_POST["ToDate"];

    $projects = SQL_Select("Category where CategoryID={$_POST["CategoryID"]}");

//    Stock
    $projectHeadTableHtml="";
    $stockRowHtml="";

    $totalStockValue=0;
    $totalUsedStockValue=0;
    foreach ($projects as $project) {
        $stocks= SQL_Select("stock where ProjectID={$project["CategoryID"]} and StockIsActive=1 and HeadOfAccountID={$_POST["HeadOfAccountID"]} and  Date BETWEEN '{$_REQUEST["FromDate"]}' AND  '{$_REQUEST["ToDate"]}' ");

        if (empty($stocks)) continue;


        $projectHeadTableHtml ='
            <div class="col-12">
                <table class="table table-bordered table-hover table-fixed table-sm">
                        <thead>
                        
                        <tr>
                            <th class="text-center" colspan="6" scope="col"><h4>' . $stocks[0]["ProjectName"] . '</h4></th>
                            <th class="text-center" colspan="6" scope="col"><h4>' . $FromDate . "-" . $ToDate . '</h4></th>
                            
                        </tr>
                        </thead>
                        
                </table>
            </div>
        ';


        $stockTrHtml="";
        $sl=1;
        $totalValue=0;
        foreach ($stocks as $stock){

            $totalValue +=$stock["Value"];
            $totalStockValue +=$stock["Value"];
            $stockTrHtml .='<tr>
                            <th style="width: 10px;" class="text-center" scope="row">'.$sl.'</th>
                            <td class="text-left" >'.$stock["Date"].'</td>
                            <td class="text-left" >'.$stock["HeadOfAccountName"].'</td>
                            <td class="text-right" >'.$stock["Qty"].'</td>
                            <td class="text-right" >'.$stock["Rate"].'</td>
                            <td class="text-right" >'.BangladeshiCurencyFormat($stock["Value"]).'</td>
                            
                        </tr>';
            $sl++;


        }

        $UsedStocks= SQL_Select("usedstock where ProjectID={$project["CategoryID"]}  and UsedStockIsActive=1  and HeadOfAccountID={$_POST["HeadOfAccountID"]} and  Date BETWEEN '{$_REQUEST["FromDate"]}' AND  '{$_REQUEST["ToDate"]}'");

        $usedStockTrHtml="";
        $sl=1;
        $usedStockValue=0;
        foreach ($UsedStocks as $UsedStock){

            $usedStockValue +=$UsedStock["Value"];

            $totalUsedStockValue +=$UsedStock["Value"];

            $usedStockTrHtml .='<tr>
                            <th style="width: 10px;" class="text-center" scope="row">'.$sl.'</th>
                            <td class="text-left" >'.$UsedStock["Date"].'</td>
                            <td class="text-left" >'.$UsedStock["HeadOfAccountName"].'</td>
                            <td class="text-right" >'.$UsedStock["Qty"].'</td>
                            <td class="text-right" >'.$UsedStock["Rate"].'</td>
                            <td class="text-right" >'.BangladeshiCurencyFormat($UsedStock["Value"]).'</td>
                            
                        </tr>';

            $sl++;
        }



//      Present Stock Html
        $PresentStockTrHtml="";
        $sl=1;
        $usedStockValue=0;
        $TotalPresentStockAmount=0;
        foreach ($stocks as $stock){

            $HeadOfAccountID=$stock["HeadOfAccountID"];
            $HeadOfAccountName=$stock["HeadOfAccountName"];

            $StockQty=$stock["Qty"];
            $StockRate=$stock["Rate"];
            $StockAmount=$stock["Value"];

            $UsedStocks= SQL_Select("usedstock where ProjectID={$project["CategoryID"]} and HeadOfAccountID={$HeadOfAccountID}  and UsedStockIsActive=1  and  Date BETWEEN '{$_REQUEST["FromDate"]}' AND  '{$_REQUEST["ToDate"]}'  ");

            $usedStockQnt=$UsedStocks[0]["Qty"];
            $usedStockRate=$UsedStocks[0]["Rate"];
            $usedStockValue=$UsedStocks[0]["Value"];


            $presentStockQnt=$StockQty-$usedStockQnt;

            if ($presentStockQnt==0){
                $StockRate=0;
            }

            $presentStockAmount=$StockAmount-$usedStockValue;

            $TotalPresentStockAmount +=$presentStockAmount;


            $PresentStockTrHtml .='<tr>
                            <th style="width: 10px;" class="text-center" scope="row">'.$sl.'</th>
                            <td class="text-left" >'.$UsedStock["Date"].'</td>
                            <td class="text-left" >'.$UsedStock["HeadOfAccountName"].'</td>
                            <td class="text-right" >'.$presentStockQnt.'</td>
                            <td class="text-right" >'.BangladeshiCurencyFormat($StockRate).'</td>
                            <td class="text-right" >'.BangladeshiCurencyFormat($presentStockAmount).'</td>
                            
                        </tr>';

            $sl++;
        }



        $stockRowHtml .='
        
        '.$projectHeadTableHtml.'

        <div class="col-6"> 
            <div class="row"> 
                <div class="col-12"> 
                    <table class="table table-bordered table-hover table-fixed table-sm">
                    
                        <thead>
                        <tr>
                            <th class="text-center" colspan="6" scope="col"><h5> Total Stock</h5></th>
                            
                        </tr>
                        </thead>
                        
                        <thead>
                        <tr>
                            <th scope="col">Sl.No</th>
                            <th scope="col">Date</th>
                            <th  class="text-left"  scope="col">Head Of Account</th>
                 
                            <th class="text-right" scope="col">Qnt</th>
                            <th class="text-right" scope="col">Rate</th>
                            <th class="text-right" scope="col">Amount</th>
                            
                        </tr>
                        </thead>
                        
                        <tbody>
                        
                        '.$stockTrHtml.'
                        
                        </tbody>
                        
                        <thead>
                        <tr>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            
                        </tr>
                        </thead>
                        
                        <thead>
                        <tr>
                            <th class="text-right" colspan="5" scope="col" >Total =</th>
                            <th class="text-right"  scope="col" >' . BangladeshiCurencyFormat($totalValue) . '</th>
                            
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>  
        
        
        
        <div class="col-6"> 
        
            <div class="row"> 
                <div class="col-12"> 
                    <table class="table table-bordered table-hover table-fixed table-sm">
                    
                        <thead>
                        <tr>
                            <th class="text-center" colspan="6" scope="col"><h5> Total Used Stock</h5></th>
                            
                        </tr>
                        </thead>
                        
                        <thead>
                        <tr>
                            <th scope="col">Sl.No</th>
                            <th scope="col">Date</th>
                            <th  class="text-left"  scope="col">Head Of Account</th>
                 
                            <th class="text-right" scope="col">Qnt</th>
                            <th class="text-right" scope="col">Rate</th>
                            <th class="text-right" scope="col">Amount</th>
                            
                        </tr>
                        </thead>
                        
                        
                        <tbody>
                        
                        '.$usedStockTrHtml.'
                        
                        </tbody>
                        
                        <thead>
                        <tr>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            
                        </tr>
                        </thead>
                        
                        <thead>
                        <tr>
                            <th class="text-right" colspan="5" scope="col" >Total =</th>
                            <th class="text-right"  scope="col" >' . BangladeshiCurencyFormat($usedStockValue) . '</th>
                            
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
            
        </div>  
            
                
<!--   Present Stock  -->
        <div class="col-3"></div>
        <div class="col-6"> 
        
            <div class="row"> 
                <div class="col-12"> 
                    <table class="table table-bordered table-hover table-fixed table-sm">
                    
                        <thead>
                        <tr>
                            <th class="text-center" colspan="6" scope="col"><h5>Present Stock</h5></th>
                            
                        </tr>
                        </thead>
                        
                        <thead>
                        <tr>
                            <th scope="col">Sl.No</th>
                            <th scope="col">Date</th>
                            <th  class="text-left"  scope="col">Head Of Account</th>
                 
                            <th class="text-right" scope="col">Qnt</th>
                            <th class="text-right" scope="col">Rate</th>
                            <th class="text-right" scope="col">Amount</th>
                            
                        </tr>
                        </thead>
                        
                        
                        <tbody>
                        
                        
                        '.$PresentStockTrHtml.'
                        
                        </tbody>
                        
                        <thead>
                        <tr>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            <th style="height: 40px;" scope="col"></th>
                            
                        </tr>
                        </thead>
                        
                        <thead>
                        <tr>
                            <th class="text-right" colspan="5" scope="col" >Total =</th>
                            <th class="text-right"  scope="col" >' . BangladeshiCurencyFormat($TotalPresentStockAmount) . '</th>
                            
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
            
        </div>
        
        <div class="col-3"></div>
            
            
            ';


    }

    $PresentStock=$totalStockValue - $totalUsedStockValue;


    $stockUsedStockHtml ='

    <div class="row">
         
        '.$stockRowHtml.'
        
    </div>';




} else {


    header("location:index.php?Theme=default&Base=Transaction&Script=NotesManage");

}


$MainContent .= '

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Stock Report</title>

    <style>
        .m-b-30{
            margin-bottom: 30px;
        }
        .m-t-30{
            margin-top: 30px;
        }
        
          .table-bordered th, .table-bordered td {
                border: 1px solid rgba(0,0,0,.3) !important;
          }
          
          .company-name{
            border-bottom: 1px solid rgba(0,0,0,.3);
          }

    </style>
</head>
<body>

<div style="width: 95%; margin: auto">
    <p style="font-size: 16px">Printing Date & Time: '.date('F j-y, h:i:sa').'</p>
</div>

<div style="width: 95%; margin: auto">
    <div style="padding: 10px 0px;" class="company-name row">
        <div  class="col-md-2 text-center">
              <img style="width:70px;" src="./upload/' . $Settings["logo"] . '" alt="">
        </div>
        <div  class="col-md-9 text-center">
            <h3 style="font-weight: bold">'.$Settings["CompanyName"].'</h3>
            <p style="font-size: 18px;">'.$Settings["Address"].'</p>
        </div>
    </div>

    <div class="projectName text-center m-b-30 m-t-30">
        <h3 style="font-weight: bold">Stock Report</h3>
    </div>
    
        <table class="table table-bordered table-hover table-fixed table-sm">
                <thead>
                
                <tr>
                    <th class="text-center" colspan="12" scope="col"><h5>Total Stock <span style="font-weight: bold; color: #0051CC;">'.BangladeshiCurencyFormat($totalStockValue).'</span>, Used Stock <span style="font-weight: bold; color: red;">'.BangladeshiCurencyFormat($totalUsedStockValue).'</span>, Present Stock <span style="font-weight: bold; color: green;">'.BangladeshiCurencyFormat($PresentStock).'</span></h5></th>
                   
                </tr>
                </thead>
                
        </table>
            
    
    '.$stockUsedStockHtml.'
    
</div>


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
</body>
</html>


';


?>

