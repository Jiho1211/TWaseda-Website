<?php
// Include PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// Load Composer's autoloader
require_once 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Sanitize and validate inputs
    $name = sanitize_input($_POST['name']);
    $email = sanitize_input($_POST['email']);
    $nationality = sanitize_input($_POST['nationality']);
    $phone = sanitize_input($_POST['phone']);
    $message = sanitize_input($_POST['message']);

    // Basic validation
    if (empty($name) || empty($email) || empty($message)) {
        echo '<p style="color: red;">Please fill in all required fields.</p>';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<p style="color: red;">Invalid email address.</p>';
    } else {
        try {
            // Email settings
            $to = "jihokwak1211@gmail.com";
            $subject = "New Inquiry from $name";
            
            // Email headers
            $headers = array(
                'From: ' . $name . ' <' . $email . '>',
                'Reply-To: ' . $email,
                'X-Mailer: PHP/' . phpversion(),
                'MIME-Version: 1.0',
                'Content-Type: text/html; charset=UTF-8'
            );
            
            // Email body
            $body = "
                <html>
                <head>
                    <title>New Contact Form Submission</title>
                </head>
                <body>
                    <h2>New Contact Form Submission</h2>
                    <p><strong>Name:</strong> $name</p>
                    <p><strong>Email:</strong> $email</p>
                    <p><strong>Nationality:</strong> $nationality</p>
                    <p><strong>Phone:</strong> $phone</p>
                    <p><strong>Message:</strong><br>$message</p>
                </body>
                </html>
            ";
            
            // Send email
            if (mail($to, $subject, $body, implode("\r\n", $headers))) {
                echo '<p style="color: green;">Thank you! Your message has been sent.</p>';
            } else {
                throw new Exception('Failed to send email');
            }
        } catch (Exception $e) {
            echo '<p style="color: red;">There was an issue sending your message. Please try again later.</p>';
            error_log("Mail Error: " . $e->getMessage());
        }
    }
}

// Function to sanitize inputs
function sanitize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}
?>