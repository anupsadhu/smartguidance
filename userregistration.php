<?php
   include("includes/function/fn_user.php");
   
   include("includes/function/ModelClass.php");
   
   $ObModel     = new Model();
   $message     = '';
   $firstName   = '';
   $lastName    = '';
   $userEmail   = '';
   $login       = '';
   
   $action=isset($_GET['action'])? $_GET['action'] : '';
   
   // This variable assign for to repopulate the text field if security code is incorrect.
    $firstName  = isset($_POST['firstname'])    ? $_POST['firstname']   : '';
    $lastName   = isset($_POST['lastname'])     ? $_POST['lastname']    : '';
    $userEmail  = isset($_POST['email'])        ? $_POST['email']       : '';
    $login      = isset($_POST['login'])        ? $_POST['login']       : '';
    $password   = isset($_POST['usrpassword'])  ? $_POST['usrpassword'] : '';
    
    if(isset($action) && $action=="registration")
    {
            $_userType = 2;
            $_add_date = date('Y-m-d H:i:s');
            
            $post_value_arr = array('UserName'=>trim($login),'Password'=>md5(trim($password)),'Name'=>trim($firstName),'Surname'=>trim($lastName),'added_date'=>$_add_date,'user_type'=>$_userType,'email'=>trim($userEmail)); 
            
            $condition_arr  = array('email'=>trim($userEmail),'UserName'=>trim($login));
            $msg            = user_add('email',$condition_arr,'users',$post_value_arr,"");                              
  
            if($msg > 0)
            {                  
                $message = "success"; 
                              
                //Below code block is using to send mail to register customer.                          
                $to         = trim($userEmail);
                $Subject    = 'Smartguidance.org - Registration confirmation email';                
                $body       = 'Thank you for Register with us !! We will contact you over phone or email for further reference.<br><br> If you have any queries please mail us at <a href="mailto:smartguideinfo@gmail.com">smartguideinfo@gmail.com</a>';
                //user_mail($to,$Subject,$body); 
                
                $to         = 'smartguideinfo@gmail.com';
                $Subject    = $login.' - User Registration on - '. $_add_date ;   
                $body       = 'A user has been created with pass - '.$password;
                
                //user_mail($to,$Subject,$body);                                          
                //header("Location: userregistration.php?_usrid=".$msg);                                  
            }
            else 
            {
                $message="fail";
            }

        }
?>


<!DOCTYPE HTML>
<html>
<head>
<title>Smartguidance :: Education Portal user registration</title>
<!-- Bootstrap -->
<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
<meta name="viewport" content="width=device-width, initial-scale=1">
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
 <!--[if lt IE 9]>
     <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
     <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<script type="text/javascript" src="js/userregistration_validation.js"></script>    
<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
<!-- start plugins -->
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<!----font-Awesome----->
   	<link rel="stylesheet" href="fonts/css/font-awesome.min.css">
<!----font-Awesome----->
</head>
<body>

<!-- Top Nav section -->
<?php include('includes/top_nav.php'); ?>

<div class="main_btm"><!-- start main_btm -->
	<div class="container">
		<div class="main row">
			    <div class="col-md-4 company_ad">
				    Adv. Placeholder
				</div>
				<div class="col-md-8">
				  <div class="contact-form">
                    <?php
                      if($message == '' || $message == 'fail')
                       {
                    ?>                       
				  	<h2>Register with Us</h2>
					    <form action="userregistration?action=registration" name="frm_reg" id ="frm_reg" method="post" onsubmit="return doSubmit();">
                            <?php
                                if($message == 'fail')
                                {
                                ?>
                                    <div><span style="color:red">User Name or Email already exists!! Please try with different user name or valid email.</span></div>
                                <?php
                                }
                            ?>
					    	<div>
						    	<span>First Name</span>
						    	<span><input type="text" name="firstname" class="form-control" value = "<?php echo $firstName ?>" id="firstname"></span>
						    </div>
                            <div>
                                <span>Last Name</span>
                                <span><input type="text" name="lastname" class="form-control" value = "<?php echo $lastName ?>" id="lastname"></span>
                            </div>
						    <div>
						    	<span>e-mail</span>
						    	<span><input type="text" name = "email" class="form-control" value = "<?php echo $userEmail ?>" id="email"></span>
						    </div>
                            <div>
                                <span>User Name</span>
                                <span><input type="login" name = "login" class="form-control" value = "<?php echo $login ?>" id="login"></span>
                            </div>
                            
                            <div>
                                <span>Password</span>
                                <span><input type="password" name ="usrpassword" class="form-control" id="usrpassword"></span>
                            </div>
						    
                             <div>
                                <span><input type="checkbox" name ="accptterms" id="accptterms"> Please accept Terms and Condition.</span>
                            </div>
                            
						   <div>
						   		<label class="fa-btn btn-1 btn-1e"><input type="submit" value="Register"></label>
						  </div>
					    </form>                       
				    </div>
                    <?php
                        }
                        else
                        {
                            echo 'Thank you for Register with us !! You will receive an email. We will contact you over phone or email for further reference.<br><br> If you have any queries please mail us at <a href="mailto:smartguideinfo@gmail.com">smartguideinfo@gmail.com</a>';
                        }
                    ?>                    
  			</div>	
            	
  			<div class="clearfix"></div>		
	</div> 
</div>
</div>
<?php
    include('includes/footer.php')
?>
</body>
</html>