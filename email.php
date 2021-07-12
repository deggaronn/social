<?php
include('db.php');
if(isset($_POST["user_email"]) && (!empty($_POST["user_email"]))){
$email = $_POST["user_email"];
$email = filter_var($email, FILTER_SANITIZE_EMAIL);
$email = filter_var($email, FILTER_VALIDATE_EMAIL);
if (!$email) {
   $error .="<p>Invalid email address please type a valid email address!</p>";
   }else{
   $sel_query = "SELECT * FROM `registration` WHERE user_email='".$email."'";
   $results = mysqli_query($con,$sel_query);
   $row = mysqli_num_rows($results);
   if ($row==""){
   $error .= "<p>No user is registered with this email address!</p>";
   }
  }
   if($error!=""){
   echo "<div class='error'>".$error."</div>
   <br /><a href='javascript:history.go(-1)'>Go Back</a>";
   }else{
   $password = md5(2418*2+$email);
   $addpassword = substr(md5(uniqid(rand(),1)),3,10);
   $password = $password . $addpassword;
mysqli_query($con,
"INSERT INTO `registration` (`user_email`, `user_password`)
VALUES ('".$email."', '".$password."');");

$output='<p>Dear user,</p>';
$output.='<p>Please click on the following link to reset your password.</p>';
$output.='<p>-------------------------------------------------------------</p>';
$output.='<p><a href="https://www.allphptricks.com/forgot-password/reset-password.php?
password='.$password.'&email='.$email.'&action=reset" target="_blank">
https://www.allphptricks.com/forgot-password/reset-password.php
?key='.$key.'&email='.$email.'&action=reset</a></p>';		
$output.='<p>-------------------------------------------------------------</p>';
$output.='<p>Please be sure to copy the entire link into your browser.
The link will expire after 1 day for security reason.</p>';
$output.='<p>If you did not request this forgotten password email, no action 
is needed, your password will not be reset. However, you may want to log into 
your account and change your security password as someone may have guessed it.</p>';   	
$output.='<p>Thanks,</p>';
$output.='<p>Team FriendBook</p>';
$body = $output; 
$subject = "Password Recovery";

$email_to = $email;
$fromserver = "noreply@friendbook.com"; 
require("vendor/phpmailer/PHPMailerAutoload.php");
$mail = new PHPMailer();
$mail->IsSMTP();
$mail->Host = "mail.google.com";
$mail->SMTPAuth = true;
$mail->Username = "friendbookt@gmail.com";
$mail->Password = "Friendbookteam@123";
$mail->Port = 25;
$mail->IsHTML(true);
$mail->From = "noreply@friendbook.com";
$mail->FromName = "Friendbook";
$mail->Sender = $fromserver;
$mail->Subject = $subject;
$mail->Body = $body;
$mail->AddAddress($email_to);
if(!$mail->Send()){
echo "Mailer Error: " . $mail->ErrorInfo;
}else{
echo "<div class='error'>
<p>An email has been sent to you with instructions on how to reset your password.</p>
</div><br /><br /><br />";
	}
   }
}else{
?>
<link rel='stylesheet' href='css/reset.css' type='text/css' media='all' />
<div class="form-name" style="background-image: url("/img/backgroundfp.jpg");">
   <form method="post" action="" name="reset" ><br /><br />
  <centre> <label><strong>Enter Your Email Address:</strong></label><br /><br />
   <input type="email" class="email" name="email" placeholder="username@email.com" />
   <br /><br />
   <input type="submit" class="submit" value="Reset Password"/></centre>
   <br/><br/>
   or go back to <a id="login" href="index.php">Login</a>
   </form>

</div>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<?php } ?>