<?php

if($_SERVER['REQUEST_METHOD']=="POST"){
	
	if(isset($_POST['action']) && $_POST['action']=="sendstatement"){
		$recipient=$_POST['recipient'];
		$attach=$_POST['attachment'];
		$bodyTxt=$_POST['body'];
		$senderEmail=$_POST['senderEmail'];
		$senderPassword=$_POST['senderPassword'];
		//echo $statementid;
		//$statementid="krobert4@sgu.edu";
		sendStatement($recipient,$attach,$bodyTxt,$senderEmail,$senderPassword);
	}
	else if(isset($_POST['action']) && $_POST['action']=="testCredentials"){
		
		//retrieve username and password
		testCredentials($_POST['UN'],$_POST['PW']);
		
	}
	
}



function sendStatement($receiver,$att,$bodyText,$ME,$MP){
	$proceed=send_via_curl($receiver,$att,$ME,$MP);


	if($proceed){
		echo "OK";
	}
	else{
		
		echo "FAILED";
	}
}

	


function testCredentials($un,$pw){
	$proceed=verify_via_curl($un,$pw);
	//echo "proceed is" & $proceed;
	

	if($proceed){
		echo "OK";
	}
	else{
		
		echo "FAILED";
	}
}


function send_via_curl($to,$dat,$Memail,$Mtoken){
	$ch = curl_init();
	$bodyText=<<<MSG
	
Dear student,

Your exam results have been released. To view the results:
1. Open the PDF attachment in your web browser
2. or download the PDF attachment on your device
3. and open it using your preferred PDF software.

If you encounter any technical issues, please contact BLine Support at blinesupport@sgu.edu.

Department of Clinical Skills.
MSG;
	//build email message together with base64 encided pdf attachement
$data='{
    "message": {
        "subject": "ExamSoft Strengths and Opportunities Report Released.",
        "body": {
            "contentType": "Text",
            "content":"';
$data.=$bodyText;
$data.='"},
        "toRecipients": [
            {
                "emailAddress": {
                    "address":"';
$data.=$to;
$data.='"
                }
            }
        ],
		"from":{
			"emailAddress":{
				"address":"blinesupport@sgu.edu"
			}
		},
        "attachments": [
            {
                "@odata.type": "#microsoft.graph.fileAttachment",
                "name": "attachment.pdf",
                "contentType": "text/plain",
                "contentBytes":"';
$data.=$dat;
$data.='"
            }
        ]
    }
}';
//echo $data;
//$dat=json_encode($data);

// set a single option...
//curl_setopt($ch, OPTION, $value);
// ... or an array of options
/*curl_setopt_array($ch, array( 
    OPTION1 => $value1, 
    OPTION2 => $value2
));*/
//curl -i -X GET \
//global $token;
$tok=$Mtoken;
curl_setopt_array(
    $ch, array( 
    CURLOPT_URL => "https://graph.microsoft.com/v1.0/me/sendMail",
     CURLOPT_RETURNTRANSFER => true,         // return web page 
        CURLOPT_HEADER         => true,        // don't return headers 
        CURLOPT_FOLLOWLOCATION => true,         // follow redirects 
        CURLOPT_ENCODING       => "",           // handle all encodings 
        //CURLOPT_AUTOREFERER    => true,         // set referer on redirect 
        //CURLOPT_CONNECTTIMEOUT => 120,          // timeout on connect 
        //CURLOPT_TIMEOUT        => 120,          // timeout on response 
        //CURLOPT_MAXREDIRS      => 10,           // stop after 10 redirects 
        CURLOPT_POST            => 1,            // i am sending post data     // 
        CURLOPT_VERBOSE        => 0,
		CURLOPT_HTTPHEADER=>array('Content-Type: application/json',"Authorization:$tok"),
		CURLOPT_POSTFIELDS=>$data,
		CURLOPT_SSL_VERIFYPEER=>FALSE
));
// execute
$output = curl_exec($ch);
curl_close($ch);
$pro=strpos($output,'HTTP/1.1 202 Accepted');
echo $output;
if($pro>=0){
	return true;
}
else{
	return false;
}	
	
	
}


function verify_via_curl($email,$pass){
	$ch = curl_init();
$data='{
    "message": {
        "subject": "A batch of reports are about to be sent.",
        "body": {
            "contentType": "Text",
            "content": "A new batch of reports will be sent."
        },
        "toRecipients": [
            {
                "emailAddress": {
                    "address": "';
$data.=$email;
$data.='"
                }
            }
        ]
    }
}';
//$dat=json_encode($data);

// set a single option...
//curl_setopt($ch, OPTION, $value);
// ... or an array of options
/*curl_setopt_array($ch, array( 
    OPTION1 => $value1, 
    OPTION2 => $value2
));*/
//curl -i -X GET \
global $token;
$tok=$pass;
curl_setopt_array(
    $ch, array( 
    CURLOPT_URL => "https://graph.microsoft.com/v1.0/me/sendMail",
     CURLOPT_RETURNTRANSFER => true,         // return web page 
        CURLOPT_HEADER         => true,        // don't return headers 
        CURLOPT_FOLLOWLOCATION => true,         // follow redirects 
        CURLOPT_ENCODING       => "",           // handle all encodings 
        //CURLOPT_AUTOREFERER    => true,         // set referer on redirect 
        //CURLOPT_CONNECTTIMEOUT => 120,          // timeout on connect 
        //CURLOPT_TIMEOUT        => 120,          // timeout on response 
        //CURLOPT_MAXREDIRS      => 10,           // stop after 10 redirects 
        CURLOPT_POST            => 1,            // i am sending post data     // 
        CURLOPT_VERBOSE        => 0,
		CURLOPT_HTTPHEADER=>array('Content-Type: application/json',"Authorization:$tok"),
		CURLOPT_POSTFIELDS=>$data,
		CURLOPT_SSL_VERIFYPEER=>FALSE
));
// execute
$output = curl_exec($ch);


// free
curl_close($ch);
$pro=strpos($output,"HTTP/1.1 202 Accepted");
//echo $output;
if($pro>=0){
	return true;
}
else{
	return false;
}
	
}	


?>
