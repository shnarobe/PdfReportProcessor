<?php
$token="eyJ0eXAiOiJKV1QiLCJub25jZSI6IkxhRW9kbHlmQnBaUnRsWmxWTTJpelBJcVBWV0lVQzRKUEJVSDczajRGeTQiLCJhbGciOiJSUzI1NiIsIng1dCI6ImpTMVhvMU9XRGpfNTJ2YndHTmd2UU8yVnpNYyIsImtpZCI6ImpTMVhvMU9XRGpfNTJ2YndHTmd2UU8yVnpNYyJ9.eyJhdWQiOiIwMDAwMDAwMy0wMDAwLTAwMDAtYzAwMC0wMDAwMDAwMDAwMDAiLCJpc3MiOiJodHRwczovL3N0cy53aW5kb3dzLm5ldC8wNzY0YWJlOC02Mzk1LTQ1OGQtOGNiMy0xMDUwYzUxMmMwYjIvIiwiaWF0IjoxNjUzMjczNTM0LCJuYmYiOjE2NTMyNzM1MzQsImV4cCI6MTY1MzI3ODgyMSwiYWNjdCI6MCwiYWNyIjoiMSIsImFpbyI6IkFWUUFxLzhUQUFBQUREUFJWOXVPNTAveEdLKythWVpoVmhBL0huWkNFVUdwUDh1SGdaTERVcXNRd3hhRmZLWlNHNEh2eUFNYWZHNGlRTzdUZDNKazJJUGJFS3JZWTFQV2tkRTdBNzNUejdYcXBPQ1dTZ2N2b2lvPSIsImFtciI6WyJwd2QiLCJtZmEiXSwiYXBwX2Rpc3BsYXluYW1lIjoiR3JhcGggRXhwbG9yZXIiLCJhcHBpZCI6ImRlOGJjOGI1LWQ5ZjktNDhiMS1hOGFkLWI3NDhkYTcyNTA2NCIsImFwcGlkYWNyIjoiMCIsImZhbWlseV9uYW1lIjoiUm9iZXJ0c29uIiwiZ2l2ZW5fbmFtZSI6IktyaXNobmEiLCJpZHR5cCI6InVzZXIiLCJpcGFkZHIiOiI3NC4xMTcuODYuMjAiLCJuYW1lIjoiS3Jpc2huYSBSb2JlcnRzb24iLCJvaWQiOiIzNDExYjFjYS0wNjBmLTRmZWMtODc2Yi1lZmMxOTA3NjBhZjMiLCJvbnByZW1fc2lkIjoiUy0xLTUtMjEtNDAwNzA1NzEyNi0yMzA3MzA5MzEzLTc0ODUxMDg0Ni04NjI0OCIsInBsYXRmIjoiMyIsInB1aWQiOiIxMDAzMjAwMDlBRURBOTAyIiwicmgiOiIwLkFXNEE2S3RrQjVWampVV01zeEJReFJMQXNnTUFBQUFBQUFBQXdBQUFBQUFBQUFCdUFQSS4iLCJzY3AiOiJNYWlsLlNlbmQgb3BlbmlkIHByb2ZpbGUgVXNlci5SZWFkIGVtYWlsIiwic3ViIjoiYVpvdU8tQXNmckJMR19RZjN0aXRZcVc4eU90d3hFRWwzQnpqdzNlaTkzVSIsInRlbmFudF9yZWdpb25fc2NvcGUiOiJOQSIsInRpZCI6IjA3NjRhYmU4LTYzOTUtNDU4ZC04Y2IzLTEwNTBjNTEyYzBiMiIsInVuaXF1ZV9uYW1lIjoia3JvYmVydDRAc2d1LmVkdSIsInVwbiI6Imtyb2JlcnQ0QHNndS5lZHUiLCJ1dGkiOiJXQUFsM0VKZ3BFaWNTR08yMzU5ckFRIiwidmVyIjoiMS4wIiwid2lkcyI6WyJiNzlmYmY0ZC0zZWY5LTQ2ODktODE0My03NmIxOTRlODU1MDkiXSwieG1zX3N0Ijp7InN1YiI6Il9TcDdmcFYtTHd4T2hNUHdwcEJOb1dlMUk2LVNUemVKcFVBa3V0YS1zM3cifSwieG1zX3RjZHQiOjE0MDQzOTkwNDh9.WgI23QyhLfP0AzFY3En_C2BaVeLoIpw3U-LfXE4_ROviRRHQd3bd2CX6J4k-8TiaisWPrGCiWNgFoVQ3AEt6afs7yahwxrDcwlxBSKhvijjp36EpvQCxyIShVMNzvlKIhtq5ouQ93od1PIi-nv44WTqGN4X0W4uI3zM1xvHzUpZAUvTe88fjP3hga2PY2Togh_WkBTT3JjOLpMIbfK3wZA6LW7RNvbYDUL88v604QYN3GMFHvaYS-JfqouNvB5UMxTITQTsP32oPcO9mg1P1OsvnUs7CXdxGd9Uq8RiMyVjV7AB3RNJi44SUKd8J3WfNn1JKpa3HwUmaFW5LTf0RWw";

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
	$proceed=send_via_curl($receiver,$att,$bodyText);


	if($proceed){
		echo "OK";
	}
	else{
		
		echo "FAILED";
	}
}

	


function testCredentials($un,$pw){
	$proceed=verify_via_curl();
	//echo "proceed is" & $proceed;
	

	if($proceed){
		echo "OK";
	}
	else{
		
		echo "FAILED";
	}
}


function send_via_curl($to,$dat){
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
global $token;
$tok=$token;
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


function verify_via_curl(){
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
                    "address": "krobert4@sgu.edu"
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
$tok=$token;
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
