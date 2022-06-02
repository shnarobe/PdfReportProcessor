# PdfReportProcessor
Takes a pdf report and processes it for distribution.
After processing the Pdfs using the PDFjs and jsPDF opensource libraries, the pdfs are emailed by extrting the username from ech document. 
They are then sent to the user by making curl calls to the microsfot graph api using an access token received from the api.
