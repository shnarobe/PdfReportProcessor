<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '.\PHPMailer-master\src\Exception.php';
require '.\PHPMailer-master\src\PHPMailer.php';
require '.\PHPMailer-master\src\SMTP.php';
//include_once("PHPMailer-master\PHPMailer-master\PHPMailerAutoload.php");
try{
$mail = new PHPMailer(true);
$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.office365.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'krobert4@sgu.edu';                 // SMTP username
$mail->Password = '_Greyfalcon77@';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;  
}
catch(Exception $e){
	
	
	
}// TCP port to connect to
if($_SERVER['REQUEST_METHOD']=="POST"){
	
	if(isset($_POST['action']) && $_POST['action']=="sendstatement"){
	$statementid=$_POST['recipient'];
	$attach=$_POST['attachment'];
	$bodyTxt=$_POST['body'];
	$FN=$_POST['fileNumber'];
	//echo $statementid;
	//$statementid="krobert4@sgu.edu";
	sendStatement($statementid,$attach,$bodyTxt,$FN);
	
	
	
	
	
}
	
}


function sendStatement($con, $att,$bodyText,$fileNum){
	
global $mail;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output
try{

//$mail->confirmReadingTo='loans@forshorelending.com';
//$mail->addReplyTo('loans@forshorelending.com','reply');
$mail->setFrom('krobert4@sgu.edu', 'forshorelending');
$mail->addAddress($con, "krishna"); //To address 
//$mail->addAddress($useremail, $name);  // Add a recipient
//$mail->addAddress('ellen@example.com');               // Name is optional
//$mail->addReplyTo('info@example.com', 'Information');
//$mail->addCC('cc@example.com');
//$mail->addBCC('bcc@example.com');
$bin = base64_decode($att, true);
file_put_contents('PDFs/'.$fileNum.'.pdf', $bin);
$mail->addAttachment('PDFs/'.$fileNum.'.pdf');         // Add attachments
//$mail->addAttachment($res['location'], 'Your contract');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Your statement.';
$mail->Body    = $bodyText;
//$mail->AltBody = '';

/*if(!$mail->send()) {
	$mail->ErrorInfo;
    $errors['error']=$mail;
	$errors['success']=false;
	echo json_encode($errors);
	
} else {
	$errors['success']=true;
	echo json_encode($errors);
				}
			*/

	if($mail->send()){
		echo json_encode("OK");
	}
	else{
		
		echo json_encode("FAILED");
	}
}
catch(Exception $e){
	echo json_encode($e);
}

}	

?>