<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '.\PHPMailer-master\src\Exception.php';
require '.\PHPMailer-master\src\PHPMailer.php';
require '.\PHPMailer-master\src\SMTP.php';
//include_once("PHPMailer-master\PHPMailer-master\PHPMailerAutoload.php");
try{
$mail = new PHPMailer(true); //Argument true in constructor enables exceptions
$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.office365.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
//Enable SMTP debugging.
//$mail->SMTPDebug = 3; 
$mail->Username = 'krobert4@sgu.edu';                 // SMTP username
$mail->Password = '_Greyfalcon77@';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;  
}
catch(Exception $e){
	
	echo $e;
	
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
	else if(isset($_POST['action']) && $_POST['action']=="testCredentials"){
		//retrieve username and password
		testCredentials($_POST['UN'],$_POST['PW']);
		
	}
	
}


function sendStatement($con, $att,$bodyText,$fileNum){
	
global $mail;
$proceed;
//$mail->SMTPDebug = 3;                               // Enable verbose debug output
try{
/*//From email address and name
$mail->From = "from@yourdomain.com";
$mail->FromName = "Full Name";

//To address and name
$mail->addAddress("recepient1@example.com", "Recepient Name");
$mail->addAddress("recepient1@example.com"); //Recipient name is optional

//Address to which recipient will reply
$mail->addReplyTo("reply@yourdomain.com", "Reply");

//CC and BCC
$mail->addCC("cc@example.com");
$mail->addBCC("bcc@example.com");
*/
//$mail->confirmReadingTo='loans@forshorelending.com';
//$mail->addReplyTo('loans@forshorelending.com','reply');
$mail->setFrom('krobert4@sgu.edu', 'forshorelending');
$mail->addAddress($con, "krishna"); //To address 
//$mail->addAddress($useremail, $name);  // Add a recipient
//$mail->addAddress('ellen@example.com');               // Name is optional
//$mail->addReplyTo('info@example.com', 'Information');
//$mail->addCC('cc@example.com');
//$mail->addBCC('bcc@example.com');
//decode the base 64 of the pdf file
$bin = base64_decode($att, true);
//write file to folder
$proceed = file_put_contents('PDFs/'.$fileNum.'.pdf', $bin);
if($proceed===false){
	return "Failed to write file";
	
}

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
		echo "OK";
	}
	else{
		
		echo "FAILED";
	}
}
catch(Exception $e){
	echo $e;
}

}	


function testCredentials($un,$pw){
	
global $mail;
$proceed;
//$mail->SMTPDebug = 3;                               // Enable verbose debug output
try{

//$mail->confirmReadingTo='loans@forshorelending.com';
//$mail->addReplyTo('loans@forshorelending.com','reply');
$mail->setFrom($un, 'forshorelending');
$mail->addAddress($un, "krishna"); //To address 
//$mail->addAddress($useremail, $name);  // Add a recipient
//$mail->addAddress('ellen@example.com');               // Name is optional
//$mail->addReplyTo('info@example.com', 'Information');
//$mail->addCC('cc@example.com');
//$mail->addBCC('bcc@example.com');
//decode the base 64 of the pdf file
$mail->Username = $un;                 // SMTP username
$mail->Password = $pw;    
//$mail->addAttachment($res['location'], 'Your contract');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Test email.';
$mail->Body    = "This a test email to verify your credentials. A batch of reports are about to be sent.";
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
		echo "OK";
	}
	else{
		
		echo "FAILED";
	}
}
catch(Exception $e){
	echo " FAILED: ".$e;
}

}	


?>