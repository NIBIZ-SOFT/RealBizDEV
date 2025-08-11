<?php 

if(isset($_POST['salary_submit'])){
	 $UserID=$_POST['UserID'];
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

	 
	 $MonthYear=$YearName.'-'.$MonthName;
	 
	 
	 $Lhistory=mysql_query("select sum(Loan) as TotalLoan,sum(LoanPaid) as PaidLoan from tblsalary where UserID='$UserID'");
     $ThisLhistory=mysql_fetch_assoc($Lhistory);
     $PLoan=$ThisLhistory['PaidLoan'];
     $TLoan=$ThisLhistory['TotalLoan'];
     $CLoan=$TLoan-$PLoan;
	 
	 if(!$CLoan>0){
		 echo "Sorry Data Not Send";
	 }else{
		 echo $LoanPaid=$_POST['LoanPaid'];	
	 }
	 
	 
	 /*$mdata=mysql_query("select * from tblsalary where MonthYear='$MonthYear' and UserID='$UserID'");
	 $thismdata=mysql_fetch_assoc($mdata);
	 $MY=$thismdata['MonthYear'];
	 if($MY){
		 header("location:index.php?Theme=default&Base=SalaryPaySlip&Script=SalaryHistory&UserId=$UserID&MI=$MonthName&YI=$YearName");
	 }else{
	    $idata=mysql_query("insert into tblsalary(UserID,BasicSalary,HouseRent,TravellingAllow,MedicalAllow,FoodAllow,MobileAllow,Donation,Loan,Tax,LoanPaid,ProvidentFund,SecurityDeposit,MonthName,YearName,MonthYear)
	    values('$UserID','$BasicSalary','$HouseRent','$TravellingAllow','$MedicalAllow','$FoodAllow','$MobileAllow','$Donation','$Loan','$Tax','$LoanPaid','$ProvidentFund','$SecurityDeposit','$MonthName','$YearName','$MonthYear')");
	    if($idata){
		  header("location:index.php?Theme=default&Base=SalaryPaySlip&Script=SalaryHistory&UserId=$UserID&MI=$MonthName&YI=$YearName");	
		}
	 }*/
	 
}


