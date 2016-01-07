<?php

include("./mpdf/mpdf.php");

$onlid = $_POST['ref_id'];

$email = $_POST['email'];
$print_template = $_POST['print_template'];
//settup
$mpdf = new mPDF('c');
$mpdf->SetDisplayMode('fullpage');
// The parameter 1 tells that this is css/style only and no body/html/text
//$mpdf->WriteHTML(utf8_encode($fileContents));
$html = '';
if (!empty($print_template)) {
    $html = file_get_contents("http://mdccdev.ga/carsale/{$print_template}?print_view=1&pi_id={$onlid}");
}
$mpdf->WriteHTML($html);
//$mpdf->Output($fileName,'D');
//I: send the file inline to the browser. The plug-in is used if available. The name given by filename is used when one selects the "Save as" option on the link generating the PDF.
//D: send to the browser and force a file download with the name given by filename.
//F: save to a local file with the name given by filename (may include a path).
//S: return the document as a string. filename is ignored.
//Beginning Buffer to save PHP variables and HTML tags
ob_start();

//$content = $mpdf->Output("test.pdf", 'I');
//exit;

$content = $mpdf->Output($fileName, 'S');

$contents = chunk_split(base64_encode($content));
$mailto = $email; //Mailto here
$from_name = 'Siyekra International'; //Name of sender mail
$from_mail = 'contact@siyekra.com'; //Mailfrom here
$subject = 'Pro-forma Invoice';
$message = 'This Invoice generated automaticaly';
$filename = "Pro-formaInvoice.pdf"; //Your Filename with local date and time
//Headers of PDF and e-mail
$boundary = "XYZ-" . date("dmYis") . "-ZYX";
$header = "--$boundary\r\n";
$header .= "Content-Transfer-Encoding: 8bits\r\n";
$header .= "Content-Type: text/html; charset=ISO-8859-1\r\n\r\n"; // or utf-8
$header .= "$message\r\n";
$header .= "--$boundary\r\n";
$header .= "Content-Type: application/pdf; name=\"" . $filename . "\"\r\n";
$header .= "Content-Disposition: attachment; filename=\"" . $filename . "\"\r\n";
$header .= "Content-Transfer-Encoding: base64\r\n\r\n";
$header .= "$contents\r\n";
$header .= "--$boundary--\r\n";
$header2 = "MIME-Version: 1.0\r\n";
$header2 .= "From: " . $from_name . " <".$from_mail.">\r\n";
$header2 .= "Return-Path: $from_mail\r\n";
if (filter_var($_POST['email_cc1'], FILTER_VALIDATE_EMAIL)) {
    $header2 .= "cc: {$_POST['email_cc1']}\r\n";
}
if (filter_var($_POST['email_cc2'], FILTER_VALIDATE_EMAIL)) {
    $header2 .= "cc: {$_POST['email_cc2']}\r\n";
}
$header2 .= "Content-type: multipart/mixed; boundary=\"$boundary\"\r\n";
$header2 .= "$boundary\r\n";
//

mail($mailto, $subject, $header, $header2, "-r" . $from_mail);
ob_clean();
echo "<center><span style='background-color:#44c767;
	border-radius:100px;
	border:5px solid #18ab29;
	display:inline-block;
	cursor:pointer;
	color:#000000;
	font-family:Impact;
	font-size:28px;
	padding:0px 0px;
	text-decoration:none;'>message has been submitted successfully</span></center>";

header("refresh:2; url=view_vehicle_list.php");


exit;
//==============================================================
//==============================================================
//==============================================================
?>