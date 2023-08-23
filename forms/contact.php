<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../assets/phpmailer/Exception.php';
require '../assets/phpmailer/PHPMailer.php';
require '../assets/phpmailer/SMTP.php';

$error = [];
$msg = '';
//Create an instance; passing `true` enables exceptions
if ( array_key_exists( 'email', $_POST ) ) {
  date_default_timezone_set( 'Etc/UTC' );


  $name = $_POST['name'];
  $email = $_POST['email'];
  $subject = $_POST['subject'];
  $message = $_POST['message'];
 
    $mail = new PHPMailer(true);
    //Server settings
                       //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'example@host.com';                     //SMTP username
    $mail->Password   = 'yourPassword';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
  
    //Recipients
    $mail->setFrom('email@gmail.com', 'Mailer');
    $mail->addAddress('email', 'Joe doe');     //Add a recipient
    
    
   
  
    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
  
    //Content
    
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = "<h3>Name : $name <br> Email: $email <br> Message : $message</h3>";
    



  
    if(empty($error)){
      if(!$mail->send()){
        $error[] = 'There was an error sending the mail. Please try again!';
      }else{
        $error[] = 'message sent';
      }
    }
    echo json_encode([
      "status" => count($error)==0 ? 1 : 0,
      "error" => $error
      ]);
}
  


