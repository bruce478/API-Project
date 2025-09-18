<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Import PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require __DIR__  . '/../../vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userEmail = $_POST["email"] ?? '';
    $userName  = $_POST["name"] ?? 'Friend'; // ✅ default if empty

    // Validate email
    if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email address");
    }

    // Create instance
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      
        $mail->isSMTP();                                            
        $mail->Host       = 'smtp.gmail.com';                      
        $mail->SMTPAuth   = true;                                   
        $mail->Username   = 'bruce.mayiani@strathmore.edu';        
        $mail->Password   = 'fujo bxkm ldvu hclu'; // Gmail App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;           
        $mail->Port       = 465;                                   

        // Recipients
        $mail->setFrom('bruce.mayiani@strathmore.edu', 'Bruce Mayiani');
        $mail->addAddress($userEmail, $userName);     

        // Content (✅ Personalized greeting)
        $mail->isHTML(true);                                  
        $mail->Subject = 'Efootball Camp';
        $mail->Body    = "Hello <b>{$userName}</b>,<br><br>
                          Welcome to Efootball Training Gameplay!<br>
                          We’re excited to have you join us.";

        $mail->send();
        echo '✅ Message has been sent to ' . htmlspecialchars($userEmail);
    } catch (Exception $e) {
        echo "❌ Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    // Simple form to collect name + email
    echo "<form method='POST'>
            <input type='text' name='name' placeholder='Enter your name' required><br><br>
            <input type='email' name='email' placeholder='Enter your email' required><br><br>
            <button type='submit'>Send Test Email</button>
          </form>";
}
