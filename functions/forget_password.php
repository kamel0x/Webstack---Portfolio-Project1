<?php

// Import PHPMailer classes into the global namespace
require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;



/**
 * Send an email with PHPMailer.
 *
 * @param string $toEmail The recipient's email address.
 * @param string $toName The recipient's name.
 * @param string $subject The subject of the email.
 * @param string $body The body content of the email.
 * @return bool Returns true if the email was sent successfully, otherwise false.
 */
function sendEmail($toEmail, $randomNumber)
{
    $mail = new PHPMailer(true);


    try {
        // Server settings
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'shroukeslam909@gmail.com';                     // SMTP username
        $mail->Password   = 'temu rjik pxks zlxk';                               // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;           // Enable implicit TLS encryption
        $mail->Port       = 587;                                    // TCP port to connect to

        // Recipients
        $mail->setFrom('shroukeslam919@gmail.com', 'Shrouk Eslam');
        $mail->addAddress($toEmail);     // Add a recipient

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = "Forget Password";
        $mail->Body    = 'Your confirmation code is ' . '<b>' . $randomNumber . '</b>';

        // Send the email
        $mail->send();
        return true;
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        return false;
    }
}
