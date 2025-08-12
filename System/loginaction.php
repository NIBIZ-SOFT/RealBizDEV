<?php
	/*
		Script:		
		Author:		SunJove@gmail.com
		Date:		
		Purpose:	
		Note:		
	*/
	
	$RequiredInputMissing=false;

	$User=SQL_Select($Entity="User", $Where="UserName = '{$_POST["LogInUserName"]}' AND UserPassword = '{$_POST["LogInUserPassword"]}' AND UserIsActive = 1 AND UserIsRegistered = 1", $OrderBy="UserName", $SingleRow=false, $Debug=false);
	if(count($User)<1){$ErrorUserInput["_Error"]=true; $ErrorUserInput["_Message"]="Sorry, the username or password not correct!";}

	if(trim($_POST["LogInUserPassword"])==""){$ErrorUserInput["_Error"]=true; $ErrorUserInput["_Message"]="Please provide with the password";}
	if(trim($_POST["LogInUserName"])==""){$ErrorUserInput["_Error"]=true; $ErrorUserInput["_Message"]="Please provide with the username";}
	
	if($ErrorUserInput["_Error"]){
		echo $MainContent.="
		    <script>
		        alert('{$ErrorUserInput["_Message"]}');
		        history.go(-1);
		    </script>
		    ".CTL_Window(
				$Title="System Security",
				$Content=$ErrorUserInput["_Message"]
			)."
		";
		
		exit;
	}else{
            SessionSetUser($UserRow=$User[0]);
        
        	if($User[0]["UserCategory"]=="Client"){
        
        		$_SESSION["UserCategory"]=$User[0]["UserCategory"];
        		$_SESSION["CustomerPhone"]=$User[0]["PhoneHome"];
        		
                echo $MainContent .= '
                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
                    <style>
                        .login-success-wrapper {
                            min-height: 50vh;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                        }
                        .login-success-card {
                            max-width: 400px;
                            width: 100%;
                        }
                        .green-tick {
                            background: #28a745;
                            color: #fff;
                            border-radius: 50%;
                            width: 60px;
                            height: 60px;
                            display: inline-flex;
                            align-items: center;
                            justify-content: center;
                            font-size: 2rem;
                        }
                    </style>
                    <div class="login-success-wrapper">
                        <div class="card shadow login-success-card">
                            <div class="card-header bg-success text-white text-center">
                                <h4 class="mb-0"><i class="bi bi-check-lg"></i> Welcome Back!</h4>
                            </div>
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <span class="green-tick">
                                        <i class="bi bi-check-lg"></i>
                                    </span>
                                </div>
                                <h5 class="text-success mb-3">Welcome, <span class="fw-bold">'.htmlspecialchars($_SESSION["UserName"]).'</span>!</h5>
                                <p class="lead mb-2">Thank you for returning.</p>
                                <p>
                                    <a href="'.ApplicationURL("ClientHome","Manage").'" class="btn btn-primary">
                                        Proceed to Dashboard
                                    </a>
                                </p>
                                <hr>
                                <div class="mt-2 text-muted" style="font-size:1.1em;">
                                    RealBiz ERP V9.1
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        setTimeout(function(){
                            window.location.href="'.ApplicationURL("ClientHome","Manage").'";
                            }, 100);
                    </script>
                
                ';        		
        		exit;
   
        
        	}else  {      
        
                echo $MainContent .= '
                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
                    <style>
                        .login-success-wrapper {
                            min-height: 50vh;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                        }
                        .login-success-card {
                            max-width: 400px;
                            width: 100%;
                        }
                        .green-tick {
                            background: #28a745;
                            color: #fff;
                            border-radius: 50%;
                            width: 60px;
                            height: 60px;
                            display: inline-flex;
                            align-items: center;
                            justify-content: center;
                            font-size: 2rem;
                        }
                    </style>
                    <div class="login-success-wrapper">
                        <div class="card shadow login-success-card">
                            <div class="card-header bg-success text-white text-center">
                                <h4 class="mb-0"><i class="bi bi-check-lg"></i> Welcome Back!</h4>
                            </div>
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <span class="green-tick">
                                        <i class="bi bi-check-lg"></i>
                                    </span>
                                </div>
                                <h5 class="text-success mb-3">Welcome, <span class="fw-bold">'.htmlspecialchars($_SESSION["UserName"]).'</span>!</h5>
                                <p class="lead mb-2">Thank you for returning.</p>
                                <p>
                                    <a href="'.ApplicationURL("Category","Manage").'" class="btn btn-primary">
                                        Proceed to Dashboard
                                    </a>
                                </p>
                                <hr>
                                <div class="mt-2 text-muted" style="font-size:1.1em;">
                                    RealBiz ERP V9.1
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        setTimeout(function(){
                            window.location.href="'.ApplicationURL("Page","Home").'";
                            }, 100);
                    </script>
                ';
        		
        		exit;
	    }		
	}
?>