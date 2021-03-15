	

function startingPoint(FN){
	//create jspdf object for storing pdf
	fileName=FN;
	let docimg = new jsPDF();
	//numReports=prompt("Please enter the number of reports you're sending out.");
	//masterEmail=prompt("Please enter your full email address, e.g jdoe@sgu.edu");
	//masterPassword=prompt("Please enter your password");

	EmailText=`Dear student, <br><br>

	Your exam results have been released. To view the results:<br>
	1. Open the PDF attachment in your web browser<br>
	2. or download the PDF attachment on your device<br>
	3. and open it using your preferred PDF software. <br><br>

	If you encounter any issues, please contact Jason Lucas (jlucas001@sgu.edu), Krishna Robertson (krobert4@sgu.edu) and cc Kevin Parke (kparke2@sgu.edu).<br><br>

	Department of Clinical Skills.`;

	//e=1;
		//loop through entire list of pages
		//var inter=setInterval(function(){
		//for(let e=1; e<=numReports;e++){
			//create new canvas for each request, each pdf page is rendered to its own canvas
			var canv = document.createElement("CANVAS");
			var canvName="the-canvas" + pageNume;
			console.log(canvName);
			canv.setAttribute("id", canvName); 
			document.body.appendChild(canv);
			generatePdf(pageNume,canv,fileName);
			
			/*if(e==numReports){
				clearInterval(inter);
			} */
			//e++;

		//}
		//},15000);
}

function GateKeeper(counter){

	//once last email is sent then generate report
	if(counter==numReports){
		console.log(counter +" " + numReports);
		//default coordinates are in mm units(279 mm long)
		reportPdf.text(successCounter + " student reports emailed successfully.",xCor,yCor+10);
		yCor=yCor + 10;
		//loop through failure array if any
		if(failureCounter > 0){
			//if there are errors then call function to try and resend
			//Resend(failureObj);
			for(let ru=0; ru <= failureArray.length; ru++){
				tot=ru+1;
				//add failed entry to report
				reportPdf.text(tot+". "+ failureArray[ru] + ": Email failed: ",xCor,yCor+10);
				yCor=yCor+10;
				//if yCor position is >250mm then go to next page
				if(yCor>240){
				//create new page with default values to pdf and reset y coordinate
					reportPdf.addPage();
					yCor=10;
				}
			}
		}


		outputPdf=reportPdf.output("datauri");
		
		var string1 = outputPdf;// doc.output('datauristring');
		var embed = "<embed width='100%' height='100%' src='" + string1 + "'/>"
		var x = window.open();
		x.document.open();
		x.document.write(embed);
		x.document.close();
		//document.body.appendChild(embed);

		return;
	}
	//if however, there are more reports to send then call generatePDf
	else if(counter<numReports){
		var canv = document.createElement("CANVAS");
		var canvName="the-canvas" + pageNume;
		console.log(canvName);
		canv.setAttribute("id", canvName); 
		document.body.appendChild(canv);
		generatePdf(pageNume,canv,fileName);
		//e++;
		//console.log("The value of e is GateKeeper: "+e);
	
	}
	else{
		return;
	
	}


	
//return;


}


