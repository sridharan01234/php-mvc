<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

$message = "Hii THis is to check ;)";
$mail->IsSMTP();
$mail->SMTPDebug = 0; 
$mail->SMTPAuth = true; 
$mail->SMTPSecure = 'tls'; 
$mail->Host = "smtp.gmail.com";
$mail->Port = 587; 
$mail->IsHTML(true);
$mail->Username = "sridharan01234@gmail.com";
$mail->Password = "lhvlpsjsnlszulfz";
$mail->SetFrom("Sridharan");
$mail->Subject = "Application for Programmer Registration";
$mail->Body = $message;
$mail->AddAddress("sridharan.it19@bitsathy.ac.in", "HR");


$headers = "From: Sender\n";
$headers .= 'Content-Type:text/calendar; Content-Disposition: inline; charset=utf-8;\r\n';
$headers .= "Content-Type: text/plain;charset=\"utf-8\"\r\n"; 

if (!$mail->Send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message has been sent";
}