
//let jspdf= new jsPDF();
function sendEmail(attachment){
 Email.send({
     Host: "smtp.office365.com",
     Username : "krobert4@sgu.edu",
     Password : "Greyfalcon88",
     To : "krobert4@sgu.edu",
     From : "krobert4@sgu.edu",
     Subject : "emailSubject",
     Body : "emailBody",
     Attachments : [
     {
      name : "list.pdf",
      data : attachment

     }]
     }).then(function (message) { 
          alert("mail sent successfully") 
        }); 
     

}