function generatePdf(pageN,canvasnum,fName){

//Every call to the API returns a Promise, which allows asynchronous operations to be handled cleanly.
// If absolute URL from the remote server is provided, configure the CORS
// header on that server.
var url ="./" + fName;

pdfjsLib.GlobalWorkerOptions.workerSrc = './pdf.worker.js';
// Loaded via <script> tag, create shortcut to access PDF.js exports.
// Asynchronous download of PDF
var pageNumber;
let loadingTask;
var scale = 1.33;

	//open pdf 
	loadingTask = pdfjsLib.getDocument(url);
	//once pdf has being downloaded/open successfully, a pdfjs object is returned, pdf
	loadingTask.promise.then(function(pdf) {
		console.log('PDF loaded');
  
		// Fetch the first page
  
	
		pageNumber = pageN;
		//when the getPage method succeeds call the then...note that the then was defined in the getPage method.
		//Upon success the getPage method returns a single pdf page for processing
		pdf.getPage(pageNumber).then(function(page) {/*1.GET THE INDIVIDUAL PDG PAGE*/
			console.log('Page ' +pageNumber +' loaded');
			//console.log(pdf.numPages);
    
			//var scale = 1;
			//the view gives access to the dimension properties of the pdf
			var viewport = page.getViewport({scale: scale});
		 
			// Prepare canvas using PDF page dimensions
			var canvas = canvasnum; //document.getElementById('the-canvas' + i);
			var context = canvas.getContext('2d');
			canvas.height = viewport.height;
			canvas.width = viewport.width;
			imgWidth= viewport.width;
			imgHeight= viewport.height;
			let str=[];
			let email="";
			let emailArr=[];
			//before rendering page extract text, notice that a call to the api method getTextContent returns a promise which we access by then(the true part of the promise)
			var textContent = page.getTextContent();
			//if textContent succeeds then
			textContent.then(function (text) {/*2.GET THE CONTENTS OF THE PAGE*/
				console.log('Page content parsed' );
				for(let j = 0; j < text.items.length; j++) {
					//str.push(text.items[j].str);
					
					console.log(text.items[j]);
					//Find x and y coordinates of the correct column
					if(text.items[j].str==("CORRECT")){
						//console.log(parseInt(text.items[j].transform[4]));
						//var ctx = canvas.getContext("2d");
						//ctx.fillStyle = "#000000";
						//pdf rect coordinates: upper-left x, upper-left y, lower-right x and lower-right y.
						//x-coor, y-coor, width, h.
						//get the x coordinate of the correct column
						xCorCorrect=parseInt(text.items[j].transform[4])*scale;
						//get the y coordinate for the correct column
						yCorCorrect=text.items[j].transform[5] * scale;
						//get the width of the correct column
						xWidthCorrect=parseInt(text.items[j].width)*scale;
						//set the default limit of the y coordinate to be 20 pixels
						//There is at least a 20 px buffer between the correct column and the end of the page
						yCorPerLogic=20;
						// coor1=parseInt(text.items[j].transform[5])*1.33;
						//ctx.fillRect(coor,370,70,(imgHeight/2));
			
					}
				
				
					if(text.items[j].str.startsWith("Performance Logic:")){
					
						//pdf rect coordinates: upper-left x, upper-left y, lower-right x and lower-right y.
						//x-coor, y-coor, width, h.
						//get the y coordinate of the performance logic column
						 yCorPerLogic=parseInt(text.items[j].transform[5])* scale;
				
					}
				
			
					//if the username is found, then find the username and create the email address
					if(text.items[j].str.startsWith("Username:")){
						//console.log(text.items[j].str);
						email=text.items[j].str;
						emailArr=email.split(":");
						//console.log(emailArr);
						emailArr[1]=emailArr[1].trim();
						//find y coordinates for of username, subtract y coordinates from correct and username column
						yCorUsername=text.items[j].transform[5]*scale;
						if(emailArr[1]==""){
							//if the username is null then get the text on the next line-height
							tempStr=text.items[j+1].str;
							tempStr=tempStr.trim();
							emailArr[1]=tempStr.concat("@sgu.edu");
							console.log(emailArr[1]);
							
						}
						else{//if username is present then build email as normal. Builds email address from captured email on line 154
							emailArr[1]=emailArr[1].concat("@sgu.edu");
							console.log(emailArr[1]);
						}
						
					
					}
					
				  
				}
	
				
			});
		imgWidth=imgWidth - 30;
		imgHeight= imgHeight - 20;
		//now that you have the email address
		// Render PDF page into canvas context so that you can extract image to add to pdf
		var renderContext = {
		  canvasContext: context,
		  viewport: viewport
		};
		var renderTask = page.render(renderContext);
		renderTask.promise.then(function () {/*3.RENDER THE PAGE ONTO THE HTML CANVAS*/
			console.log('Page rendered');
			//drawing over the corrrect column
			var ctx = canvas.getContext("2d");
			ctx.fillStyle = "#FFFFFF";
			//pdf rect coordinates: upper-left x, upper-left y, lower-right x and lower-right y.
			//Subtract the y coordinates of the username and correct columns to get the starting y coordinate for the correct column
			yCoor=Math.abs(yCorUsername-yCorCorrect);
			//Draw the rectangle: x coor, y coor, width of rectangle is width of correct column, height is y coordinate of correct column - y coordinate of performance logic column
			ctx.fillRect(xCorCorrect,(yCoor+20),xWidthCorrect+2,Math.abs(yCorCorrect-yCorPerLogic)-10);
			console.log("xStart: "+xCorCorrect + "xWidth: "+ xWidthCorrect + "Height: "+Math.abs(yCorCorrect-yCorPerLogic)+"start y: "+yCoor);
			console.log(imgWidth  +" :" + imgHeight);
			console.log("YCorrect: "+yCorCorrect +" YPerLogic "+yCorPerLogic);
			var img = new Image(); 
			img.src = canvas.toDataURL("image/jpeg"); 
			img.setAttribute("width",imgWidth);
			img.setAttribute("height",imgHeight);
			document.body.appendChild(img);
		 
			imgWidth=imgWidth - 30;
			imgHeight= imgHeight - 30;
			//add image from cancas to pdf
			docimg= new jsPDF('p','pt','a4');
			docimg.addImage({imageData:img,format:"JPEG",x:0,y:10,compression:"NONE"});
		
			//create pdf and output to string,base64 encoding
			var string=docimg.output('datauri');
		
			Email.send({/*3.1 SEND AN EMAIL WITH THE IMAGE THAT WAS CAPTURED FROM THE HTML CANVAS*/
			Host: "smtp.office365.com",
			Username : masterEmail,
			Password : masterPassword,
			To : emailArr[1],
			From : masterEmail,
			Subject : "ExamSoft Strengths and Opportunities Report Released.",
			Body : EmailText,
			Attachments : [
			{
				name : "Strengths and Opportunities Report.pdf",
				data : string

			}]
			}).then(function (message) { 
				//called after successfully sending a student email
			  
				//clear the canvas
				/*if (context) {
					context.clearRect(0, 0, canvas.width, canvas.height);
					context.beginPath();
				}*/
				//remove the image
				img.remove();
				//add entry to report
				let tempTxt=emailArr[1];
				//check that returned code is 'OK', else an error occurred.
				if(message=="OK"){  
						//after a report is successfully sent then update the counter
						successCounter=successCounter + 1;
						console.log("mail sent successfully");
						//once report is successfully mailed then add email to report
						reportPdf.text(successCounter+". "+tempTxt+ " :Report successfully sent.",xCor,yCor+10);
						//move  cursor to next line
						yCor=yCor+10;
						//if yCor position is >250mm then go to next page
						if(yCor>240){
						//create new page with default values to pdf and reset y coordinate
							reportPdf.addPage();
							//restart staring coordinate
							yCor=10;
						}
						
						//counter keeps track of the numbr of reports processed. Those reports can be sent successfully or failed
						counter=counter+1;
						//increase page number by 1
						pageNume=pageNume+1;
						//out success essage to screen
						printElementRenderPdf(counter+". "+"Email successfully sent to: "+tempTxt);
						
						//call GateKeeper passing in the number of reports already sent, if that is equal to numReports then stop and generate report
						GateKeeper(counter);
					
				}
				else{
					//try sending failed email up to three times
					if(retryEmail<=3){
						//1. First remove the canvas element
						canvas.remove();
						//img.remove();
						
						console.log("The value of PageNume in failure: " + pageNume +"Attempting to resend: "+retryEmail+"counter: "+counter);
						//3. Call gate keeper again with same value of counter
						GateKeeper(counter);
						retryEmail++;
					}
					//if third attempt failed then place in report
					else{
						//if email failed, increment counter and write username
						failureCounter = failureCounter + 1;
						failureArray.push(emailArr[1]+" "+ message);
						console.log(message);
						//add failed pdf and email address as key value pair to object for resending
						//failureObj[emailArr[1]] = string;
						//reset retry email variable
						retryEmail=1;
						//counter keeps track of the numbr of reports processed. Those reports can be sent successfully or failed
						counter=counter+1; //in this case after three tries the report still failed so move on to the next one
						//move on to the next page
						pageNume=pageNume+1;
						printElementRenderPdf(counter+". "+"Email failed: "+emailArr[1]);
						//call GateKeeper passing in the number of reports already sent, if that is equal to numReports then stop and generate report
						GateKeeper(counter);
					}
				}
				//increment after every email is sent
				//counter=counter+1;
				
        }); 
		
	//
    });
	//attempt to convert canvas
	
	
	//sendEmail(page);
  
  });
 console.log("Parent promise finished");
},function (reason) {
  // PDF loading error
  console.error(reason);
  alert(reason);
  return;
});
//, function (reason) {
  // PDF loading error
  //console.error(reason);
//});
}

function printElementRenderPdf(EleContent){
	var Ele = document.createElement('P');
	//var canvName="the-canvas" + pageNume;
	//console.log(canvName);
	Ele.innerHTML=EleContent; 
	document.body.appendChild(Ele);
	//generatePdf(pageNume,canv,fileName);


}





/*RENDER USING SVG
// Get div#the-svg
  var container = document.getElementById('the-svg');

  // Set dimensions
  container.style.width = viewport.width + 'px';
  container.style.height = viewport.height + 'px';

  // SVG rendering by PDF.js
  page.getOperatorList()
    .then(function (opList) {
      var svgGfx = new PDFJS.SVGGraphics(page.commonObjs, page.objs);
      return svgGfx.getSVG(opList, viewport);
    })
    .then(function (svg) {
      container.appendChild(svg);
    });

});*/