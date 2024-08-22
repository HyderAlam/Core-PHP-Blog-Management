<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';
require '../PHPMailer-master/src/Exception.php';

require("fpdf/fpdf.php");
require("functions.php");

if (isset($_SESSION['data'])) {

//Create a new PHPMailer instance
$mail = new PHPMailer();
//Tell PHPMailer to use SMTP
$mail->isSMTP();

//Enable SMTP debugging
// SMTP::DEBUG_OFF = off (for production use)
// SMTP::DEBUG_CLIENT = client messages
// SMTP::DEBUG_SERVER = client and server messages
//$mail->SMTPDebug = SMTP::DEBUG_SERVER;
//Set the hostname of the mail server
$mail->Host = 'smtp.gmail.com';
// use
// $mail->Host = gethostbyname('smtp.gmail.com');
// if your network does not support SMTP over IPv6
//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
$mail->Port = 587;
//Set the encryption mechanism to use - STARTTLS or SMTPS
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
//Whether to use SMTP authentication
$mail->SMTPAuth = true;
//Username to use for SMTP authentication - use full email address for gmail
$mail->Username = 'hyderalam444@gmail.com';
//Password to use for SMTP authentication
$mail->Password = 'qfcgbxrtowodostd';

//Set who the message is to be sent from
$mail->setFrom('hyderalam444@gmail.com', 'New User Resgister');

//Set an alternative reply-to address
$mail->addReplyTo('hyderalam444@gmail.com', '');

//Set who the message is to be sent to
$query="SELECT * FROM user WHERE role_id = 1";
$result=excecute_query($query);
if($result->num_rows > 0)
{
	while ($row=mysqli_fetch_assoc($result)) {

$mail->addAddress($row['email'], $row['first_name']);
	
	}

}
//$mail->addCC('cc@example.com');
//$mail->addBCC('bcc@example.com');


//Set the subject line
$mail->Subject = "New Account Request";

$mail->isHTML(true);
//Read an HTML message body
//$mail->msgHTML("<h1>Kindly Review Attachment</h1>");
$mail->Body    = "<h3>NEW USER REQUEST TO SENT TO YOU </h3> 
<p> UserName: ".$_SESSION['data']['first_name']." 
<br>Email: " .$_SESSION['data']['email']."
<br>Address:" .$_SESSION['data']['address']."</p>";
//Attach an image file (optional)
if (!$mail->send()) {
   
} else {
    	
/*________________________pdf______________________________________*/
$imagePath = '../' .$_SESSION['data']['user_image'];

$pdf=new FPDF();
$pdf->AddPage("P","A4",0);
$pdf->setFont("Helvetica","B",24);
$pdf->setFillColor(125,255,126);
$pdf->Cell(0,10,"Welcome  " .$_SESSION['data']['first_name']." ".$_SESSION['data']['last_name'] ,1,1,"C");
$pdf->Ln(5);
$pdf->Image($imagePath, 165, 25, 30, 30,'jpg');
$pdf->setFont("Times","",12);
$pdf->Cell(0,10,"FullName  : " .$_SESSION['data']['first_name']." ".$_SESSION['data']['last_name'] ,0,1,"L");
$pdf->Cell(0,10,"Email  : " .$_SESSION['data']['email'],0,1,"L");
$pdf->Cell(0,10,"Password  : " .$_SESSION['data']['password'],0,1,"L");
$pdf->Cell(0,10,"Date of birth  : " .$_SESSION['data']['date_of_birth'],0,1,"L");
$pdf->Cell(0,10,"Lives in  : " .$_SESSION['data']['address'],0,1,"L");
$pdf->Ln(10);
$pdf->Write(10,"Thanks For registeration wait for Admin response Through email for Access..!");
$pdf->Output("I","userdetail.pdf");

}		

session_destroy();
unset($_SESSION['data']);

} else {

header("location: ../login.php");

}




?>