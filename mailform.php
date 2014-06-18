<?php


require("libs/PHPMailer-master/PHPMailerAutoload.php");

$email = $_POST['email'];
$name = $_POST['name'];
$message = $_POST['message'];

$mail = new PHPMailer();
//Tell PHPMailer to use SMTP
$mail->isSMTP();

//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 0;

//Ask for HTML-friendly debug output
$mail->Debugoutput = 'html';

//Set the hostname of the mail server
$mail->Host = 'smtp.gmail.com';

//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
$mail->Port = 587;

//Set the encryption system to use - ssl (deprecated) or tls
$mail->SMTPSecure = 'tls';

//Whether to use SMTP authentication
$mail->SMTPAuth = true;

//Username to use for SMTP authentication - use full email address for gmail
$mail->Username = "djintech2803@gmail.com";

//Password to use for SMTP authentication
$mail->Password = "forkbomb!@704";

//Set who the message is to be sent from
$mail->setFrom($email, $name);

//Set an alternative reply-to address
//$mail->addReplyTo('tdoolittle3@example.com', 'First Last');

//Set who the message is to be sent to
$mail->addAddress('tdoolittle3@gmail.com', 'Thomas Doolittle');

//Set the subject line
$mail->Subject = 'CS2803 PHPMailer Message from '.$email;

$mail->isHTML(true);
$mail->Body = $message;

//Replace the plain text body with one created manually
$mail->AltBody = $message;


if($_POST['submit']) {
    if(!$mail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'Message has been sent';
    }
}


?>