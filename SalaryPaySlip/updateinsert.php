<?php
if(isset($_POST['salary_update'])){
	 $UserID=$_POST['UserID'];
	 $SalaryID=$_POST['SalaryID'];
	 $BasicSalary=$_POST['BasicSalary'];
	 $HouseRent=$_POST['HouseRent'];
	 $TravellingAllow=$_POST['TravellingAllow'];
	 $MedicalAllow=$_POST['MedicalAllow'];
	 $FoodAllow=$_POST['FoodAllow'];
	 $MobileAllow=$_POST['MobileAllow'];
	 $Donation=$_POST['Donation'];
	 $ProvidentFund=$_POST['ProvidentFund'];
	 $SecurityDeposit=$_POST['SecurityDeposit'];
	 $MonthName=$_POST['MonthName'];
	 $YearName=$_POST['YearName'];
	 
	 $Loan=$_POST['Loan'];
	 $Tax=$_POST['Tax'];
	 $LoanPaidCheck=$_POST['LoanPaid'];
	 
	 $MonthYear=$YearName.'-'.$MonthName;
	 
	 $Lhistory=mysql_query("select sum(Loan) as TotalLoan,sum(LoanPaid) as PaidLoan from tblsalary where UserID='$UserID'");
     $ThisLhistory=mysql_fetch_assoc($Lhistory);
      $PLoan=$ThisLhistory['PaidLoan'];
      $TLoan=$ThisLhistory['TotalLoan'];
      $CLoan=$TLoan-$PLoan;
	 
	 if($LoanPaidCheck>$TLoan){
		 header("location:index.php?Theme=default&Base=SalaryPaySlip&Script=update&SalaryID=$SalaryID&EM=Please Entry Loan>=Paid Amt");
	 }else{ 
		 $LoanPaid=$_POST['LoanPaid']; 
	     $ums=mysql_query("update tblsalary set HouseRent='$HouseRent',TravellingAllow='$TravellingAllow',MedicalAllow='$MedicalAllow',FoodAllow='$FoodAllow',MobileAllow='$MobileAllow',Donation='$Donation',Loan='$Loan',Tax='$Tax',LoanPaid='$LoanPaid' where SalaryID='$SalaryID'");
	    if($ums){
		  header("location:index.php?Theme=default&Base=SalaryPaySlip&Script=SalaryHistory&UserId=$UserID&MI=$MonthName&YI=$YearName");
	     }
	  }
	 
	 //$udata=mysql_query("update tblsalary set UserID='$UserID',BasicSalary='$BasicSalary',HouseRent='$HouseRent',TravellingAllow='$TravellingAllow',MedicalAllow='$MedicalAllow',FoodAllow='$FoodAllow',MobileAllow='$MobileAllow',Donation='$Donation',Loan='$Donation',Tax='$Tax',LoanPaid='$LoanPaid',ProvidentFund='$ProvidentFund',SecurityDeposit='$SecurityDeposit',MonthName='$MonthName',YearName='$YearName',MonthYear='$MonthYear' where SalaryID='$SalaryID');	
	// $udata=mysql_query("update tblsalary set BasicSalary='$BasicSalary',HouseRent='$HouseRent',TravellingAllow='$TravellingAllow',MedicalAllow='$MedicalAllow',FoodAllow='$FoodAllow',MobileAllow='$MobileAllow',Donation='$Donation',Loan='$Donation',Tax='$Tax',LoanPaid='$LoanPaid',ProvidentFund='$ProvidentFund',SecurityDeposit='$SecurityDeposit',MonthName='$MonthName',YearName='$YearName',MonthYear='$MonthYear' where SalaryID='$SalaryID');	
	  
    }